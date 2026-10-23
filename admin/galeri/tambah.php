<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/galeri.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 3]);

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Foto yang diunggah langsung tampil di halaman Galeri website.',
    'back' => BASE_URL . '/admin/galeri.php',
]);
?>

<form method="post" enctype="multipart/form-data" data-warn-unsaved>
    <div class="form-layout">
        <section class="form-card">
            <div class="form-card-head">
                <h2><i class="bi bi-image"></i> Foto</h2>
                <p>Gunakan foto mendatar (landscape) dengan pencahayaan baik.</p>
            </div>
            <div class="form-card-body">
                <div class="field mb-4">
                    <label for="judul">Judul / keterangan foto <span class="req">*</span></label>
                    <input class="form-control form-control-lg" id="judul" type="text" name="judul" maxlength="150" required autofocus
                        value="<?= h($_POST['judul'] ?? '') ?>" placeholder="Contoh: Peresmian IPA Botu 2026" data-counter="#c-judul">
                    <div class="field-hint"><span>Tampil sebagai keterangan saat foto diperbesar.</span><span id="c-judul"></span></div>
                </div>
                <div class="field">
                    <span class="field-label">File gambar <span class="req">*</span></span>
                    <label class="upload" data-upload data-max-mb="5">
                        <input type="file" name="image" accept="image/png,image/jpeg" required>
                        <div class="upload-empty" style="min-height:260px">
                            <span class="ue-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                            <b><u>Pilih foto</u> atau seret ke sini</b>
                            <small>JPG atau PNG, maks. 5 MB</small>
                        </div>
                        <div class="upload-preview"><img alt=""></div>
                        <div class="upload-bar"><span class="ub-name"></span><span class="btn-chip"><i class="bi bi-arrow-repeat"></i> Ganti</span></div>
                    </label>
                </div>
            </div>
        </section>

        <aside class="side-card">
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-lightbulb"></i> Tips foto yang bagus</h2>
                </div>
                <div class="form-card-body">
                    <ul class="tips">
                        <li><i class="bi bi-aspect-ratio"></i> Rasio 4:3 atau 16:9 agar tidak terpotong di grid galeri.</li>
                        <li><i class="bi bi-brightness-high"></i> Hindari foto gelap atau buram; pilih yang paling jelas.</li>
                        <li><i class="bi bi-people"></i> Pastikan orang di foto bersedia dipublikasikan.</li>
                        <li><i class="bi bi-file-earmark-zip"></i> Foto otomatis dikompres saat diunggah.</li>
                    </ul>
                </div>
            </section>
        </aside>
    </div>

    <div class="form-actions">
        <span class="fa-note"><i class="bi bi-info-circle"></i> Foto disimpan di penyimpanan cloud (R2).</span>
        <div class="fa-btns">
            <a href="<?= BASE_URL ?>/admin/galeri.php" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary" name="add-gallery"><i class="bi bi-cloud-arrow-up"></i> Unggah foto</button>
        </div>
    </div>
</form>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
