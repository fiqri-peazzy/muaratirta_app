<?php
include('../../path.php');
include(ROOT_PATH . '/app/db/db.php');
require ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/app/helpers/r2_helper.php';

use Spipu\Html2Pdf\Html2Pdf;

if (isset($_GET['id'])) {
    $info_pendaftar = selectOne('pasang_baru', ['id' => $_GET['id']]);

    if (!$info_pendaftar) {
        header('Location:' . BASE_URL . '/404');
        exit();
    }

    date_default_timezone_set('Asia/Jakarta');

    // Cegah PDF lama ke-cache di browser/PDF viewer (mis. saat isi/desain diupdate).
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');

    $page_title = 'Formulir Pendaftaran Sambungan Baru - ' . $info_pendaftar['id'];
    $logo_path = ROOT_PATH . '/assets/logo/logo3.png';
    $no_pendaftaran = 'PB-' . str_pad($info_pendaftar['id'], 5, '0', STR_PAD_LEFT);
    $tgl_daftar = date('d F Y, H:i', strtotime($info_pendaftar['created_at'])) . ' WITA';
    $tgl_cetak = date('d F Y, H:i') . ' WITA';
    $status_text = $info_pendaftar['tindak_lanjut'] == 1 ? 'SELESAI DIPROSES' : 'DALAM PROSES';
    $status_color = $info_pendaftar['tindak_lanjut'] == 1 ? '#1e8e3e' : '#b7791f';

    // Ambil foto KTP/rumah ke file lokal (folder lama atau download dari R2 lewat API)
    // supaya Html2Pdf tidak fetch lewat URL publik yang bisa lambat/hang.
    $temp_files = [];
    $resolveLocalPhoto = function ($fileName) use (&$temp_files) {
        if (empty($fileName)) {
            return '';
        }
        foreach (['assets/daftar-baru'] as $legacyDir) {
            $candidate = ROOT_PATH . '/' . $legacyDir . '/' . $fileName;
            if (file_exists($candidate)) {
                return $candidate;
            }
        }
        $temp = downloadR2ToTemp('daftar-baru', $fileName);
        if ($temp) {
            $temp_files[] = $temp;
            return $temp;
        }
        return '';
    };
    $foto_ktp_path = $resolveLocalPhoto($info_pendaftar['foto_ktp']);
    $foto_rumah_path = $resolveLocalPhoto($info_pendaftar['foto_rumah']);

    $fotoBoxHeight = 130;
    $fotoBox = function ($label, $path) use ($fotoBoxHeight) {
        if ($path !== '') {
            return '
            <table style="width:100%;">
                <tr>
                    <td style="background-color:#eef3fb;border:1px solid #c7d4e8;border-bottom:none;padding:4px 8px;font-size:9px;font-weight:700;color:#1c3f7c;text-transform:uppercase;">' . $label . '</td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border:1px solid #c7d4e8;height:' . $fotoBoxHeight . 'px;text-align:center;vertical-align:middle;">
                        <img src="' . $path . '" style="max-height:' . ($fotoBoxHeight - 10) . 'px;max-width:95%;">
                    </td>
                </tr>
            </table>';
        }

        return '
            <table style="width:100%;">
                <tr>
                    <td style="background-color:#eef3fb;border:1px solid #c7d4e8;border-bottom:none;padding:4px 8px;font-size:9px;font-weight:700;color:#1c3f7c;text-transform:uppercase;">' . $label . '</td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border:1px dashed #c7d4e8;background-color:#fafbfc;height:' . $fotoBoxHeight . 'px;text-align:center;vertical-align:middle;">
                        <table style="width:100%;">
                            <tr>
                                <td align="center" style="text-align:center;font-size:9px;color:#a8afba;">Foto tidak tersedia</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';
    };

    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=' . urlencode('https://www.google.com/maps?q=' . str_replace(' ', '+', $info_pendaftar['alamat']));

    $content = '<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>' . $page_title . '</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: helvetica, sans-serif;
        color: #26313f;
    }

    .section-title {
        background-color: #1c3f7c;
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 5px 10px;
        margin-bottom: 6px;
    }

    .data-table td {
        font-size: 10px;
        padding: 3px 4px;
        vertical-align: top;
    }

    .data-label {
        width: 27%;
        color: #5a6472;
    }

    .data-sep {
        width: 3%;
        font-weight: 700;
    }

    .data-value {
        width: 70%;
    }
    </style>
