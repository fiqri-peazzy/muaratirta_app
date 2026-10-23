<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/galeri.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 3]);

$all_img = selectAll('galeri', [], 'id');

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Foto kegiatan yang tampil di halaman galeri website. Klik foto untuk memperbesar.',
    'actions' => '<a href="' . BASE_URL . '/admin/galeri/tambah.php" class="btn btn-primary"><i class="bi bi-cloud-arrow-up"></i> Unggah foto</a>',
]);
?>

<section class="list-panel" style="padding:20px">
    <div class="list-head" style="padding:0 0 18px;border:0">
        <div>
            <h2>Semua Foto <span class="count" id="gal-count"><?= count($all_img) ?></span></h2>
            <p>Arahkan kursor ke foto untuk melihat aksi.</p>
        </div>
    </div>

    <div class="gallery-grid">
        <?php foreach ($all_img as $img) : $src = resolveImageUrl($img['image'], 'galeri', ['assets/galeri']); ?>
        <article class="g-item">
            <a class="g-media" href="<?= h($src) ?>" data-lightbox data-caption="<?= h($img['judul']) ?>">
                <img src="<?= h($src) ?>" alt="<?= h($img['judul']) ?>" loading="lazy">
            </a>
            <div class="g-tools">
                <a class="btn-icon" href="<?= h($src) ?>" target="_blank" rel="noopener" title="Buka gambar asli"><i class="bi bi-box-arrow-up-right"></i></a>
                <button type="button" class="btn-icon danger" title="Hapus foto"
                    data-action="<?= BASE_URL ?>/admin/galeri.php" data-method="GET" data-param-hapus-img="<?= (int) $img['id'] ?>"
                    data-confirm="Hapus foto ini?" data-confirm-text="&quot;<?= h($img['judul']) ?>&quot; akan dihapus dari galeri website."
                    data-tone="danger" data-remove=".g-item" data-success="Foto berhasil dihapus.">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
            <div class="g-body">
                <b title="<?= h($img['judul']) ?>"><?= h($img['judul']) ?></b>
                <small><i class="bi bi-calendar3"></i> <?= h(!empty($img['tanggal']) ? adminDate($img['tanggal']) : 'Tanpa tanggal') ?></small>
            </div>
        </article>
        <?php endforeach; ?>

        <a class="g-add" href="<?= BASE_URL ?>/admin/galeri/tambah.php">
            <i class="bi bi-plus-circle"></i>
            <b>Tambah foto baru</b>
            <small>JPG atau PNG, maks. 5 MB</small>
        </a>
    </div>
</section>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
<script>
    // Perbarui angka jumlah foto setelah ada yang dihapus
    document.addEventListener('mt:removed', function () {
        document.getElementById('gal-count').textContent = document.querySelectorAll('.g-item').length;
    });
</script>
</body>

</html>
