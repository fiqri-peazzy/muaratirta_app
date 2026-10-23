<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/users.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1]);

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Buat akun baru untuk staff yang perlu mengakses panel admin.',
    'back' => BASE_URL . '/admin/users.php',
]);
?>

<form action="<?= BASE_URL ?>/admin/users/add-user-handler.php" method="post" enctype="multipart/form-data"
    data-ajax-form data-reset data-warn-unsaved autocomplete="off">
    <div class="form-layout">
        <div>
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-person-badge"></i> Data diri</h2>
                    <p>Nama dan kontak yang terlihat oleh admin lain.</p>
                </div>
                <div class="form-card-body form-grid">
                    <div class="field span-2">
                        <label for="nm_lengkap">Nama lengkap <span class="req">*</span></label>
                        <div class="input-icon"><i class="bi bi-person"></i>
                            <input type="text" id="nm_lengkap" name="nm_lengkap" class="form-control" placeholder="Nama sesuai identitas" required></div>
                        <span class="error-text nm_lengkap_error"></span>
                    </div>
                    <div class="field">
                        <label for="email">Email <span class="req">*</span></label>
                        <div class="input-icon"><i class="bi bi-envelope"></i>
                            <input type="email" id="email" name="email" class="form-control" placeholder="nama@muaratirta.co.id" required></div>
                        <span class="error-text email_error"></span>
                    </div>
                    <div class="field">
                        <label for="no_hp">No. HP <span class="opt">(opsional)</span></label>
                        <div class="input-icon"><i class="bi bi-telephone"></i>
                            <input type="tel" id="no_hp" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" inputmode="numeric"></div>
                        <span class="error-text no_hp_error"></span>
                    </div>
                </div>
            </section>

            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-key"></i> Akses login</h2>
                    <p>Username minimal 6 karakter. Bagikan password secara langsung, jangan lewat grup chat.</p>
                </div>
                <div class="form-card-body form-grid">
                    <div class="field span-2">
                        <label for="username">Username <span class="req">*</span></label>
                        <div class="input-icon"><i class="bi bi-at"></i>
                            <input type="text" id="username" name="username" class="form-control" placeholder="mis. cs_kotaselatan" minlength="6" required autocomplete="off"></div>
                        <span class="error-text username_error"></span>
                    </div>
                    <div class="field">
                        <label for="password">Password <span class="req">*</span></label>
                        <div class="input-icon"><i class="bi bi-lock"></i>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required autocomplete="new-password" data-strength="#pw-meter">
                            <button type="button" class="ii-toggle" data-password-toggle aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div>
                        <div class="strength" id="pw-meter" data-level="0"><span></span><span></span><span></span><span></span></div>
                        <span class="error-text password_error"></span>
                    </div>
                    <div class="field">
                        <label for="confirm_password">Ulangi password <span class="req">*</span></label>
                        <div class="input-icon"><i class="bi bi-lock"></i>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Ketik ulang password" required autocomplete="new-password">
                            <button type="button" class="ii-toggle" data-password-toggle aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div>
                        <span class="error-text confirm_password_error"></span>
                    </div>
                </div>
            </section>
        </div>

        <aside class="side-card">
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-shield-check"></i> Hak akses <span class="req">*</span></h2>
                    <p>Menentukan menu yang bisa dibuka.</p>
                </div>
                <div class="form-card-body">
                    <div class="choice-grid" style="grid-template-columns:1fr">
                        <label class="choice"><input type="radio" name="level" value="2" required>
                            <span><b><i class="bi bi-headset"></i> Customer Service</b><small>Pengaduan, pasang baru, chatbot</small></span></label>
                        <label class="choice"><input type="radio" name="level" value="3">
                            <span><b><i class="bi bi-archive"></i> Arsip &amp; Publikasi</b><small>Informasi/berita dan galeri</small></span></label>
                        <label class="choice"><input type="radio" name="level" value="1">
                            <span><b><i class="bi bi-shield-check"></i> Administrator</b><small>Semua menu, termasuk kelola user</small></span></label>
                    </div>
                    <span class="error-text level_error mt-2"></span>
                </div>
            </section>
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-camera"></i> Foto profil <span class="opt">(opsional)</span></h2>
                </div>
                <div class="form-card-body">
                    <label class="upload round" data-upload data-max-mb="2">
                        <input type="file" name="profile_pict" accept="image/png,image/jpeg">
                        <div class="upload-empty"><span class="ue-icon"><i class="bi bi-camera"></i></span><b>Pilih foto</b></div>
                        <div class="upload-preview"><img alt=""></div>
                        <div class="upload-bar"><span class="ub-name"></span></div>
                    </label>
                    <span class="error-text profile_pict_error mt-2"></span>
                </div>
            </section>
        </aside>
    </div>

    <div class="form-actions">
        <span class="fa-note"><i class="bi bi-info-circle"></i> Kolom bertanda <span class="text-danger">*</span> wajib diisi.</span>
        <div class="fa-btns">
            <a href="<?= BASE_URL ?>/admin/users.php" class="btn btn-ghost">Kembali</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus"></i> Buat akun</button>
        </div>
    </div>
</form>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