</head>

<body>

    <!-- ===== KOP SURAT RESMI ===== -->
    <table style="width:100%;border-bottom:2px solid #1c3f7c;padding-bottom:6px;margin-bottom:8px;">
        <tr>
            <td style="width:50px;vertical-align:middle;">
                <img src="' . $logo_path . '" style="width:44px;height:44px;">
            </td>
            <td style="vertical-align:middle;padding-left:10px;">
                <div style="font-size:13px;font-weight:700;color:#1c3f7c;letter-spacing:0.5px;">PERUMDA AIR MINUM MUARA TIRTA</div>
                <div style="font-size:11px;font-weight:700;color:#1c3f7c;">KOTA GORONTALO</div>
                <div style="font-size:8px;color:#5a6472;margin-top:2px;">Jl. Drs. Achmad Nadjamuddin, Limba U Dua, Kota Sel., Kota Gorontalo, Gorontalo 96138</div>
                <div style="font-size:8px;color:#5a6472;">Email: cs@muaratirta.co.id &nbsp;|&nbsp; Website: muaratirta.co.id</div>
            </td>
        </tr>
    </table>

    <!-- ===== JUDUL, NO PENDAFTARAN & STATUS (satu baris, padat) ===== -->
    <table style="width:100%;margin-bottom:10px;">
        <tr>
            <td style="width:60%;vertical-align:middle;">
                <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#1c3f7c;">Formulir Pendaftaran Sambungan Baru</div>
                <div style="font-size:8px;color:#5a6472;padding-top:1px;">No. Pendaftaran: <strong style="color:#1c3f7c;">' . $no_pendaftaran . '</strong></div>
            </td>
            <td style="width:40%;text-align:right;vertical-align:middle;">
                <table style="width:100%;">
                    <tr>
                        <td style="width:1%;"></td>
                        <td style="background-color:' . $status_color . ';color:#ffffff;font-size:9px;font-weight:700;padding:4px 8px;text-align:center;white-space:nowrap;">' . $status_text . '</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ===== DATA PEMOHON ===== -->
    <div class="section-title">Data Pemohon</div>
    <table class="data-table" style="width:100%;margin-bottom:10px;">
        <tr>
            <td class="data-label">Nomor HP / WhatsApp</td>
            <td class="data-sep">:</td>
            <td class="data-value" style="font-weight:700;">' . htmlspecialchars($info_pendaftar['no_hp']) . '</td>
        </tr>
        <tr>
            <td class="data-label">Alamat Lengkap</td>
            <td class="data-sep">:</td>
            <td class="data-value">' . htmlspecialchars($info_pendaftar['alamat']) . '</td>
        </tr>
        <tr>
            <td class="data-label">Tanggal Pendaftaran</td>
            <td class="data-sep">:</td>
            <td class="data-value">' . $tgl_daftar . '</td>
        </tr>
        <tr>
            <td class="data-label">Biaya Registrasi</td>
            <td class="data-sep">:</td>
            <td class="data-value" style="font-weight:700;">Rp 20.000</td>
        </tr>
    </table>

    <!-- ===== DOKUMENTASI (2 kotak lebar identik, gap rapi di tengah) ===== -->
    <div class="section-title">Dokumentasi Pendaftar</div>
    <table style="width:100%;margin-bottom:10px;">
        <tr>
            <td style="width:47%;">' . $fotoBox('Foto KTP', $foto_ktp_path) . '</td>
            <td style="width:6%;"></td>
            <td style="width:47%;">' . $fotoBox('Foto Rumah', $foto_rumah_path) . '</td>
        </tr>
    </table>

    <!-- ===== LOKASI & HASIL SURVEY (catatan lebih besar dari kotak QR) ===== -->
    <div class="section-title">Lokasi &amp; Hasil Survey Lapangan</div>
    <table style="width:100%;margin-bottom:10px;">
        <tr>
            <td style="width:65%;vertical-align:top;">
                <table style="width:100%;">
                    <tr>
                        <td style="background-color:#eef3fb;border:1px solid #c7d4e8;border-bottom:none;padding:4px 8px;font-size:9px;font-weight:700;color:#1c3f7c;text-transform:uppercase;">Catatan Petugas Survey</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #c7d4e8;height:160px;"></td>
                    </tr>
                </table>
            </td>
            <td style="width:4%;"></td>
            <td style="width:31%;vertical-align:top;text-align:center;">
                <table style="width:100%;">
                    <tr>
                        <td style="background-color:#eef3fb;border:1px solid #c7d4e8;border-bottom:none;padding:4px 8px;font-size:9px;font-weight:700;color:#1c3f7c;text-transform:uppercase;text-align:center;">Titik Lokasi</td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" style="border:1px solid #c7d4e8;height:160px;text-align:center;vertical-align:middle;">
                            <img src="' . $qrUrl . '" style="width:95px;height:95px;"><br>
                            <span style="font-size:7px;color:#5a6472;">Scan untuk buka Gmaps</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ===== VERIFIKASI PETUGAS (3 kolom sama lebar, gap sama, center) ===== -->
    <div class="section-title">Verifikasi Petugas Lapangan</div>
    <table style="width:100%;margin-top:4px;">
        <tr>
            <td style="width:28%;text-align:center;font-size:9px;">
                <div style="height:44px;"></div>
                <div style="border-top:1px solid #26313f;padding-top:3px;">Nama Petugas</div>
            </td>
            <td style="width:8%;"></td>
            <td style="width:28%;text-align:center;font-size:9px;">
                <div style="height:44px;"></div>
                <div style="border-top:1px solid #26313f;padding-top:3px;">Tanda Tangan</div>
            </td>
            <td style="width:8%;"></td>
            <td style="width:28%;text-align:center;font-size:9px;">
                <div style="height:44px;"></div>
                <div style="border-top:1px solid #26313f;padding-top:3px;">Tanggal</div>
            </td>
        </tr>
    </table>

    <!-- ===== FOOTER ===== -->
    <table style="width:100%;margin-top:14px;border-top:1px solid #d8dee6;padding-top:5px;">
        <tr>
            <td style="width:60%;font-size:7px;color:#9a9a9a;">Dicetak otomatis pada ' . $tgl_cetak . '</td>
            <td style="width:40%;font-size:7px;color:#9a9a9a;text-align:right;">' . $no_pendaftaran . '</td>
        </tr>
    </table>

</body>

</html>
';

    try {
        $html2pdf = new Html2Pdf('P', 'A4', 'en');
        // $html2pdf->setModeDebug();
        $html2pdf->writeHTML($content);
        $html2pdf->output('pendaftaran_' . $no_pendaftaran . '.pdf');
    } catch (\Throwable $e) {
        error_log('cetak_pdf pasang-baru error (id=' . $info_pendaftar['id'] . '): ' . $e->getMessage());
        header('Content-Type: text/plain');
        http_response_code(500);
        echo 'Gagal membuat PDF. Silakan hubungi admin.';
        exit();
    } finally {
        foreach ($temp_files as $temp_file) {
            if (file_exists($temp_file)) {
                unlink($temp_file);
            }
        }
    }
} else {
    header('Location:' . BASE_URL . '/404');
    exit();
}
