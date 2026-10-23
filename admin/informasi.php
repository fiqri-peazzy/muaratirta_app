<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/info.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 3]);

$all_publikasi = selectAll('informasi', [], 'tanggal_buat');

$tagTone = ['Berita' => 'tag-blue', 'Info Gangguan' => 'tag-amber', 'Promo' => 'tag-violet'];
$tagIcon = ['Berita' => 'bi-newspaper', 'Info Gangguan' => 'bi-exclamation-triangle', 'Promo' => 'bi-megaphone'];
$tagCount = array_count_values(array_map(function ($r) {
    return $r['tag'] ?: 'Lainnya';
}, $all_publikasi));

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Berita, info gangguan, dan promo yang tampil di website publik.',
    'actions' => '<a href="' . BASE_URL . '/admin/informasi/tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tulis informasi</a>',
]);
?>

<section class="list-panel cards-sm">
    <div class="list-head">
        <div>
            <h2>Semua Publikasi <span class="count"><?= count($all_publikasi) ?></span></h2>
            <p>Diurutkan dari yang terbaru.</p>
        </div>
        <div class="chips" data-dt-filter="#tbl-info" data-col="1" role="group" aria-label="Filter kategori">
            <button type="button" class="chip active" data-value="">Semua</button>
            <?php foreach ($tagCount as $tag => $n) : ?>
            <button type="button" class="chip" data-value="<?= h($tag) ?>"><?= h($tag) ?> <span class="n"><?= $n ?></span></button>
            <?php endforeach; ?>
        </div>
    </div>

    <table class="data-table table-cards table hover" id="tbl-info" data-search="Cari judul atau penulis…"
        data-empty="Belum ada publikasi. Mulai dengan menulis informasi pertama.">
        <thead>
            <tr>
                <th>Publikasi</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th class="datatable-nosort text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_publikasi as $i) : $tag = $i['tag'] ?: 'Lainnya'; ?>
            <tr>
                <td class="c-primary">
                    <div class="cell-user">
                        <?php if (!empty($i['image'])) : $img = resolveImageUrl($i['image'], 'informasi', ['assets/info']); ?>
                        <a class="thumb" href="<?= h($img) ?>" data-lightbox data-caption="<?= h($i['judul']) ?>"><img src="<?= h($img) ?>" alt="" loading="lazy"></a>
                        <?php else : ?>
                        <span class="thumb"><i class="bi bi-image"></i></span>
                        <?php endif; ?>
                        <div style="min-width:0">
                            <a class="cell-title" href="<?= BASE_URL ?>/admin/informasi/edit.php?id=<?= (int) $i['id'] ?>" title="<?= h($i['judul']) ?>"><?= h($i['judul']) ?></a>
                            <span class="cell-sub"><?= h(adminExcerpt($i['deskripsi'], 90)) ?></span>
                        </div>
                    </div>
                </td>
                <td class="c-status" data-search="<?= h($tag) ?>">
                    <span class="tag <?= $tagTone[$tag] ?? '' ?>"><i class="bi <?= $tagIcon[$tag] ?? 'bi-tag' ?>"></i> <?= h($tag) ?></span>
                </td>
                <td data-label="Penulis"><?= h($i['author'] ?: '-') ?></td>
                <td data-label="Tanggal" data-order="<?= strtotime($i['tanggal_buat']) ?>">
                    <div>
                        <span class="cell-title" style="font-weight:500"><?= h(adminDate($i['tanggal_buat'])) ?></span>
                        <span class="cell-sub"><?= h(adminTimeHint($i['tanggal_buat'])) ?></span>
                    </div>
                </td>
                <td class="c-actions">
                    <div class="row-actions">
                        <?php if (!empty($i['slug'])) : ?>
                        <a class="btn-icon" href="<?= BASE_URL ?>/detail-berita/<?= h($i['slug']) ?>" target="_blank" rel="noopener" title="Lihat di website"><i class="bi bi-box-arrow-up-right"></i></a>
                        <?php endif; ?>
                        <button type="button" class="btn-icon danger" title="Hapus"
                            data-action="<?= BASE_URL ?>/admin/informasi.php" data-method="GET" data-param-hapus="<?= (int) $i['id'] ?>"
                            data-confirm="Hapus publikasi ini?" data-confirm-text="&quot;<?= h(adminExcerpt($i['judul'], 60)) ?>&quot; beserta gambarnya akan dihapus permanen."
                            data-tone="danger" data-remove="tr" data-success="Publikasi berhasil dihapus.">
                            <i class="bi bi-trash3"></i>
                        </button>
                        <a class="btn-chip" href="<?= BASE_URL ?>/admin/informasi/edit.php?id=<?= (int) $i['id'] ?>"><i class="bi bi-pencil-square"></i> Edit</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
