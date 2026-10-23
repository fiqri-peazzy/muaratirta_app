<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/info.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');
adminOnly();
adminLevel([1, 2]);
require_once ROOT_PATH . '/admin/inc/consoleNav.php';

$pengaduan = empty($_GET['id']) ? null : selectOne('pengaduan', ['id' => $_GET['id']]);
if (!$pengaduan) {
    $_SESSION['message'] = 'Pengaduan tidak ditemukan atau sudah dihapus.';
    $_SESSION['type'] = 'error';
    header('Location: ' . BASE_URL . '/admin/pengaduan.php');
    exit();
}

$no_pengaduan = 'PG-' . str_pad($pengaduan['id'], 5, '0', STR_PAD_LEFT);
$open = (int) $pengaduan['status'] === 0;
$foto_url = '';
if (!empty($pengaduan['foto']) && in_array(strtolower(pathinfo($pengaduan['foto'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'], true)) {
    $foto_url = resolveImageUrl($pengaduan['foto'], 'pengaduan', ['assets/keluhan', 'image/pengaduan']);
}
$wa = adminWaLink($pengaduan['no_hp'], 'Halo ' . $pengaduan['nm_lengkap'] . ', kami dari PERUMDA Air Minum Muara Tirta terkait pengaduan ' . $no_pengaduan . '.');
$listUrl = BASE_URL . '/admin/pengaduan.php';

$pageTitle = 'Pengaduan ' . $no_pengaduan;
include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'title' => 'Pengaduan ' . $pengaduan['nm_lengkap'],
    'crumb' => $no_pengaduan,
    'back' => $listUrl,
    'meta' => '<div class="meta-line"><span class="ref-no">' . $no_pengaduan . '</span>'
        . '<span><i class="bi bi-calendar3"></i> ' . h(adminDate($pengaduan['created_at'], true)) . '</span>'
        . '<span><i class="bi bi-clock"></i> ' . h(adminAgo($pengaduan['created_at'])) . '</span></div>',
    'actions' => ($wa ? '<a href="' . h($wa) . '" target="_blank" rel="noopener" class="btn btn-success-soft"><i class="bi bi-whatsapp"></i> WhatsApp</a>' : '')
        . '<a href="' . BASE_URL . '/admin/pengaduan/cetak_pengaduan.php?id=' . (int) $pengaduan['id'] . '" target="_blank" class="btn btn-ghost"><i class="bi bi-printer"></i> Cetak PDF</a>',
]);
?>

<div class="status-banner is-open" id="sb-open" <?= $open ? '' : 'hidden' ?>>
    <span class="sb-icon"><i class="bi bi-hourglass-split"></i></span>
    <div>
        <b>Menunggu tindak lanjut</b>
        <small>Hubungi pelanggan, tangani gangguannya, lalu tandai selesai.</small>
    </div>
    <div class="sb-actions">
        <button type="button" class="btn btn-success"
            data-action="<?= BASE_URL ?>/admin/pengaduan/update-keluhan.php" data-param-id="<?= (int) $pengaduan['id'] ?>"
            data-confirm="Tandai pengaduan ini selesai?" data-confirm-text="Pastikan keluhan pelanggan sudah benar-benar ditangani."
            data-confirm-btn="Ya, sudah selesai" data-tone="success" data-success="Pengaduan ditandai selesai." id="btn-done">
            <i class="bi bi-check2-circle"></i> Tandai selesai
        </button>
    </div>
</div>
<div class="status-banner is-done" id="sb-done" <?= $open ? 'hidden' : '' ?>>
    <span class="sb-icon"><i class="bi bi-check2-circle"></i></span>
    <div>
        <b>Pengaduan sudah selesai ditangani</b>
        <small>Data bisa dicetak sebagai arsip atau dihapus jika sudah tidak diperlukan.</small>
    </div>
    <div class="sb-actions">
        <button type="button" class="btn btn-danger-soft"
            data-action="<?= BASE_URL ?>/admin/pengaduan/hapus-keluhan.php" data-param-id="<?= (int) $pengaduan['id'] ?>"
            data-confirm="Hapus pengaduan <?= $no_pengaduan ?>?" data-confirm-text="Data dan foto bukti akan dihapus permanen."
            data-tone="danger" data-success="Pengaduan berhasil dihapus." data-redirect="<?= $listUrl ?>">
            <i class="bi bi-trash3"></i> Hapus
        </button>
    </div>
</div>

<div class="detail-grid">
    <div style="min-width:0">
        <section class="panel">
            <div class="panel-head">
                <div>
                    <h3><i class="bi bi-chat-left-text text-muted"></i> Isi keluhan</h3>
                    <p>Ditulis langsung oleh pelanggan.</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="quote-box"><?= h($pengaduan['isi_pengaduan']) ?></div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">
                <div>
                    <h3><i class="bi bi-image text-muted"></i> Foto bukti</h3>
                    <p><?= $foto_url ? 'Klik foto untuk memperbesar.' : 'Pelanggan tidak melampirkan foto.' ?></p>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($foto_url) : ?>
                <a class="photo-card" href="<?= h($foto_url) ?>" data-lightbox data-caption="Foto bukti <?= $no_pengaduan ?>" style="max-width:560px">
                    <img src="<?= h($foto_url) ?>" alt="Foto bukti pengaduan">
                    <span class="pc-label"><i class="bi bi-zoom-in"></i> Perbesar</span>
                </a>
                <?php else : ?>
                <div class="photo-empty" style="max-width:560px"><i class="bi bi-image"></i>Tidak ada foto</div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <aside class="side-card">
        <section class="panel">
            <div class="panel-head"><h3><i class="bi bi-person text-muted"></i> Data pelanggan</h3></div>
            <div class="panel-body">
                <ul class="kv">
                    <li><span class="kv-icon"><i class="bi bi-person"></i></span>
                        <span class="kv-body"><span class="kv-label">Nama lengkap</span><span class="kv-value"><?= h($pengaduan['nm_lengkap']) ?></span></span></li>
                    <li><span class="kv-icon"><i class="bi bi-hash"></i></span>
                        <span class="kv-body"><span class="kv-label">No. sambungan (ID pelanggan)</span><span class="kv-value mono"><?= h($pengaduan['id_pel'] ?: '-') ?></span></span>
                        <?php if ($pengaduan['id_pel']) : ?><span class="kv-tools"><button type="button" class="btn-icon" data-copy="<?= h($pengaduan['id_pel']) ?>" title="Salin"><i class="bi bi-clipboard"></i></button></span><?php endif; ?></li>
                    <li><span class="kv-icon"><i class="bi bi-telephone"></i></span>
                        <span class="kv-body"><span class="kv-label">No. HP / WhatsApp</span><span class="kv-value"><?= h($pengaduan['no_hp'] ?: '-') ?></span></span>
                        <?php if ($pengaduan['no_hp']) : ?><span class="kv-tools">
                            <a class="btn-icon" href="tel:<?= h(preg_replace('/[^\d+]/', '', $pengaduan['no_hp'])) ?>" title="Telepon"><i class="bi bi-telephone"></i></a>
                            <?php if ($wa) : ?><a class="btn-icon success" href="<?= h($wa) ?>" target="_blank" rel="noopener" title="WhatsApp"><i class="bi bi-whatsapp"></i></a><?php endif; ?>
                        </span><?php endif; ?></li>
                    <li><span class="kv-icon"><i class="bi bi-geo-alt"></i></span>
                        <span class="kv-body"><span class="kv-label">Alamat</span><span class="kv-value"><?= h($pengaduan['alamat'] ?: '-') ?></span></span>
                        <?php if ($pengaduan['alamat']) : ?><span class="kv-tools"><a class="btn-icon" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($pengaduan['alamat'] . ', Kota Gorontalo') ?>" target="_blank" rel="noopener" title="Buka di Google Maps"><i class="bi bi-map"></i></a></span><?php endif; ?></li>
                </ul>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head"><h3><i class="bi bi-clock-history text-muted"></i> Progres</h3></div>
            <div class="panel-body">
                <ul class="timeline-mini" id="progress">
                    <li class="done"><span class="tm-dot"><i class="bi bi-check"></i></span>
                        <b>Pengaduan diterima</b><small><?= h(adminDate($pengaduan['created_at'], true)) ?></small></li>
                    <li class="<?= $open ? 'current' : 'done' ?>" data-step="proses"><span class="tm-dot"><i class="bi <?= $open ? 'bi-three-dots' : 'bi-check' ?>"></i></span>
                        <b>Ditindaklanjuti petugas</b><small><?= $open ? 'Sedang berjalan' : 'Sudah ditangani' ?></small></li>
                    <li class="<?= $open ? '' : 'done' ?>" data-step="selesai"><span class="tm-dot"><i class="bi bi-check"></i></span>
                        <b>Selesai</b><small><?= $open ? 'Belum' : 'Pengaduan ditutup' ?></small></li>
                </ul>
            </div>
        </section>
    </aside>
</div>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
<script>
    // Setelah ditandai selesai: ganti banner & progres tanpa memuat ulang halaman
    document.getElementById('btn-done').addEventListener('mt:done', function () {
        document.getElementById('sb-open').hidden = true;
        document.getElementById('sb-done').hidden = false;
        document.querySelectorAll('#progress li').forEach(function (li) {
            li.className = 'done';
            li.querySelector('.tm-dot').innerHTML = '<i class="bi bi-check"></i>';
        });
        document.querySelector('[data-step="proses"] small').textContent = 'Sudah ditangani';
        document.querySelector('[data-step="selesai"] small').textContent = 'Pengaduan ditutup';
    });
</script>
</body>

</html>
