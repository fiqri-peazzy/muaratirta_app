<?php
include('path.php');
include(ROOT_PATH . '/app/controllers/users.php');
require_once(ROOT_PATH . '/app/helpers/middleware.php');
guestsOnly('/admin/');
require_once(ROOT_PATH . '/admin/inc/consoleNav.php');

$loginError = $errors['login'] ?? ($errors['username'] ?? ($errors['password'] ?? ''));
$lastUser = $_POST['u_name'] ?? '';
if (isset($_GET['logout']) && empty($_SESSION['message'])) {
    $_SESSION['message'] = 'Anda sudah keluar dari panel admin.';
    $_SESSION['type'] = 'info';
}
$logo = BASE_URL . '/assets/logo/logo-perumda-2026.png';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Masuk | Admin Muara Tirta</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/logo/Logo-PDAM-MT-min.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/admin/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/admin/vendors/styles/icon-font.min.css" />
    <?php include ROOT_PATH . '/admin/inc/consoleHead.php'; ?>
</head>

<body>
    <div class="auth">
        <section class="auth-brand" aria-hidden="false">
            <div class="auth-top">
                <a href="<?= BASE_URL ?>/"><i class="bi bi-arrow-left"></i> Kembali ke website</a>
            </div>

            <div class="auth-hero">
                <div class="auth-logo"><img src="<?= h($logo) ?>" alt="Logo PERUMDA Air Minum Muara Tirta"></div>
                <span class="eyebrow">Admin Console</span>
                <h1>PERUMDA Air Minum<br>Muara Tirta</h1>
                <p>Panel pengelolaan layanan pelanggan dan publikasi Kota Gorontalo.</p>
                <ul class="auth-points">
                    <li><i class="bi bi-chat-left-text"></i> Tindak lanjuti pengaduan &amp; pendaftaran pasang baru</li>
                    <li><i class="bi bi-newspaper"></i> Terbitkan berita, info gangguan, dan promo</li>
                    <li><i class="bi bi-robot"></i> Kelola pengetahuan asisten chatbot</li>
                </ul>
            </div>

            <div class="auth-foot">&copy; <?= date('Y') ?> PERUMDA Air Minum Muara Tirta Kota Gorontalo</div>

            <svg class="auth-waves" viewBox="0 0 1200 220" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 120 C 200 60 400 180 600 120 S 1000 60 1260 120 V220 H0 Z" fill="rgba(125,211,252,.10)" />
                <path d="M0 160 C 220 110 420 210 640 160 S 1040 110 1260 160 V220 H0 Z" fill="rgba(74,222,128,.12)" />
            </svg>
        </section>

        <main class="auth-main">
            <button type="button" class="hd-btn theme-toggle auth-theme" data-theme-toggle title="Ganti tema terang / gelap" aria-label="Ganti tema">
                <i class="bi bi-moon-stars"></i><i class="bi bi-sun"></i>
            </button>

            <div class="auth-card">
                <div class="auth-logo-sm">
                    <img src="<?= h($logo) ?>" alt="Logo PERUMDA Air Minum Muara Tirta">
                    <span><b>PERUMDA Air Minum Muara Tirta</b><small>Admin Console · Kota Gorontalo</small></span>
                </div>

                <h2>Selamat datang 👋</h2>
                <p class="lead">Masuk dengan akun admin untuk melanjutkan.</p>

                <?php if ($loginError) : ?>
                <div class="auth-alert" role="alert"><i class="bi bi-exclamation-circle-fill"></i><span><?= h($loginError) ?></span></div>
                <?php endif; ?>

                <form method="post" id="login-form" novalidate>
                    <div class="field">
                        <label for="u_name">Username</label>
                        <div class="input-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" id="u_name" name="u_name" class="form-control<?= $loginError ? ' is-invalid' : '' ?>"
                                value="<?= h($lastUser) ?>" placeholder="Masukkan username" autocomplete="username"
                                autocapitalize="none" spellcheck="false" required <?= $lastUser === '' ? 'autofocus' : '' ?>>
                        </div>
                    </div>
                    <div class="field">
                        <label for="pass">Password</label>
                        <div class="input-icon">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="pass" name="pass" class="form-control<?= $loginError ? ' is-invalid' : '' ?>"
                                placeholder="Masukkan password" autocomplete="current-password" required <?= $lastUser !== '' ? 'autofocus' : '' ?>>
                            <button type="button" class="ii-toggle" data-password-toggle aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                        </div>
                        <span class="caps-hint" id="caps-hint"><i class="bi bi-capslock-fill"></i> Caps Lock aktif</span>
                    </div>

                    <div class="auth-row">
                        <span class="text-muted">Lupa kata sandi?</span>
                        <a href="<?= BASE_URL ?>/forgot-password">Reset password</a>
                    </div>

                    <button class="btn btn-primary auth-submit" name="loginAdmin" type="submit">
                        Masuk <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <div class="auth-secure"><i class="bi bi-shield-lock"></i> Area khusus petugas PERUMDA Air Minum Muara Tirta.</div>
            </div>
        </main>
    </div>

    <?php adminFlashScript(); ?>
    <script>
        (function () {
            var form = document.getElementById('login-form');
            var user = document.getElementById('u_name');
            var pass = document.getElementById('pass');
            var caps = document.getElementById('caps-hint');

            // Peringatan Caps Lock saat mengetik password
            ['keydown', 'keyup'].forEach(function (ev) {
                pass.addEventListener(ev, function (e) {
                    if (e.getModifierState) caps.classList.toggle('on', e.getModifierState('CapsLock'));
                });
            });
            pass.addEventListener('blur', function () { caps.classList.remove('on'); });

            // Validasi ringan sebelum kirim, tanpa memblokir tombol (name="loginAdmin" harus ikut terkirim)
            form.addEventListener('submit', function (e) {
                var empty = [user, pass].filter(function (el) { return !el.value.trim(); });
                [user, pass].forEach(function (el) { el.classList.toggle('is-invalid', empty.indexOf(el) !== -1); });
                if (empty.length) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    empty[0].focus();
                    if (window.MT) MT.toast('Username dan password wajib diisi.', 'warning');
                }
            }, true);
        })();
    </script>
</body>

</html>
