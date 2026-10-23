<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 2]);

$ranges = [
    '0' => ['Semua', ''],
    '1' => ['Hari ini', "WHERE DATE(created_at) = CURRENT_DATE"],
    '7' => ['7 hari', "WHERE created_at >= CURDATE() - INTERVAL 7 DAY"],
    '30' => ['30 hari', "WHERE created_at >= CURDATE() - INTERVAL 30 DAY"],
];
$range = isset($_GET['range'], $ranges[$_GET['range']]) ? (string) $_GET['range'] : '0';

$stmt = $conn->prepare("SELECT * FROM pengaduan " . $ranges[$range][1] . " ORDER BY created_at DESC");
prepStmtForFetch($stmt);
$stmt->execute();
$all_keluhan = stmtFetchAllAssoc($stmt);

$countOpen = count(array_filter($all_keluhan, function ($r) {
    return (int) $r['status'] === 0;
}));
$countDone = count($all_keluhan) - $countOpen;
$countToday = count(array_filter($all_keluhan, function ($r) {
    return date('Y-m-d', strtotime($r['created_at'])) === date('Y-m-d');
}));

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Laporan gangguan dan keluhan yang masuk dari pelanggan melalui website.',
]);
?>

<section class="mini-stats">
    <div class="mini-stat tone-blue"><span class="kpi-icon"><i class="bi bi-inbox"></i></span>
        <div><b><?= count($all_keluhan) ?></b><small>Total <?= $range === '0' ? '' : strtolower($ranges[$range][0]) ?></small></div>
    </div>
    <div class="mini-stat tone-amber"><span class="kpi-icon"><i class="bi bi-hourglass-split"></i></span>
        <div><b><?= $countOpen ?></b><small>Perlu ditindak</small></div>
    </div>
    <div class="mini-stat tone-green"><span class="kpi-icon"><i class="bi bi-check2-circle"></i></span>
        <div><b><?= $countDone ?></b><small>Selesai</small></div>
    </div>
    <div class="mini-stat tone-violet"><span class="kpi-icon"><i class="bi bi-calendar-event"></i></span>
        <div><b><?= $countToday ?></b><small>Masuk hari ini</small></div>
    </div>
</section>

<section class="list-panel cards-sm">
    <div class="list-head">
        <div>
            <h2>Daftar Pengaduan <span class="count"><?= count($all_keluhan) ?></span></h2>
            <p>Klik "Detail" untuk menindaklanjuti atau mencetak laporan.</p>
        </div>
        <div class="list-tools">
            <div class="chips" data-dt-filter="#tbl-pengaduan" data-col="4" role="group" aria-label="Filter status">
                <button type="button" class="chip active" data-value="">Semua</button>
                <button type="button" class="chip chip-open" data-value="Proses"><span class="dot"></span>Proses <span
                        class="n"><?= $countOpen ?></span></button>
                <button type="button" class="chip chip-done" data-value="Selesai"><span class="dot"></span>Selesai <span
                        class="n"><?= $countDone ?></span></button>
            </div>
            <nav class="seg" aria-label="Rentang waktu">
                <?php foreach ($ranges as $key => [$label]) : ?>
                <a href="?range=<?= $key ?>" class="<?= $range === (string) $key ? 'active' : '' ?>"><?= $label ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>

    <table class="data-table table-cards table hover" id="tbl-pengaduan" data-search="Cari nama, ID pelanggan, isi…"
        data-empty="Belum ada pengaduan pada rentang waktu ini.">
        <thead>
            <tr>
                <th>Pelapor</th>
                <th class="datatable-nosort">Isi Pengaduan</th>
                <th>Kontak</th>
                <th>Masuk</th>
                <th>Status</th>
                <th class="datatable-nosort text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_keluhan as $i) : $open = (int) $i['status'] === 0; ?>
            <tr>
                <td class="c-primary">
                    <div class="cell-user">
                        <span class="avatar <?= adminAvatarTone($i['nm_lengkap']) ?>"><?= h(adminInitials($i['nm_lengkap'])) ?></span>
                        <div style="min-width:0">
                            <a class="cell-title" href="<?= BASE_URL ?>/admin/pengaduan/detail.php?id=<?= (int) $i['id'] ?>"><?= h($i['nm_lengkap']) ?></a>
                            <span class="cell-sub mono"><?= $i['id_pel'] !== '' ? 'ID ' . h($i['id_pel']) : 'Tanpa ID pelanggan' ?></span>
                        </div>
                    </div>
                </td>
                <td class="c-block" data-label="Isi pengaduan"><span class="truncate-2"><?= h($i['isi_pengaduan']) ?></span></td>
                <td data-label="Kontak">
                    <div style="min-width:0">
                        <span class="cell-title" style="font-weight:500"><i class="bi bi-telephone text-muted"></i> <?= h($i['no_hp']) ?></span>
                        <span class="cell-sub"><i class="bi bi-geo-alt"></i><?= h($i['alamat']) ?></span>
                    </div>
                </td>
                <td data-label="Masuk" data-order="<?= strtotime($i['created_at']) ?>">
                    <div>
                        <span class="cell-title" style="font-weight:500"><?= h(adminDate($i['created_at'])) ?></span>
                        <span class="cell-sub"><?= h(adminTimeHint($i['created_at'])) ?></span>
                    </div>
                </td>
                <td class="c-status" data-search="<?= $open ? 'Proses' : 'Selesai' ?>">
                    <span class="status-pill <?= $open ? 'is-open' : 'is-done' ?>"><?= $open ? 'Proses' : 'Selesai' ?></span>
                </td>
                <td class="c-actions">
                    <div class="row-actions">
                        <?php if ($wa = adminWaLink($i['no_hp'], 'Halo ' . $i['nm_lengkap'] . ', kami dari PERUMDA Air Minum Muara Tirta terkait pengaduan Anda.')) : ?>
                        <a class="btn-icon success" href="<?= h($wa) ?>" target="_blank" rel="noopener" title="Hubungi via WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <?php endif; ?>
                        <a class="btn-chip" href="<?= BASE_URL ?>/admin/pengaduan/detail.php?id=<?= (int) $i['id'] ?>"><i class="bi bi-eye"></i> Detail</a>
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
