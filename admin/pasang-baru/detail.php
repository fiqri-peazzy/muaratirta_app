<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/info.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 2]);
require_once ROOT_PATH . '/admin/inc/consoleNav.php';

$pasang_baru = empty($_GET['id']) ? null : selectOne('pasang_baru', ['id' => $_GET['id']]);
if (!$pasang_baru) {
    $_SESSION['message'] = 'Data pendaftaran tidak ditemukan atau sudah dihapus.';
    $_SESSION['type'] = 'error';
    header('Location: ' . BASE_URL . '/admin/pasang-baru.php');
    exit();
}

$hasCoord = $pasang_baru['latitude'] !== null && $pasang_baru['latitude'] !== '' && $pasang_baru['longitude'] !== null && $pasang_baru['longitude'] !== '';
$q = $hasCoord ? $pasang_baru['latitude'] . ',' . $pasang_baru['longitude'] : $pasang_baru['alamat'];
$mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($q);

$no_pendaftaran = 'PB-' . str_pad($pasang_baru['id'], 5, '0', STR_PAD_LEFT);
$open = (int) $pasang_baru['tindak_lanjut'] === 0;
$foto_ktp_url = resolveImageUrl($pasang_baru['foto_ktp'], 'daftar-baru', ['assets/daftar-baru']);
$foto_rumah_url = resolveImageUrl($pasang_baru['foto_rumah'], 'daftar-baru', ['assets/daftar-baru']);
$wa = adminWaLink($pasang_baru['no_hp'], 'Halo, kami dari PERUMDA Air Minum Muara Tirta terkait pendaftaran sambungan baru ' . $no_pendaftaran . '.');
$listUrl = BASE_URL . '/admin/pasang-baru.php';

$pageTitle = 'Pendaftaran ' . $no_pendaftaran;
include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'title' => 'Pendaftaran Sambungan Baru',
    'crumb' => $no_pendaftaran,
    'back' => $listUrl,
    'meta' => '<div class="meta-line"><span class="ref-no">' . $no_pendaftaran . '</span>'
        . '<span><i class="bi bi-calendar3"></i> ' . h(adminDate($pasang_baru['created_at'], true)) . '</span>'
        . '<span><i class="bi bi-clock"></i> ' . h(adminAgo($pasang_baru['created_at'])) . '</span></div>',
    'actions' => ($wa ? '<a href="' . h($wa) . '" target="_blank" rel="noopener" class="btn btn-success-soft"><i class="bi bi-whatsapp"></i> WhatsApp</a>' : '')
        . '<a href="' . BASE_URL . '/admin/pasang-baru/cetak_pdf.php?id=' . (int) $pasang_baru['id'] . '" target="_blank" class="btn btn-ghost"><i class="bi bi-printer"></i> Cetak formulir</a>',
]);
?>

<div class="status-banner is-open" id="sb-open" <?= $open ? '' : 'hidden' ?>>
    <span class="sb-icon"><i class="bi bi-hourglass-split"></i></span>
    <div>
        <b>Menunggu verifikasi &amp; survei</b>
        <small>Periksa dokumen, jadwalkan survei lokasi, lalu tandai selesai setelah pemasangan.</small>
    </div>
    <div class="sb-actions">
        <button type="button" class="btn btn-success" id="btn-done"
            data-action="<?= BASE_URL ?>/admin/pasang-baru/update-p-baru.php" data-param-id="<?= (int) $pasang_baru['id'] ?>"
            data-confirm="Tandai pendaftaran ini selesai?" data-confirm-text="Pastikan sambungan baru sudah terpasang atau permohonan sudah diproses."
            data-confirm-btn="Ya, sudah selesai" data-tone="success" data-success="Pendaftaran ditandai selesai.">
            <i class="bi bi-check2-circle"></i> Tandai selesai
        </button>
    </div>
</div>
<div class="status-banner is-done" id="sb-done" <?= $open ? 'hidden' : '' ?>>
    <span class="sb-icon"><i class="bi bi-check2-circle"></i></span>
    <div>
        <b>Pendaftaran sudah selesai diproses</b>
        <small>Cetak formulir sebagai arsip, atau hapus jika sudah tidak diperlukan.</small>
    </div>
    <div class="sb-actions">
        <button type="button" class="btn btn-danger-soft"
            data-action="<?= BASE_URL ?>/admin/pengaduan/hapus-keluhan.php" data-param-id_p="<?= (int) $pasang_baru['id'] ?>"
            data-confirm="Hapus pendaftaran <?= $no_pendaftaran ?>?" data-confirm-text="Data dan foto dokumen (KTP & rumah) akan dihapus permanen."
            data-tone="danger" data-success="Pendaftaran berhasil dihapus." data-redirect="<?= $listUrl ?>">
            <i class="bi bi-trash3"></i> Hapus
        </button>
    </div>
</div>

