<?php
include("../path.php");
include(ROOT_PATH . "/app/controllers/users.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();

$me = currentAdmin();
$pageAssets = ['crop' => true];

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Kelola data diri, foto, dan keamanan akun Anda.',
]);
?>

<div class="form-layout aside-left">
    <aside class="side-card">
        <section class="form-card profile-card">
            <div class="avatar-edit">
                <img src="<?= h(adminAvatarUrl($me)) ?>" alt="Foto profil" class="ci-avatar-photo" />
                <button type="button" title="Ganti foto" aria-label="Ganti foto profil"
                    onclick="document.getElementById('user_profile_file').click()"><i class="bi bi-camera"></i></button>
                <input type="file" name="user_profile_file" id="user_profile_file" class="d-none" accept="image/png,image/jpeg">
            </div>
            <h3 class="ci-user-name"><?= h($me['nm_lengkap'] ?: $me['username']) ?></h3>
            <p class="ci-user-email"><?= h($me['email']) ?></p>
            <div class="mt-3"><span class="tag tag-blue"><i class="bi bi-shield-check"></i> <?= h(adminRoleName($me['level'])) ?></span></div>
            <div class="profile-stats">
                <div><small>Username</small><b class="ci-user-username">@<?= h($me['username']) ?></b></div>
                <div><small>Bergabung</small><b><?= h(!empty($me['created_at']) ? adminDate($me['created_at']) : '-') ?></b></div>
            </div>
        </section>
    </aside>
    <div style="min-width:0">
        <section class="form-card">
            <div class="tabs-line" role="tablist">
                <button type="button" class="active" data-tab="#tab-profil" role="tab" aria-selected="true"><i class="bi bi-person"></i> Data diri</button>
                <button type="button" data-tab="#tab-password" role="tab" aria-selected="false"><i class="bi bi-shield-lock"></i> Keamanan</button>
            </div>

            <div class="tab-panel" id="tab-profil" role="tabpanel">
                <form id="update-profile" method="post" action="<?= BASE_URL ?>/admin/profile/upd-personal-detail.php" data-ajax-form>
                    <div class="form-card-body form-grid">
                        <div class="field span-2">
                            <label for="p-nama">Nama lengkap</label>
                            <div class="input-icon"><i class="bi bi-person"></i>
                                <input type="text" id="p-nama" name="nm_lengkap" value="<?= h($me['nm_lengkap']) ?>" class="form-control"></div>
                            <span class="error-text nm_lengkap_error"></span>
                        </div>
                        <div class="field">
                            <label for="p-username">Username <span class="req">*</span></label>
                            <div class="input-icon"><i class="bi bi-at"></i>
                                <input type="text" id="p-username" name="username" value="<?= h($me['username']) ?>" class="form-control" required minlength="6"></div>
                            <span class="error-text username_error"></span>
                        </div>
                        <div class="field">
                            <label for="p-hp">No. HP</label>
                            <div class="input-icon"><i class="bi bi-telephone"></i>
                                <input type="tel" id="p-hp" name="no_hp" value="<?= h($me['no_hp']) ?>" class="form-control" inputmode="numeric"></div>
                            <span class="error-text no_hp_error"></span>
                        </div>
                        <div class="field span-2">
                            <label for="p-email">Email <span class="req">*</span></label>
                            <div class="input-icon"><i class="bi bi-envelope"></i>
                                <input type="email" id="p-email" name="email" value="<?= h($me['email']) ?>" class="form-control" required></div>
                            <span class="field-hint">Dipakai untuk reset password dan notifikasi perubahan akun.</span>
                            <span class="error-text email_error"></span>
                        </div>
                    </div>
                    <div class="form-card-body" style="border-top:1px solid var(--c-border);display:flex;justify-content:flex-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Simpan perubahan</button>
                    </div>
                </form>
            </div>

            <div class="tab-panel" id="tab-password" role="tabpanel" hidden>
                <form id="change-password-form" action="<?= BASE_URL ?>/admin/profile/change-password.php" method="post" data-ajax-form data-reset>
                    <div class="form-card-body form-grid">
                        <div class="field span-2">
                            <label for="pw-old">Password saat ini <span class="req">*</span></label>
                            <div class="input-icon"><i class="bi bi-lock"></i>
                                <input type="password" id="pw-old" name="current_password" class="form-control" autocomplete="current-password" required>
                                <button type="button" class="ii-toggle" data-password-toggle aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div>
                            <span class="error-text current_password_error"></span>
                        </div>
                        <div class="field">
                            <label for="pw-new">Password baru <span class="req">*</span></label>
                            <div class="input-icon"><i class="bi bi-key"></i>
                                <input type="password" id="pw-new" name="new_password" class="form-control" autocomplete="new-password" required minlength="6" data-strength="#pw-meter">
                                <button type="button" class="ii-toggle" data-password-toggle aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div>
                            <div class="strength" id="pw-meter" data-level="0"><span></span><span></span><span></span><span></span></div>
                            <span class="error-text new_password_error"></span>
                        </div>
                        <div class="field">
                            <label for="pw-confirm">Ulangi password baru <span class="req">*</span></label>
                            <div class="input-icon"><i class="bi bi-key"></i>
                                <input type="password" id="pw-confirm" name="confirm_password" class="form-control" autocomplete="new-password" required>
                                <button type="button" class="ii-toggle" data-password-toggle aria-label="Tampilkan password"><i class="bi bi-eye"></i></button></div>
                            <span class="error-text confirm_password_error"></span>
                        </div>
                        <div class="span-2">
                            <ul class="tips">
                                <li><i class="bi bi-check2-circle"></i> Minimal 6 karakter; campuran huruf besar, angka, dan simbol lebih aman.</li>
                                <li><i class="bi bi-envelope"></i> Email pemberitahuan dikirim setelah password berhasil diganti.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-card-body" style="border-top:1px solid var(--c-border);display:flex;justify-content:flex-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-shield-check"></i> Ganti password</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

</div>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
<script>
    $('#user_profile_file').ijaboCropTool({
        preview: '.ci-avatar-photo, .user-icon img, .sidebar-user img',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        buttonsText: ['Simpan', 'Batal'],
        buttonsColor: ['#0b7bd6', '#94a3b8', -15],
        processUrl: '<?= BASE_URL ?>/admin/profile/update-profile-pict.php',
        onSuccess: function (message, element, status) {
            MT.toast(status == 1 ? 'Foto profil berhasil diperbarui.' : (message || 'Gagal memperbarui foto.'), status == 1 ? 'success' : 'error');
        },
        onError: function (message) {
            MT.toast(message || 'Gagal memperbarui foto.', 'error');
        }
    });

    // Sinkronkan nama/email di kartu profil & header setelah data diri disimpan
    document.getElementById('update-profile').addEventListener('mt:saved', function (e) {
        var u = e.detail.user_info || {};
        document.querySelectorAll('.ci-user-name').forEach(function (el) { el.textContent = u.nm_lengkap || u.username || ''; });
        document.querySelectorAll('.ci-user-email').forEach(function (el) { el.textContent = u.email || ''; });
        document.querySelectorAll('.ci-user-username').forEach(function (el) { el.textContent = '@' + (u.username || ''); });
        document.querySelectorAll('.user-name b').forEach(function (el) { el.textContent = u.username || ''; });
    });
</script>
</body>

</html>
