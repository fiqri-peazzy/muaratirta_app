<?php
// Form tambah/edit staff (struktur organisasi). Dikirim via AJAX ke handler yang membalas JSON.
// $staff: baris data (edit) atau null (tambah).
$isEdit = !empty($staff);
$photo = $isEdit && !empty($staff['profile_pict']) ? resolveImageUrl($staff['profile_pict'], 'staff', ['assets/staff']) : '';
$allBagian = selectAll('jabatan');
?>
<form method="post" enctype="multipart/form-data" data-ajax-form data-warn-unsaved
    action="<?= BASE_URL ?>/admin/struktur-organisasi/<?= $isEdit ? 'edit-staff-handler.php' : 'add-staff-handler.php' ?>"
    <?= $isEdit ? '' : 'data-reset' ?>>
    <?php if ($isEdit) : ?><input type="hidden" name="id" value="<?= (int) $staff['id'] ?>"><?php endif; ?>
    <div class="form-layout">
        <section class="form-card">
            <div class="form-card-head">
                <h2><i class="bi bi-person-badge"></i> Data staff</h2>
                <p>Tampil di halaman Struktur Organisasi website.</p>
            </div>
            <div class="form-card-body form-grid">
                <div class="field span-2">
                    <label for="nm_lengkap">Nama lengkap &amp; gelar <span class="req">*</span></label>
                    <div class="input-icon"><i class="bi bi-person"></i>
                        <input class="form-control" id="nm_lengkap" type="text" name="nm_lengkap" required
                            value="<?= h($staff['nm_lengkap'] ?? '') ?>" placeholder="Contoh: Ir. Andi Lamato, S.T."></div>
                    <span class="error-text nm_lengkap_error"></span>
                </div>
                <div class="field">
                    <label for="kd_bagian">Bagian <span class="req">*</span></label>
                    <select name="kd_bagian" id="kd_bagian" class="form-control" required>
                        <option value="" disabled <?= $isEdit ? '' : 'selected' ?>>Pilih bagian…</option>
                        <?php foreach ($allBagian as $bgn) : ?>
                        <option value="<?= h($bgn['kd_bagian']) ?>" <?= $isEdit && $staff['kd_bagian'] === $bgn['kd_bagian'] ? 'selected' : '' ?>><?= h($bgn['bagian']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="error-text kd_bagian_error"></span>
                    <?php if (!$allBagian) : ?>
                    <span class="field-hint">Belum ada bagian. <a href="<?= BASE_URL ?>/admin/struktur-organisasi/add-bagian.php">Tambah bagian dulu</a>.</span>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="jabatan">Jabatan <span class="req">*</span></label>
                    <div class="input-icon"><i class="bi bi-briefcase"></i>
                        <input class="form-control" id="jabatan" type="text" name="jabatan" required
                            value="<?= h($staff['jabatan'] ?? '') ?>" placeholder="Contoh: Kepala Bagian"></div>
                    <span class="error-text jabatan_error"></span>
                </div>
            </div>
        </section>

        <aside class="side-card">
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-camera"></i> Foto</h2>
                    <p><?= $isEdit ? 'Pilih file baru untuk mengganti foto.' : 'Foto formal, latar polos, rasio 1:1.' ?></p>
                </div>
                <div class="form-card-body">
                    <label class="upload round" data-upload data-max-mb="2">
                        <input type="file" name="profile_pict" accept="image/png,image/jpeg">
                        <div class="upload-empty"><span class="ue-icon"><i class="bi bi-camera"></i></span><b>Pilih foto</b></div>
                        <div class="upload-preview"><img <?= $photo ? 'src="' . h($photo) . '"' : '' ?> alt=""></div>
                        <div class="upload-bar"><span class="ub-name"></span></div>
                    </label>
                    <p class="field-hint justify-content-center mt-3 mb-0">JPG atau PNG, maks. 2 MB</p>
                    <span class="error-text profile_pict_error justify-content-center"></span>
                </div>
            </section>
        </aside>
    </div>

    <div class="form-actions">
        <span class="fa-note"><i class="bi bi-info-circle"></i> Kolom bertanda <span class="text-danger">*</span> wajib diisi.</span>
        <div class="fa-btns">
            <a href="<?= BASE_URL ?>/admin/struktur-organisasi.php" class="btn btn-ghost">Kembali</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> <?= $isEdit ? 'Simpan perubahan' : 'Tambah staff' ?></button>
        </div>
    </div>
</form>
