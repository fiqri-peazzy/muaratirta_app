<?php
include('../path.php');
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

$stmt = $conn->prepare("SELECT * FROM pasang_baru " . $ranges[$range][1] . " ORDER BY created_at DESC");
prepStmtForFetch($stmt);
$stmt->execute();
$all_pasang_baru = stmtFetchAllAssoc($stmt);

$countOpen = count(array_filter($all_pasang_baru, function ($r) {
    return (int) $r['tindak_lanjut'] === 0;
}));
$countDone = count($all_pasang_baru) - $countOpen;
$countDocs = count(array_filter($all_pasang_baru, function ($r) {
    return !empty($r['foto_ktp']) && !empty($r['foto_rumah']);
}));

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Permohonan sambungan air baru yang didaftarkan calon pelanggan.',
]);
?>

<section class="mini-stats">
    <div class="mini-stat tone-blue"><span class="kpi-icon"><i class="bi bi-receipt-cutoff"></i></span>
        <div><b><?= count($all_pasang_baru) ?></b><small>Total pendaftaran</small></div>
    </div>
    <div class="mini-stat tone-amber"><span class="kpi-icon"><i class="bi bi-hourglass-split"></i></span>
        <div><b><?= $countOpen ?></b><small>Menunggu proses</small></div>
    </div>
    <div class="mini-stat tone-green"><span class="kpi-icon"><i class="bi bi-check2-circle"></i></span>
        <div><b><?= $countDone ?></b><small>Selesai</small></div>
    </div>
    <div class="mini-stat tone-violet"><span class="kpi-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div><b><?= $countDocs ?></b><small>Dokumen lengkap</small></div>
    </div>
</section>

<section class="list-panel cards-sm">
    <div class="list-head">
        <div>
            <h2>Daftar Pendaftaran <span class="count"><?= count($all_pasang_baru) ?></span></h2>
            <p>Periksa dokumen lalu tandai selesai dari halaman detail.</p>
        </div>
        <div class="list-tools">
            <div class="chips" data-dt-filter="#tbl-pasang" data-col="4" role="group" aria-label="Filter status">
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

    <table class="data-table table-cards table hover" id="tbl-pasang" data-search="Cari alamat, no. HP, no. registrasi…"
        data-empty="Belum ada pendaftaran pada rentang waktu ini.">
        <thead>
            <tr>
                <th>Pendaftaran</th>
                <th>Kontak</th>
                <th class="datatable-nosort">Dokumen</th>
                <th>Masuk</th>
                <th>Status</th>
                <th class="datatable-nosort text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_pasang_baru as $i) :
                $open = (int) $i['tindak_lanjut'] === 0;
                $no = 'PB-' . str_pad($i['id'], 5, '0', STR_PAD_LEFT);
            ?>
            <tr>
                <td class="c-primary">
                    <div class="cell-user">
                        <span class="avatar av-5"><i class="bi bi-house-door"></i></span>
                        <div style="min-width:0">
                            <a class="cell-title" href="<?= BASE_URL ?>/admin/pasang-baru/detail.php?id=<?= (int) $i['id'] ?>"><?= h($i['alamat'] ?: 'Alamat belum diisi') ?></a>
                            <span class="cell-sub mono"><?= $no ?></span>
                        </div>
                    </div>
                </td>
                <td data-label="No. HP"><span><i class="bi bi-telephone text-muted"></i> <?= h($i['no_hp'] ?: '-') ?></span></td>
                <td data-label="Dokumen">
                    <span class="doc-flags">
                        <span class="doc-flag <?= $i['foto_ktp'] ? 'ok' : '' ?>"><i class="bi <?= $i['foto_ktp'] ? 'bi-check2' : 'bi-x' ?>"></i> KTP</span>
                        <span class="doc-flag <?= $i['foto_rumah'] ? 'ok' : '' ?>"><i class="bi <?= $i['foto_rumah'] ? 'bi-check2' : 'bi-x' ?>"></i> Rumah</span>
                    </span>
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
                        <?php if ($wa = adminWaLink($i['no_hp'], 'Halo, kami dari PERUMDA Air Minum Muara Tirta terkait pendaftaran sambungan baru ' . $no . '.')) : ?>
                        <a class="btn-icon success" href="<?= h($wa) ?>" target="_blank" rel="noopener" title="Hubungi via WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <?php endif; ?>
                        <a class="btn-icon" href="<?= BASE_URL ?>/admin/pasang-baru/cetak_pdf.php?id=<?= (int) $i['id'] ?>" target="_blank" title="Cetak formulir"><i class="bi bi-printer"></i></a>
                        <a class="btn-chip" href="<?= BASE_URL ?>/admin/pasang-baru/detail.php?id=<?= (int) $i['id'] ?>"><i class="bi bi-eye"></i> Detail</a>
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
