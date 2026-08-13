<?php
include('../../path.php');
include(ROOT_PATH . '/app/db/db.php');
require ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/app/helpers/r2_helper.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['id'])) {
    $keluhan = selectOne('pengaduan', ['id' => $_GET['id']]);

    if (!$keluhan) {
        header('Location:' . BASE_URL . '/404');
        exit();
    }

    date_default_timezone_set('Asia/Jakarta');

    // Cegah PDF lama ke-cache di browser/PDF viewer.
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');

    $page_title = 'Laporan Keluhan Pelanggan - ' . $keluhan['id'];
    $logo_path = ROOT_PATH . '/assets/logo/logo3.png';
    $no_pengaduan = 'PG-' . str_pad($keluhan['id'], 5, '0', STR_PAD_LEFT);
    $tgl_lapor = date('d F Y, H:i', strtotime($keluhan['created_at'])) . ' WITA';
    $tgl_cetak = date('d F Y, H:i') . ' WITA';
    $status_text = $keluhan['status'] == 1 ? 'SELESAI DIPROSES' : 'DALAM PROSES';
    $status_color = $keluhan['status'] == 1 ? '#1e8e3e' : '#b7791f';

    // Ambil foto ke file lokal (folder lama atau download dari R2 lewat API)
    // supaya render PDF tidak fetch lewat URL publik yang bisa lambat/hang.
    $foto_temp_file = null;
    $foto_local_path = '';
    if (!empty($keluhan['foto'])) {
        $file_extension = strtolower(pathinfo($keluhan['foto'], PATHINFO_EXTENSION));
        if (in_array($file_extension, ['jpg', 'jpeg', 'png'])) {
            foreach (['assets/keluhan', 'image/pengaduan'] as $legacyDir) {
                $candidate = ROOT_PATH . '/' . $legacyDir . '/' . $keluhan['foto'];
                if (file_exists($candidate)) {
                    $foto_local_path = $candidate;
                    break;
                }
            }
            if ($foto_local_path === '') {
                $foto_temp_file = downloadR2ToTemp('pengaduan', $keluhan['foto']);
                $foto_local_path = $foto_temp_file ?: '';
            }
        }
    }

    $content = '<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>' . $page_title . '</title>
    <style>
    @page {
        margin-top: 22mm;
        margin-right: 18mm;
        margin-bottom: 18mm;
        margin-left: 18mm;
    }

    body, table, tr, td, div, span, strong, a, img, h1, h2, h3, h4, h5, p {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        color: #26313f;
        line-height: 1.4;
    }

    .section-title {
        background-color: #1c3f7c;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 6px 10px;
        margin-bottom: 8px;
    }

    .data-table td {
        font-size: 11px;
        padding: 4px 4px;
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
                <div style="font-size:15px;font-weight:700;color:#1c3f7c;letter-spacing:0.5px;">PERUMDA AIR MINUM MUARA TIRTA</div>
                <div style="font-size:12px;font-weight:700;color:#1c3f7c;">KOTA GORONTALO</div>
                <div style="font-size:10px;color:#5a6472;margin-top:3px;">Jl. Drs. Achmad Nadjamuddin, Limba U Dua, Kota Sel., Kota Gorontalo, Gorontalo 96138</div>
                <div style="font-size:10px;color:#5a6472;">Email: cs@muaratirta.co.id &nbsp;|&nbsp; Website: muaratirta.co.id</div>
            </td>
        </tr>
    </table>

    <!-- ===== JUDUL, NO PENGADUAN & STATUS ===== -->
    <table style="width:100%;margin-bottom:10px;">
        <tr>
            <td style="width:60%;vertical-align:middle;">
                <div style="font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#1c3f7c;">Laporan Keluhan Pelanggan</div>
                <div style="font-size:10px;color:#5a6472;padding-top:2px;">No. Pengaduan: <strong style="color:#1c3f7c;">' . $no_pengaduan . '</strong></div>
            </td>
            <td style="width:40%;text-align:right;vertical-align:middle;">
                <table style="width:100%;">
                    <tr>
                        <td style="width:1%;"></td>
                        <td style="background-color:' . $status_color . ';color:#ffffff;font-size:10px;font-weight:700;padding:5px 10px;text-align:center;white-space:nowrap;">' . $status_text . '</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ===== DATA PELANGGAN ===== -->
    <div class="section-title">Data Pelanggan</div>
    <table class="data-table" style="width:100%;margin-bottom:10px;">
        <tr>
            <td class="data-label">No. Sambungan (ID Pelanggan)</td>
            <td class="data-sep">:</td>
            <td class="data-value" style="font-weight:700;">' . htmlspecialchars($keluhan['id_pel']) . '</td>
        </tr>
        <tr>
            <td class="data-label">Nama Lengkap</td>
            <td class="data-sep">:</td>
            <td class="data-value">' . htmlspecialchars($keluhan['nm_lengkap']) . '</td>
        </tr>
        <tr>
            <td class="data-label">Nomor HP / WhatsApp</td>
            <td class="data-sep">:</td>
            <td class="data-value">' . htmlspecialchars($keluhan['no_hp']) . '</td>
        </tr>
        <tr>
            <td class="data-label">Alamat Lengkap</td>
            <td class="data-sep">:</td>
            <td class="data-value">' . htmlspecialchars($keluhan['alamat']) . '</td>
        </tr>
        <tr>
            <td class="data-label">Tanggal Lapor</td>
            <td class="data-sep">:</td>
            <td class="data-value">' . $tgl_lapor . '</td>
        </tr>
    </table>

    <!-- ===== ISI KELUHAN ===== -->
    <div class="section-title">Isi Keluhan</div>
    <table style="width:100%;margin-bottom:10px;">
        <tr>
            <td style="border:1px solid #c7d4e8;padding:10px;font-size:11px;min-height:60px;">' . nl2br(htmlspecialchars($keluhan['isi_pengaduan'])) . '</td>
        </tr>
    </table>

    <!-- ===== DOKUMENTASI ===== -->
    <div class="section-title">Dokumentasi Foto</div>
    <table style="width:100%;margin-bottom:10px;">
        <tr>
            <td style="width:47%;">
                ' . ($foto_local_path !== ''
        ? '<table style="width:100%;">
                        <tr>
                            <td style="border:1px solid #c7d4e8;height:170px;text-align:center;vertical-align:middle;">
                                <img src="' . $foto_local_path . '" style="max-height:160px;max-width:95%;">
                            </td>
                        </tr>
                    </table>'
        : '<table style="width:100%;">
                        <tr>
                            <td style="border:1px dashed #c7d4e8;background-color:#fafbfc;height:170px;text-align:center;vertical-align:middle;">
                                <span style="font-size:10px;color:#a8afba;">Foto tidak tersedia</span>
                            </td>
                        </tr>
                    </table>') . '
            </td>
            <td style="width:6%;"></td>
            <td style="width:47%;"></td>
        </tr>
    </table>

    <!-- ===== VERIFIKASI PETUGAS (3 kolom sama lebar, gap sama, center) ===== -->
    <div class="section-title">Verifikasi Petugas</div>
    <table style="width:100%;margin-top:4px;">
        <tr>
            <td style="width:28%;text-align:center;font-size:10px;">
                <div style="height:44px;"></div>
                <div style="border-top:1px solid #26313f;padding-top:3px;">Nama Petugas</div>
            </td>
            <td style="width:8%;"></td>
            <td style="width:28%;text-align:center;font-size:10px;">
                <div style="height:44px;"></div>
                <div style="border-top:1px solid #26313f;padding-top:3px;">Tanda Tangan</div>
            </td>
            <td style="width:8%;"></td>
            <td style="width:28%;text-align:center;font-size:10px;">
                <div style="height:44px;"></div>
                <div style="border-top:1px solid #26313f;padding-top:3px;">Tanggal</div>
            </td>
        </tr>
    </table>

    <!-- ===== FOOTER ===== -->
    <table style="width:100%;margin-top:14px;border-top:1px solid #d8dee6;padding-top:5px;">
        <tr>
            <td style="width:60%;font-size:9px;color:#9a9a9a;">Dicetak otomatis pada ' . $tgl_cetak . '</td>
            <td style="width:40%;font-size:9px;color:#9a9a9a;text-align:right;">' . $no_pengaduan . '</td>
        </tr>
    </table>

</body>

</html>
';

    try {
        $options = new Options();
        $options->set('isRemoteEnabled', true); // dibutuhkan untuk fetch QR code dari api.qrserver.com
        $options->set('defaultFont', 'Times New Roman');
        // Izinkan dompdf baca file lokal dari folder project DAN dari sys temp dir
        // (foto yang didownload dari R2 disimpan ke temp dir lewat downloadR2ToTemp()).
        $options->setChroot([ROOT_PATH, sys_get_temp_dir()]);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('keluhan_' . $keluhan['id_pel'] . '.pdf', ['Attachment' => false]);
    } catch (\Throwable $e) {
        error_log('cetak_pengaduan PDF error (id=' . $keluhan['id'] . '): ' . $e->getMessage());
        header('Content-Type: text/plain');
        http_response_code(500);
        echo 'Gagal membuat PDF. Silakan hubungi admin.';
        exit();
    } finally {
        if ($foto_temp_file !== null && file_exists($foto_temp_file)) {
            unlink($foto_temp_file);
        }
    }
} else {
    header('Location:' . BASE_URL . '/404');
    exit();
}
