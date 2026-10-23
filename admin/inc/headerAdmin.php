<?php
require_once ROOT_PATH . '/admin/inc/consoleNav.php';
$consoleUser = getUser();
$nav = adminNavContext();

// Notifikasi: pengaduan & pasang baru yang belum ditindaklanjuti (hanya untuk Admin & CS)
$notif = null;
if (in_array((int) $consoleUser['level'], [1, 2], true) && isset($conn)) {
    $notif = ['count' => 0, 'items' => []];
    $sources = [
        ['pg', "SELECT id, nm_lengkap label, isi_pengaduan sub, created_at FROM pengaduan WHERE status = '0' ORDER BY created_at DESC LIMIT 5", "SELECT COUNT(*) n FROM pengaduan WHERE status = '0'"],
        ['pb', "SELECT id, alamat label, no_hp sub, created_at FROM pasang_baru WHERE tindak_lanjut = '0' ORDER BY created_at DESC LIMIT 5", "SELECT COUNT(*) n FROM pasang_baru WHERE tindak_lanjut = '0'"],
    ];
    foreach ($sources as [$type, $listSql, $countSql]) {
        if ($res = $conn->query($countSql)) {
            $notif['count'] += (int) $res->fetch_assoc()['n'];
        }
        if ($res = $conn->query($listSql)) {
            while ($row = $res->fetch_assoc()) {
                $notif['items'][] = $row + ['type' => $type];
            }
        }
    }
    usort($notif['items'], function ($a, $b) {
        return strcmp($b['created_at'], $a['created_at']);
    });
    $notif['items'] = array_slice($notif['items'], 0, 6);
}
?>
<div class="header">
    <div class="header-left">
        <button type="button" class="menu-icon bi bi-list" aria-label="Buka menu"></button>
        <button type="button" class="hd-btn hd-collapse" data-sidebar-collapse aria-label="Ciutkan sidebar"
            title="Ciutkan / lebarkan sidebar">
            <i class="bi bi-layout-sidebar"></i>
        </button>
        <div class="hd-title">
            <span class="hd-crumb">
                Admin<?php if ($nav['parent']) : ?><i class="bi bi-chevron-right"></i><?= htmlspecialchars($nav['parent']) ?><?php endif; ?>
            </span>
            <h1><?= htmlspecialchars($nav['title']) ?></h1>
        </div>
    </div>

    <div class="header-right">
        <button type="button" class="hd-search" data-cmdk-open aria-label="Cari menu">
            <i class="bi bi-search"></i>
            <span>Cari menu…</span>
            <span class="kbd"><span class="kbd-mod">Ctrl</span>K</span>
        </button>

        <a class="hd-btn hd-site" href="<?= BASE_URL . '/' ?>" target="_blank" rel="noopener" title="Lihat website"
            data-cmdk-extra="Lihat website publik" data-cmdk-icon="bi bi-globe2">
            <i class="bi bi-box-arrow-up-right"></i>
        </a>
        <?php if ($notif !== null) : ?>
        <div class="dropdown notif-dd">
            <button type="button" class="hd-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                title="Notifikasi" aria-label="Notifikasi (<?= $notif['count'] ?> menunggu)">
                <i class="bi bi-bell"></i>
                <?php if ($notif['count'] > 0) : ?>
                <span class="hd-badge"><?= $notif['count'] > 99 ? '99+' : $notif['count'] ?></span>
                <?php endif; ?>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="nd-head">
                    <b>Perlu ditindaklanjuti</b>
                    <span class="tag tag-amber"><?= $notif['count'] ?> menunggu</span>
                </div>
                <div class="nd-list">
                    <?php if (!$notif['items']) : ?>
                    <div class="empty-state"><i class="bi bi-check2-circle"></i>Semua sudah ditangani. 🎉</div>
                    <?php endif; ?>
                    <?php foreach ($notif['items'] as $n) : $isPg = $n['type'] === 'pg'; ?>
                    <a class="nd-item"
                        href="<?= BASE_URL . '/admin/' . ($isPg ? 'pengaduan' : 'pasang-baru') . '/detail.php?id=' . (int) $n['id'] ?>">
                        <span class="kpi-icon <?= $isPg ? 'tone-amber' : 'tone-violet' ?>"
                            style="background:var(<?= $isPg ? '--c-warning-soft' : '--c-violet-soft' ?>);color:var(<?= $isPg ? '--c-warning' : '--c-violet' ?>)">
                            <i class="bi <?= $isPg ? 'bi-chat-left-text' : 'bi-receipt-cutoff' ?>"></i>
                        </span>
                        <span style="min-width:0">
                            <b><?= h(($isPg ? 'Pengaduan · ' : 'Pasang baru · ') . ($n['label'] ?: '-')) ?></b>
                            <small><?= h(adminExcerpt($n['sub'], 48)) ?> · <?= h(adminAgo($n['created_at'])) ?></small>
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="nd-foot">
                    <a href="<?= BASE_URL ?>/admin/pengaduan.php">Semua pengaduan</a>
                    <a href="<?= BASE_URL ?>/admin/pasang-baru.php">Semua pasang baru</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <button type="button" class="hd-btn theme-toggle" data-theme-toggle title="Ganti tema terang / gelap"
            aria-label="Ganti tema">
            <i class="bi bi-moon-stars"></i>
            <i class="bi bi-sun"></i>
        </button>

        <span class="hd-divider"></span>

        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="user-icon">
                        <img src="<?= htmlspecialchars(adminAvatarUrl($consoleUser)) ?>" alt="" />
                    </span>
                    <span class="user-name">
                        <b><?= htmlspecialchars($consoleUser['username']) ?></b>
                        <small><?= adminRoleName($consoleUser['level']) ?></small>
                    </span>
                    <i class="bi bi-chevron-down user-caret"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dd-head">
                        <b><?= htmlspecialchars($consoleUser['nm_lengkap'] ?: $consoleUser['username']) ?></b>
                        <small><?= htmlspecialchars($consoleUser['email']) ?></small>
                    </div>
                    <a class="dropdown-item" href="<?= BASE_URL . '/admin/profile.php' ?>"
                        data-cmdk-extra="Profil saya" data-cmdk-icon="bi bi-person-circle">
                        <i class="bi bi-person-circle"></i> Profil saya
                    </a>
                    <a class="dropdown-item" href="javascript:;" data-theme-toggle>
                        <i class="bi bi-moon-stars"></i> Ganti tema
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= BASE_URL . '/logout.php' ?>"
                        data-cmdk-extra="Keluar (logout)" data-cmdk-icon="bi bi-box-arrow-right">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cmdk" id="cmdk" aria-hidden="true" role="dialog" aria-label="Cari menu">
    <div class="cmdk-box">
        <div class="cmdk-input">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Ketik nama menu, mis. pengaduan…" autocomplete="off" spellcheck="false" />
            <span class="kbd">Esc</span>
        </div>
        <ul class="cmdk-list"></ul>
        <div class="cmdk-foot">
            <span><span class="kbd">↑</span> <span class="kbd">↓</span> pilih</span>
            <span><span class="kbd">Enter</span> buka</span>
            <span><span class="kbd">/</span> buka cepat</span>
        </div>
    </div>
</div>