<div class="detail-grid">
    <div style="min-width:0">
        <section class="panel">
            <div class="panel-head">
                <div>
                    <h3><i class="bi bi-file-earmark-text text-muted"></i> Dokumen pemohon</h3>
                    <p>Klik foto untuk memperbesar dan cek keterbacaannya.</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="photo-grid">
                    <?php foreach ([['KTP', $foto_ktp_url, 'bi-person-badge'], ['Rumah', $foto_rumah_url, 'bi-house-door']] as [$label, $url, $icon]) : ?>
                    <?php if ($url !== '') : ?>
                    <a class="photo-card" href="<?= h($url) ?>" data-lightbox data-caption="Foto <?= $label ?> · <?= $no_pendaftaran ?>">
                        <img src="<?= h($url) ?>" alt="Foto <?= $label ?>" loading="lazy">
                        <span class="pc-label"><i class="bi <?= $icon ?>"></i> Foto <?= $label ?></span>
                    </a>
                    <?php else : ?>
                    <div class="photo-empty"><i class="bi <?= $icon ?>"></i>Foto <?= $label ?> belum diunggah</div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">
                <div>
                    <h3><i class="bi bi-geo-alt text-muted"></i> Lokasi pemasangan</h3>
                    <p><?= $hasCoord ? 'Titik koordinat dari GPS pemohon.' : 'Berdasarkan alamat tertulis (pemohon tidak membagikan GPS).' ?></p>
                </div>
                <a class="panel-link" href="<?= h($mapsUrl) ?>" target="_blank" rel="noopener">Buka Maps <i class="bi bi-box-arrow-up-right"></i></a>
            </div>
            <div class="panel-body">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="map-frame">
                            <iframe src="https://www.google.com/maps?q=<?= urlencode($q) ?>&z=16&output=embed" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" title="Peta lokasi"></iframe>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&margin=6&data=<?= urlencode($mapsUrl) ?>"
                            alt="QR lokasi" width="140" height="140" style="border-radius:12px;border:1px solid var(--c-border);background:#fff">
                        <div class="field-hint justify-content-center mt-2">Pindai untuk navigasi petugas</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <aside class="side-card">
        <section class="panel">
            <div class="panel-head"><h3><i class="bi bi-person text-muted"></i> Data pemohon</h3></div>
            <div class="panel-body">
                <ul class="kv">
                    <li><span class="kv-icon"><i class="bi bi-hash"></i></span>
                        <span class="kv-body"><span class="kv-label">No. registrasi</span><span class="kv-value mono"><?= $no_pendaftaran ?></span></span>
                        <span class="kv-tools"><button type="button" class="btn-icon" data-copy="<?= $no_pendaftaran ?>" title="Salin"><i class="bi bi-clipboard"></i></button></span></li>
                    <li><span class="kv-icon"><i class="bi bi-telephone"></i></span>
                        <span class="kv-body"><span class="kv-label">No. HP / WhatsApp</span><span class="kv-value"><?= h($pasang_baru['no_hp'] ?: '-') ?></span></span>
                        <?php if ($pasang_baru['no_hp']) : ?><span class="kv-tools">
                            <a class="btn-icon" href="tel:<?= h(preg_replace('/[^\d+]/', '', $pasang_baru['no_hp'])) ?>" title="Telepon"><i class="bi bi-telephone"></i></a>
                            <?php if ($wa) : ?><a class="btn-icon success" href="<?= h($wa) ?>" target="_blank" rel="noopener" title="WhatsApp"><i class="bi bi-whatsapp"></i></a><?php endif; ?>
                        </span><?php endif; ?></li>
                    <li><span class="kv-icon"><i class="bi bi-geo-alt"></i></span>
                        <span class="kv-body"><span class="kv-label">Alamat lengkap</span><span class="kv-value"><?= h($pasang_baru['alamat'] ?: '-') ?></span></span></li>
                    <?php if ($hasCoord) : ?>
                    <li><span class="kv-icon"><i class="bi bi-pin-map"></i></span>
                        <span class="kv-body"><span class="kv-label">Koordinat</span><span class="kv-value mono"><?= h($pasang_baru['latitude'] . ', ' . $pasang_baru['longitude']) ?></span></span>
                        <span class="kv-tools"><button type="button" class="btn-icon" data-copy="<?= h($pasang_baru['latitude'] . ',' . $pasang_baru['longitude']) ?>" title="Salin"><i class="bi bi-clipboard"></i></button></span></li>
                    <?php endif; ?>
                    <li><span class="kv-icon"><i class="bi bi-cash-coin"></i></span>
                        <span class="kv-body"><span class="kv-label">Biaya registrasi</span><span class="kv-value">Rp 20.000</span></span></li>
                </ul>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head"><h3><i class="bi bi-clock-history text-muted"></i> Progres</h3></div>
            <div class="panel-body">
                <ul class="timeline-mini" id="progress">
                    <li class="done"><span class="tm-dot"><i class="bi bi-check"></i></span>
                        <b>Pendaftaran diterima</b><small><?= h(adminDate($pasang_baru['created_at'], true)) ?></small></li>
                    <li class="<?= $open ? 'current' : 'done' ?>"><span class="tm-dot"><i class="bi <?= $open ? 'bi-three-dots' : 'bi-check' ?>"></i></span>
                        <b>Verifikasi dokumen &amp; survei</b><small data-open="Sedang berjalan" data-done="Sudah dilakukan"><?= $open ? 'Sedang berjalan' : 'Sudah dilakukan' ?></small></li>
                    <li class="<?= $open ? '' : 'done' ?>"><span class="tm-dot"><i class="bi bi-check"></i></span>
                        <b>Selesai</b><small data-open="Belum" data-done="Permohonan ditutup"><?= $open ? 'Belum' : 'Permohonan ditutup' ?></small></li>
                </ul>
            </div>
        </section>
    </aside>
</div>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
<script>
    document.getElementById('btn-done').addEventListener('mt:done', function () {
        document.getElementById('sb-open').hidden = true;
        document.getElementById('sb-done').hidden = false;
        document.querySelectorAll('#progress li').forEach(function (li) {
            li.className = 'done';
            li.querySelector('.tm-dot').innerHTML = '<i class="bi bi-check"></i>';
            var s = li.querySelector('small[data-done]');
            if (s) s.textContent = s.dataset.done;
        });
    });
</script>
</body>

</html>
