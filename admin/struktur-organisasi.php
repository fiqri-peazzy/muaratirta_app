<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/struktur-organisasi.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1]);

$bagian = selectAll('jabatan');

$stmt = $conn->prepare('SELECT s.*, j.bagian FROM staff AS s INNER JOIN jabatan AS j ON s.kd_bagian = j.kd_bagian ORDER BY j.bagian, s.nm_lengkap');
prepStmtForFetch($stmt);
$stmt->execute();
$staffList = stmtFetchAllAssoc($stmt);

$staffPerBagian = array_count_values(array_column($staffList, 'kd_bagian'));

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Bagian dan staff yang tampil di halaman Struktur Organisasi website.',
    'actions' => '<a href="' . BASE_URL . '/admin/struktur-organisasi/add-bagian.php" class="btn btn-ghost"><i class="bi bi-diagram-3"></i> Tambah bagian</a>'
        . '<a href="' . BASE_URL . '/admin/struktur-organisasi/add-staff.php" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah staff</a>',
]);
?>

<div class="row">
    <div class="col-xl-4">
        <section class="panel">
            <div class="panel-head">
                <div>
                    <h3>Bagian</h3>
                    <p><?= count($bagian) ?> bagian · <?= count($staffList) ?> staff</p>
                </div>
                <a class="panel-link" href="<?= BASE_URL ?>/admin/struktur-organisasi/add-bagian.php"><i class="bi bi-plus-lg"></i> Tambah</a>
            </div>
            <div class="panel-body p-0">
                <?php if (!$bagian) : ?>
                <div class="empty-state"><i class="bi bi-diagram-3"></i>Belum ada bagian.</div>
                <?php endif; ?>
                <ul class="feed">
                    <?php foreach ($bagian as $bgn) : $n = $staffPerBagian[$bgn['kd_bagian']] ?? 0; ?>
                    <li>
                        <div class="feed-row">
                            <span class="avatar <?= adminAvatarTone($bgn['bagian']) ?>"><?= h(adminInitials($bgn['bagian'])) ?></span>
                            <span class="feed-main">
                                <span class="feed-title"><?= h($bgn['bagian']) ?></span>
                                <span class="feed-sub"><span class="mono"><?= h($bgn['kd_bagian']) ?></span> · <?= $n ?> staff</span>
                            </span>
                            <span class="row-actions">
                                <a class="btn-icon" href="<?= BASE_URL ?>/admin/struktur-organisasi/edit-bagian.php?id=<?= urlencode($bgn['kd_bagian']) ?>" title="Edit bagian"><i class="bi bi-pencil-square"></i></a>
                                <button type="button" class="btn-icon danger" title="Hapus bagian"
                                    data-action="<?= BASE_URL ?>/admin/struktur-organisasi/delete-bagian.php" data-param-id="<?= (int) $bgn['id'] ?>"
                                    data-confirm="Hapus bagian <?= h($bgn['bagian']) ?>?"
                                    data-confirm-text="<?= $n ? $n . ' staff di bagian ini tidak akan tampil di website sampai dipindah ke bagian lain.' : 'Bagian ini belum punya staff.' ?>"
                                    data-tone="danger" data-remove="li" data-success="Bagian berhasil dihapus.">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </span>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    </div>

    <div class="col-xl-8">
        <section class="list-panel cards-sm">
            <div class="list-head">
                <div>
                    <h2>Staff <span class="count"><?= count($staffList) ?></span></h2>
                    <p>Diurutkan berdasarkan bagian.</p>
                </div>
            </div>
            <table class="data-table table-cards table hover" id="tbl-staff" data-search="Cari nama, bagian, jabatan…"
                data-empty="Belum ada staff.">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Bagian</th>
                        <th>Jabatan</th>
                        <th class="datatable-nosort text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staffList as $staff) : ?>
                    <tr>
                        <td class="c-primary">
                            <div class="cell-user">
                                <span class="avatar <?= adminAvatarTone($staff['nm_lengkap']) ?>">
                                    <?php if (!empty($staff['profile_pict'])) : ?>
                                    <img src="<?= h(resolveImageUrl($staff['profile_pict'], 'staff', ['assets/staff'])) ?>" alt="" loading="lazy">
                                    <?php else : ?>
                                    <?= h(adminInitials($staff['nm_lengkap'])) ?>
                                    <?php endif; ?>
                                </span>
                                <span class="cell-title"><?= h($staff['nm_lengkap']) ?></span>
                            </div>
                        </td>
                        <td data-label="Bagian"><span class="tag"><?= h($staff['bagian']) ?></span></td>
                        <td data-label="Jabatan"><?= h($staff['jabatan']) ?></td>
                        <td class="c-actions">
                            <div class="row-actions">
                                <button type="button" class="btn-icon danger" title="Hapus staff"
                                    data-action="<?= BASE_URL ?>/admin/struktur-organisasi/delete-staff-handler.php" data-param-id="<?= (int) $staff['id'] ?>"
                                    data-confirm="Hapus <?= h($staff['nm_lengkap']) ?>?" data-confirm-text="Staff dan fotonya akan dihapus dari struktur organisasi."
                                    data-tone="danger" data-remove="tr" data-success="Staff berhasil dihapus.">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                <a class="btn-chip" href="<?= BASE_URL ?>/admin/struktur-organisasi/edit-staff.php?id=<?= (int) $staff['id'] ?>"><i class="bi bi-pencil-square"></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
