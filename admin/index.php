<?php include('../path.php') ?>
<?php include(ROOT_PATH . '/app/controllers/users.php'); ?>

<?php

include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$me = getUser();
$level = (int) $me['level'];
$isCs = in_array($level, [1, 2], true);
$isArsip = in_array($level, [1, 3], true);

// Query agregat tanpa input user -> cukup $conn->query(). Hindari fetch_all() karena
// hosting produksi tidak selalu punya mysqlnd (lihat app/db/db.php).
function dashRows($sql)
{
    global $conn;
    $rows = [];
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function dashCount($sql)
{
    $rows = dashRows($sql);
    return $rows ? (int) array_values($rows[0])[0] : 0;
}

// Seri per bulan 6 bulan terakhir (termasuk bulan ini), bulan kosong diisi 0.
function dashMonthly($table, $dateCol, $months)
{
    $data = array_fill_keys(array_keys($months), 0);
    $rows = dashRows("SELECT DATE_FORMAT($dateCol, '%Y-%m') ym, COUNT(*) n FROM $table
        WHERE $dateCol >= DATE_FORMAT(CURDATE() - INTERVAL 5 MONTH, '%Y-%m-01') GROUP BY ym");
    foreach ($rows as $r) {
        if (isset($data[$r['ym']])) {
            $data[$r['ym']] = (int) $r['n'];
        }
    }
    return array_values($data);
}

function dashAgo($minutes, $date)
{
    $m = (int) $minutes;
    if ($m < 1) return 'baru saja';
    if ($m < 60) return $m . ' menit lalu';
    if ($m < 1440) return floor($m / 60) . ' jam lalu';
    if ($m < 2880) return 'kemarin';
    if ($m < 10080) return floor($m / 1440) . ' hari lalu';
    return dashDate($date);
}

function dashDate($date)
{
    $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $t = strtotime($date);
    return $t ? date('j', $t) . ' ' . $bulan[(int) date('n', $t)] . ' ' . date('Y', $t) : '-';
}

function dashInitials($name)
{
    $parts = preg_split('/\s+/', trim((string) $name));
    $ini = '';
    foreach (array_slice($parts, 0, 2) as $p) {
        $ini .= mb_strtoupper(mb_substr($p, 0, 1));
    }
    return $ini ?: '?';
}

function dashNum($n)
{
    return number_format((int) $n, 0, ',', '.');
}

function e($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

// Label 6 bulan terakhir
$bulanPendek = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
$months = [];
for ($i = 5; $i >= 0; $i--) {
    $t = strtotime(date('Y-m-01') . " -$i month");
    $months[date('Y-m', $t)] = $bulanPendek[(int) date('n', $t)];
}

if ($isCs) {
    $pgTotal = dashCount("SELECT COUNT(*) FROM pengaduan");
    $pgOpen = dashCount("SELECT COUNT(*) FROM pengaduan WHERE status = '0'");
    $pgDone = $pgTotal - $pgOpen;
    $pgWeek = dashCount("SELECT COUNT(*) FROM pengaduan WHERE created_at >= NOW() - INTERVAL 7 DAY");
    $pgToday = dashCount("SELECT COUNT(*) FROM pengaduan WHERE DATE(created_at) = CURDATE()");
    $pgRate = $pgTotal ? round($pgDone / $pgTotal * 100) : 0;

    $pbTotal = dashCount("SELECT COUNT(*) FROM pasang_baru");
    $pbOpen = dashCount("SELECT COUNT(*) FROM pasang_baru WHERE tindak_lanjut = '0'");
    $pbWeek = dashCount("SELECT COUNT(*) FROM pasang_baru WHERE created_at >= NOW() - INTERVAL 7 DAY");

    $seriesPengaduan = dashMonthly('pengaduan', 'created_at', $months);
    $seriesPasang = dashMonthly('pasang_baru', 'created_at', $months);

    $recentPengaduan = dashRows("SELECT id, nm_lengkap, id_pel, isi_pengaduan, status, created_at,
        TIMESTAMPDIFF(MINUTE, created_at, NOW()) ago FROM pengaduan ORDER BY created_at DESC LIMIT 6");
    $recentPasang = dashRows("SELECT id, alamat, no_hp, tindak_lanjut, created_at,
        TIMESTAMPDIFF(MINUTE, created_at, NOW()) ago FROM pasang_baru ORDER BY created_at DESC LIMIT 5");
}

if ($isArsip) {
    $infoTotal = dashCount("SELECT COUNT(*) FROM informasi");
    $infoMonth = dashCount("SELECT COUNT(*) FROM informasi WHERE tanggal_buat >= NOW() - INTERVAL 30 DAY");
    $galeriTotal = dashCount("SELECT COUNT(*) FROM galeri");
    $infoTags = dashRows("SELECT COALESCE(NULLIF(tag, ''), 'Lainnya') tag, COUNT(*) n FROM informasi GROUP BY 1 ORDER BY n DESC");
    $seriesInfo = dashMonthly('informasi', 'tanggal_buat', $months);
    $recentInfo = dashRows("SELECT id, judul, tag, author, image, tanggal_buat,
        TIMESTAMPDIFF(MINUTE, tanggal_buat, NOW()) ago FROM informasi ORDER BY tanggal_buat DESC LIMIT 5");
}

// Sapaan & tanggal pakai zona waktu Gorontalo (WITA)
$nowWita = new DateTime('now', new DateTimeZone('Asia/Makassar'));
$hour = (int) $nowWita->format('G');
$greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulanPanjang = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$todayLabel = $hari[(int) $nowWita->format('w')] . ', ' . $nowWita->format('j') . ' ' . $bulanPanjang[(int) $nowWita->format('n')] . ' ' . $nowWita->format('Y');
$firstName = explode(' ', trim($me['nm_lengkap'] ?: $me['username']))[0];
?>
<?php
$pageTitle = 'Dashboard';
$pageAssets = ['charts' => true];
include ROOT_PATH . '/admin/inc/layoutStart.php';
?>

            <!-- Hero -->
            <section class="dash-hero">
                <div>
                    <div class="eyebrow"><i class="bi bi-calendar3"></i> <?= e($todayLabel) ?></div>
                    <h2><?= e($greeting) ?>, <?= e($firstName) ?> 👋</h2>
                    <p>
                        <?php if ($isCs && $pgOpen > 0) : ?>
                        Ada <b><?= dashNum($pgOpen) ?> pengaduan</b> yang masih perlu ditindaklanjuti<?= $pbOpen > 0 ? ' dan <b>' . dashNum($pbOpen) . ' pendaftaran pasang baru</b> menunggu' : '' ?>.
                        <?php elseif ($isCs) : ?>
                        Semua pengaduan sudah ditangani. Kerja bagus! 🎉
                        <?php else : ?>
                        <?= dashNum($infoMonth) ?> publikasi terbit dalam 30 hari terakhir.
                        <?php endif; ?>
                    </p>
                    <div class="mt-3"><span class="hero-role"><i class="bi bi-shield-lock"></i>
                            <?= adminRoleName($level) ?></span></div>
                </div>
                <div class="hero-actions">
                    <?php if ($isCs) : ?>
                    <a class="btn-hero solid" href="<?= BASE_URL ?>/admin/pengaduan.php"><i class="bi bi-inbox"></i>
                        Tinjau pengaduan</a>
                    <a class="btn-hero" href="<?= BASE_URL ?>/admin/pasang-baru.php"><i class="bi bi-receipt-cutoff"></i>
                        Pasang baru</a>
                    <?php endif; ?>
                    <?php if ($isArsip) : ?>
                    <a class="btn-hero<?= $isCs ? '' : ' solid' ?>" href="<?= BASE_URL ?>/admin/informasi/tambah.php"><i
                            class="bi bi-plus-lg"></i> Tulis informasi</a>
                    <?php endif; ?>
                </div>
            </section>

            <!-- KPI -->
            <section class="kpi-grid">
                <?php if ($isCs) : ?>
                <a class="kpi tone-blue" href="<?= BASE_URL ?>/admin/pengaduan.php">
                    <div class="kpi-top">
                        <span class="kpi-label">Total Pengaduan</span>
                        <span class="kpi-icon"><i class="bi bi-chat-left-text"></i></span>
                    </div>
                    <div class="kpi-value"><?= dashNum($pgTotal) ?></div>
                    <div class="kpi-foot">
                        <span class="kpi-delta<?= $pgWeek > 0 ? ' up' : '' ?>"><i class="bi bi-arrow-up-right"></i>
                            <?= dashNum($pgWeek) ?></span> dalam 7 hari terakhir
                    </div>
                </a>
                <a class="kpi tone-amber" href="<?= BASE_URL ?>/admin/pengaduan.php">
                    <div class="kpi-top">
                        <span class="kpi-label">Perlu Ditindak</span>
                        <span class="kpi-icon"><i class="bi bi-hourglass-split"></i></span>
                    </div>
                    <div class="kpi-value"><?= dashNum($pgOpen) ?></div>
                    <div class="kpi-foot"><?= dashNum($pgToday) ?> pengaduan masuk hari ini</div>
                </a>
                <div class="kpi tone-green">
                    <div class="kpi-top">
                        <span class="kpi-label">Tingkat Penyelesaian</span>
                        <span class="kpi-icon"><i class="bi bi-check2-circle"></i></span>
                    </div>
                    <div class="kpi-value"><?= $pgRate ?>%</div>
                    <div class="kpi-bar" title="<?= dashNum($pgDone) ?> dari <?= dashNum($pgTotal) ?> selesai">
                        <span style="width: <?= $pgRate ?>%"></span>
                    </div>
                </div>
                <a class="kpi tone-violet" href="<?= BASE_URL ?>/admin/pasang-baru.php">
                    <div class="kpi-top">
                        <span class="kpi-label">Pasang Baru Menunggu</span>
                        <span class="kpi-icon"><i class="bi bi-receipt-cutoff"></i></span>
                    </div>
                    <div class="kpi-value"><?= dashNum($pbOpen) ?></div>
                    <div class="kpi-foot">dari <?= dashNum($pbTotal) ?> pendaftaran · +<?= dashNum($pbWeek) ?> minggu
                        ini</div>
                </a>
                <?php endif; ?>

                <?php if ($isArsip) : ?>
                <a class="kpi tone-cyan" href="<?= BASE_URL ?>/admin/informasi.php">
                    <div class="kpi-top">
                        <span class="kpi-label">Publikasi Informasi</span>
                        <span class="kpi-icon"><i class="bi bi-newspaper"></i></span>
                    </div>
                    <div class="kpi-value"><?= dashNum($infoTotal) ?></div>
                    <div class="kpi-foot">
                        <span class="kpi-delta<?= $infoMonth > 0 ? ' up' : '' ?>"><i class="bi bi-arrow-up-right"></i>
                            <?= dashNum($infoMonth) ?></span> dalam 30 hari terakhir
                    </div>
                </a>
                <?php if (!$isCs) : ?>
                <a class="kpi tone-violet" href="<?= BASE_URL ?>/admin/galeri.php">
                    <div class="kpi-top">
                        <span class="kpi-label">Foto Galeri</span>
                        <span class="kpi-icon"><i class="bi bi-images"></i></span>
                    </div>
                    <div class="kpi-value"><?= dashNum($galeriTotal) ?></div>
                    <div class="kpi-foot">foto tampil di halaman galeri</div>
                </a>
                <?php endif; ?>
                <?php endif; ?>
            </section>

            <?php if ($isCs) : ?>
            <!-- Grafik layanan -->
            <div class="row">
                <div class="col-xl-8 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Tren Layanan Pelanggan</h3>
                                <p>Pengaduan &amp; pendaftaran pasang baru, 6 bulan terakhir</p>
                            </div>
                            <div class="chart-legend">
                                <span><i style="background: var(--c-primary)"></i> Pengaduan</span>
                                <span><i style="background: var(--c-violet)"></i> Pasang Baru</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="chart-trend" style="min-height: 290px"></div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Status Pengaduan</h3>
                                <p>Seluruh pengaduan yang tercatat</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="donut-wrap">
                                <div id="chart-status"></div>
                                <div class="donut-center"><b><?= dashNum($pgTotal) ?></b><small>pengaduan</small></div>
                            </div>
                            <div class="donut-stats">
                                <div><small><i style="background: var(--c-warning)"></i> Proses</small>
                                    <b><?= dashNum($pgOpen) ?></b></div>
                                <div><small><i style="background: var(--c-success)"></i> Selesai</small>
                                    <b><?= dashNum($pgDone) ?></b></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Aktivitas terbaru -->
            <div class="row">
                <div class="col-xl-7 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Pengaduan Terbaru</h3>
                                <p>6 laporan terakhir dari pelanggan</p>
                            </div>
                            <a class="panel-link" href="<?= BASE_URL ?>/admin/pengaduan.php">Lihat semua <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                        <div class="panel-body p-0">
                            <?php if (empty($recentPengaduan)) : ?>
                            <div class="empty-state"><i class="bi bi-inbox"></i>Belum ada pengaduan.</div>
                            <?php else : ?>
                            <ul class="feed">
                                <?php foreach ($recentPengaduan as $p) : ?>
                                <li>
                                    <a href="<?= BASE_URL ?>/admin/pengaduan/detail.php?id=<?= (int) $p['id'] ?>">
                                        <span class="avatar av-<?= crc32($p['nm_lengkap']) % 6 ?>"><?= e(dashInitials($p['nm_lengkap'])) ?></span>
                                        <span class="feed-main">
                                            <span class="feed-title"><?= e($p['nm_lengkap']) ?>
                                                <?php if (!empty($p['id_pel'])) : ?><span class="text-muted font-weight-normal">·
                                                    <?= e($p['id_pel']) ?></span><?php endif; ?></span>
                                            <span class="feed-sub"><?= e($p['isi_pengaduan']) ?></span>
                                        </span>
                                        <span class="feed-side">
                                            <span class="status-pill <?= $p['status'] == 0 ? 'is-open' : 'is-done' ?>"><?= $p['status'] == 0 ? 'Proses' : 'Selesai' ?></span>
                                            <span class="feed-time"><?= e(dashAgo($p['ago'], $p['created_at'])) ?></span>
                                        </span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
                <div class="col-xl-5 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Pendaftaran Pasang Baru</h3>
                                <p>Permohonan sambungan terbaru</p>
                            </div>
                            <a class="panel-link" href="<?= BASE_URL ?>/admin/pasang-baru.php">Lihat semua <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                        <div class="panel-body p-0">
                            <?php if (empty($recentPasang)) : ?>
                            <div class="empty-state"><i class="bi bi-receipt"></i>Belum ada pendaftaran.</div>
                            <?php else : ?>
                            <ul class="feed">
                                <?php foreach ($recentPasang as $p) : ?>
                                <li>
                                    <a href="<?= BASE_URL ?>/admin/pasang-baru/detail.php?id=<?= (int) $p['id'] ?>">
                                        <span class="avatar av-5"><i class="bi bi-house-door"></i></span>
                                        <span class="feed-main">
                                            <span class="feed-title"><?= e($p['alamat'] ?: 'Alamat belum diisi') ?></span>
                                            <span class="feed-sub"><i class="bi bi-telephone"></i> <?= e($p['no_hp'] ?: '-') ?></span>
                                        </span>
                                        <span class="feed-side">
                                            <span class="status-pill <?= $p['tindak_lanjut'] == 0 ? 'is-open' : 'is-done' ?>"><?= $p['tindak_lanjut'] == 0 ? 'Proses' : 'Selesai' ?></span>
                                            <span class="feed-time"><?= e(dashAgo($p['ago'], $p['created_at'])) ?></span>
                                        </span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($isArsip) : ?>
            <div class="row">
                <?php if (!$isCs) : ?>
                <div class="col-xl-8 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Tren Publikasi</h3>
                                <p>Informasi yang terbit per bulan, 6 bulan terakhir</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="chart-info" style="min-height: 290px"></div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Kategori Publikasi</h3>
                                <p>Berdasarkan tag informasi</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="donut-wrap">
                                <div id="chart-tags"></div>
                                <div class="donut-center"><b><?= dashNum($infoTotal) ?></b><small>publikasi</small></div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php endif; ?>

                <div class="col-xl-8 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Publikasi Terbaru</h3>
                                <p>Informasi, berita, dan promo yang terakhir dibuat</p>
                            </div>
                            <a class="panel-link" href="<?= BASE_URL ?>/admin/informasi.php">Kelola <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                        <div class="panel-body p-0">
                            <?php if (empty($recentInfo)) : ?>
                            <div class="empty-state"><i class="bi bi-newspaper"></i>Belum ada publikasi.</div>
                            <?php else : ?>
                            <ul class="feed">
                                <?php foreach ($recentInfo as $n) : ?>
                                <li>
                                    <a href="<?= BASE_URL ?>/admin/informasi/edit.php?id=<?= (int) $n['id'] ?>">
                                        <span class="avatar">
                                            <?php if (!empty($n['image'])) : ?>
                                            <img src="<?= e(resolveImageUrl($n['image'], 'informasi', ['assets/info'])) ?>"
                                                alt="" loading="lazy" />
                                            <?php else : ?>
                                            <i class="bi bi-newspaper"></i>
                                            <?php endif; ?>
                                        </span>
                                        <span class="feed-main">
                                            <span class="feed-title"><?= e($n['judul']) ?></span>
                                            <span class="feed-sub">oleh <?= e($n['author'] ?: '-') ?></span>
                                        </span>
                                        <span class="feed-side">
                                            <span class="badge badge-info"><?= e($n['tag'] ?: 'Lainnya') ?></span>
                                            <span class="feed-time"><?= e(dashAgo($n['ago'], $n['tanggal_buat'])) ?></span>
                                        </span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4 d-flex">
                    <section class="panel w-100">
                        <div class="panel-head">
                            <div>
                                <h3>Aksi Cepat</h3>
                                <p>Pintasan yang sering dipakai</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="quick-grid">
                                <a href="<?= BASE_URL ?>/admin/informasi/tambah.php"><i class="bi bi-plus-circle"></i>
                                    Tulis informasi<small>Berita, gangguan, promo</small></a>
                                <a href="<?= BASE_URL ?>/admin/galeri/tambah.php"><i class="bi bi-images"></i> Tambah
                                    foto<small>Unggah ke galeri</small></a>
                                <?php if ($level === 1) : ?>
                                <a href="<?= BASE_URL ?>/admin/users/add-user.php"><i class="bi bi-people"></i> Tambah
                                    user<small>Akses panel admin</small></a>
                                <a href="<?= BASE_URL ?>/admin/struktur-organisasi.php"><i class="bi bi-diagram-3"></i>
                                    Struktur<small>Kelola staff</small></a>
                                <?php else : ?>
                                <a href="<?= BASE_URL ?>/" target="_blank" rel="noopener"><i class="bi bi-globe2"></i>
                                    Lihat website<small>Cek tampilan publik</small></a>
                                <a href="<?= BASE_URL ?>/admin/profile.php"><i class="bi bi-person-circle"></i> Profil
                                    saya<small>Ubah data &amp; sandi</small></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?php endif; ?>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>

    <script>
    (function() {
        if (typeof ApexCharts === 'undefined') return;

        var months = <?= json_encode(array_values($months)) ?>;
        var charts = [];

        function css(name) {
            return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        }

        function themed() {
            return {
                chart: {
                    foreColor: css('--c-muted'),
                    fontFamily: 'Inter, sans-serif'
                },
                grid: {
                    borderColor: css('--c-border')
                },
                theme: {
                    mode: document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light'
                },
                tooltip: {
                    theme: document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light'
                }
            };
        }

        function areaChart(el, series, colors) {
            var node = document.querySelector(el);
            if (!node) return;
            var c = new ApexCharts(node, Object.assign({}, {
                series: series,
                colors: colors,
                chart: {
                    type: 'area',
                    height: 290,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    foreColor: css('--c-muted'),
                    fontFamily: 'Inter, sans-serif'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2.5
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: .35,
                        opacityTo: .02,
                        stops: [0, 95]
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        size: 5
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    borderColor: css('--c-border'),
                    strokeDashArray: 4,
                    padding: {
                        left: 6,
                        right: 6
                    }
                },
                xaxis: {
                    categories: months,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    min: 0,
                    forceNiceScale: true,
                    labels: {
                        formatter: function(v) {
                            return Math.round(v);
                        }
                    }
                },
                tooltip: themed().tooltip
            }));
            c.render();
            charts.push(c);
        }

        function donutChart(el, labels, values, colors) {
            var node = document.querySelector(el);
            if (!node) return;
            var c = new ApexCharts(node, {
                series: values,
                labels: labels,
                colors: colors,
                chart: {
                    type: 'donut',
                    height: 240,
                    fontFamily: 'Inter, sans-serif',
                    foreColor: css('--c-muted')
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 3,
                    colors: [css('--c-surface')]
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '74%'
                        }
                    }
                },
                tooltip: themed().tooltip
            });
            c.render();
            charts.push(c);
        }

        <?php if ($isCs) : ?>
        areaChart('#chart-trend', [{
            name: 'Pengaduan',
            data: <?= json_encode($seriesPengaduan) ?>
        }, {
            name: 'Pasang Baru',
            data: <?= json_encode($seriesPasang) ?>
        }], [css('--c-primary'), css('--c-violet')]);

        donutChart('#chart-status', ['Proses', 'Selesai'], [<?= (int) $pgOpen ?>, <?= (int) $pgDone ?>],
            [css('--c-warning'), css('--c-success')]);
        <?php elseif ($isArsip) : ?>
        areaChart('#chart-info', [{
            name: 'Publikasi',
            data: <?= json_encode($seriesInfo) ?>
        }], [css('--c-info')]);

        donutChart('#chart-tags', <?= json_encode(array_column($infoTags, 'tag')) ?>,
            <?= json_encode(array_map('intval', array_column($infoTags, 'n'))) ?>,
            [css('--c-primary'), css('--c-warning'), css('--c-violet'), css('--c-info'), css('--c-success')]);
        <?php endif; ?>

        // Warna sumbu/grid/tooltip ikut tema saat tombol tema ditekan
        document.addEventListener('mt:themechange', function() {
            charts.forEach(function(c) {
                c.updateOptions(Object.assign(themed(), {
                    stroke: c.w.config.chart.type === 'donut' ? {
                        width: 3,
                        colors: [css('--c-surface')]
                    } : c.w.config.stroke
                }), false, false);
            });
        });
    })();
    </script>
</body>

</html>
