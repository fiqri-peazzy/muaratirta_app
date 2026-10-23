<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1]);

$all_user = selectAll('users');
$me = currentAdmin();
$roleTone = [1 => 'tag-blue', 2 => 'tag-green', 3 => 'tag-violet'];
$roleIcon = [1 => 'bi-shield-check', 2 => 'bi-headset', 3 => 'bi-archive'];
$roleCount = array_count_values(array_map(function ($u) {
    return (int) $u['level'];
}, $all_user));

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Akun yang bisa masuk ke panel admin beserta hak aksesnya.',
    'actions' => '<a href="' . BASE_URL . '/admin/users/add-user.php" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah user</a>',
]);
?>

<section class="mini-stats">
    <div class="mini-stat tone-blue"><span class="kpi-icon"><i class="bi bi-people"></i></span>
        <div><b><?= count($all_user) ?></b><small>Total akun</small></div>
    </div>
    <div class="mini-stat tone-blue"><span class="kpi-icon"><i class="bi bi-shield-check"></i></span>
        <div><b><?= $roleCount[1] ?? 0 ?></b><small>Administrator</small></div>
    </div>
    <div class="mini-stat tone-green"><span class="kpi-icon"><i class="bi bi-headset"></i></span>
        <div><b><?= $roleCount[2] ?? 0 ?></b><small>Customer Service</small></div>
    </div>
    <div class="mini-stat tone-violet"><span class="kpi-icon"><i class="bi bi-archive"></i></span>
        <div><b><?= $roleCount[3] ?? 0 ?></b><small>Arsip &amp; Publikasi</small></div>
    </div>
</section>

<section class="list-panel cards-sm">
    <div class="list-head">
        <div>
            <h2>Daftar Akun <span class="count"><?= count($all_user) ?></span></h2>
            <p>Hak akses menentukan menu yang tampil untuk tiap akun.</p>
        </div>
    </div>

    <table class="data-table table-cards table hover" id="tbl-users" data-search="Cari nama, username, email…">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Hak Akses</th>
                <th>No. HP</th>
                <th class="datatable-nosort text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_user as $user) :
                $lvl = (int) $user['level'];
                $isMe = $me && (int) $me['id'] === (int) $user['id'];
            ?>
            <tr>
                <td class="c-primary">
                    <div class="cell-user">
                        <span class="avatar"><img src="<?= h(adminAvatarUrl($user)) ?>" alt="" loading="lazy"></span>
                        <div style="min-width:0">
                            <span class="cell-title"><?= h($user['nm_lengkap'] ?: $user['username']) ?>
                                <?php if ($isMe) : ?><span class="tag tag-green" style="margin-left:4px">Anda</span><?php endif; ?></span>
                            <span class="cell-sub"><?= h($user['email'] ?: '-') ?></span>
                        </div>
                    </div>
                </td>
                <td data-label="Username"><span class="mono">@<?= h($user['username']) ?></span></td>
                <td class="c-status" data-search="<?= h(adminRoleName($lvl)) ?>">
                    <span class="tag <?= $roleTone[$lvl] ?? '' ?>"><i class="bi <?= $roleIcon[$lvl] ?? 'bi-person' ?>"></i> <?= h(adminRoleName($lvl)) ?></span>
                </td>
                <td data-label="No. HP"><?= h($user['no_hp'] ?: '-') ?></td>
                <td class="c-actions">
                    <div class="row-actions">
                        <?php if ($isMe) : ?>
                        <a class="btn-chip" href="<?= BASE_URL ?>/admin/profile.php"><i class="bi bi-person-circle"></i> Profil saya</a>
                        <?php else : ?>
                        <button type="button" class="btn-chip"
                            data-action="<?= BASE_URL ?>/admin/users/delete-user-handler.php" data-method="GET" data-param-id="<?= (int) $user['id'] ?>"
                            data-confirm="Hapus akun <?= h($user['username']) ?>?" data-confirm-text="Akun ini tidak akan bisa login lagi ke panel admin."
                            data-tone="danger" data-remove="tr" data-success="Akun berhasil dihapus.">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                        <?php endif; ?>
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
