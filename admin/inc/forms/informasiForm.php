<?php
// Form tulis/edit informasi, dipakai admin/informasi/tambah.php dan edit.php.
// $informasi: baris data (edit) atau null (tambah). Nama field & tombol mengikuti app/controllers/info.php.
$isEdit = !empty($informasi);
$val = function ($key) use ($informasi) {
    return h($informasi[$key] ?? '');
};
$currentTag = $informasi['tag'] ?? 'Berita';
$tags = [
    'Berita' => ['bi-newspaper', 'Kabar kegiatan & pengumuman umum'],
    'Info Gangguan' => ['bi-exclamation-triangle', 'Gangguan / pemeliharaan jaringan'],
    'Promo' => ['bi-megaphone', 'Diskon & program pelanggan'],
];
$imgUrl = $isEdit && !empty($informasi['image']) ? resolveImageUrl($informasi['image'], 'informasi', ['assets/info']) : '';
?>
<form method="post" enctype="multipart/form-data" data-warn-unsaved>
    <div class="form-layout">
        <div>
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-pencil-square"></i> Konten</h2>
                    <p>Judul yang singkat dan jelas lebih mudah ditemukan pelanggan.</p>
                </div>
                <div class="form-card-body">
                    <div class="field mb-4">
                        <label for="judul">Judul <span class="req">*</span></label>
                        <input class="form-control form-control-lg" id="judul" type="text" name="judul" value="<?= $val('judul') ?>"
                            maxlength="200" required autofocus placeholder="Contoh: Pemeliharaan pipa wilayah Kota Selatan" data-counter="#c-judul">
                        <div class="field-hint">
                            <span id="slug-preview" class="mono" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap"></span>
                            <span id="c-judul" style="flex:0 0 auto"></span>
                        </div>
                    </div>
                    <div class="field">
                        <span class="field-label" id="lbl-desk">Isi informasi <span class="req">*</span></span>
                        <div class="rte" data-rte data-target="#deskripsi" aria-labelledby="lbl-desk"
                            data-draft-key="informasi-<?= $isEdit ? (int) $informasi['id'] : 'baru' ?>"
                            data-placeholder="Tuliskan isi berita/pengumuman secara lengkap: apa, kapan, di mana, dan dampaknya bagi pelanggan…">
                            <div class="rte-toolbar">
                                <span class="ql-formats">
                                    <select class="ql-header" title="Gaya teks">
                                        <option selected></option>
                                        <option value="2"></option>
                                        <option value="3"></option>
                                    </select>
                                </span>
                                <span class="ql-formats">
                                    <button type="button" class="ql-bold"></button>
                                    <button type="button" class="ql-italic"></button>
                                    <button type="button" class="ql-underline"></button>
                                    <button type="button" class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <button type="button" class="ql-list" value="ordered"></button>
                                    <button type="button" class="ql-list" value="bullet"></button>
                                    <button type="button" class="ql-blockquote"></button>
                                    <button type="button" class="ql-link"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-align" title="Rata teks">
                                        <option selected></option>
                                        <option value="center"></option>
                                        <option value="right"></option>
                                        <option value="justify"></option>
                                    </select>
                                    <button type="button" class="ql-clean"></button>
                                </span>
                                <span class="ql-formats rte-end">
                                    <button type="button" class="ql-undo"><i class="bi bi-arrow-counterclockwise"></i></button>
                                    <button type="button" class="ql-redo"><i class="bi bi-arrow-clockwise"></i></button>
                                    <button type="button" class="rte-full" data-rte-full title="Mode fokus layar penuh"><i class="bi bi-arrows-fullscreen"></i></button>
                                </span>
                            </div>
                            <div class="rte-editor"><?= $isEdit ? sanitizeArticleHtml($informasi['deskripsi']) : '' ?></div>
                            <div class="rte-foot">
                                <span data-rte-words>0 kata</span>
                                <span data-rte-saved class="rte-saved"></span>
                                <span class="rte-keys"><kbd class="kbd">Ctrl</kbd>+<kbd class="kbd">B</kbd> tebal · <kbd class="kbd">Ctrl</kbd>+<kbd class="kbd">K</kbd> tautan</span>
                            </div>
                        </div>
                        <textarea id="deskripsi" name="deskripsi" hidden></textarea>
                    </div>
                </div>
            </section>
        </div>

        <aside class="side-card">
            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-tag"></i> Kategori</h2>
                </div>
                <div class="form-card-body">
                    <div class="choice-grid" style="grid-template-columns:1fr">
                        <?php foreach ($tags as $tag => [$icon, $hint]) : ?>
                        <label class="choice">
                            <input type="radio" name="tag" value="<?= h($tag) ?>" <?= $currentTag === $tag ? 'checked' : '' ?> required>
                            <span><b><i class="bi <?= $icon ?>"></i> <?= h($tag) ?></b><small><?= h($hint) ?></small></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="form-card">
                <div class="form-card-head">
                    <h2><i class="bi bi-image"></i> Gambar sampul</h2>
                    <p><?= $isEdit ? 'Biarkan jika tidak ingin mengganti gambar.' : 'Opsional, tapi sangat disarankan.' ?></p>
                </div>
                <div class="form-card-body">
                    <label class="upload" data-upload data-max-mb="5" data-initial-name="Gambar saat ini">
                        <input type="file" name="image" accept="image/png,image/jpeg">
                        <div class="upload-empty">
                            <span class="ue-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                            <b><u>Pilih gambar</u> atau seret ke sini</b>
                            <small>JPG atau PNG, maks. 5 MB · rasio 16:9 ideal</small>
                        </div>
                        <div class="upload-preview"><img <?= $imgUrl ? 'src="' . h($imgUrl) . '"' : '' ?> alt=""></div>
                        <div class="upload-bar"><span class="ub-name"></span><span class="btn-chip"><i class="bi bi-arrow-repeat"></i> Ganti</span></div>
                    </label>
                </div>
            </section>
        </aside>
    </div>

    <div class="form-actions">
        <span class="fa-note"><i class="bi bi-info-circle"></i>
            <?= $isEdit ? 'Terakhir diterbitkan ' . h(adminDate($informasi['tanggal_buat'], true)) . ' oleh ' . h($informasi['author'] ?: '-') : 'Penulis otomatis tercatat atas nama akun Anda.' ?></span>
        <div class="fa-btns">
            <a href="<?= BASE_URL ?>/admin/informasi.php" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary" name="<?= $isEdit ? 'update-info' : 'add-info' ?>">
                <i class="bi <?= $isEdit ? 'bi-check2' : 'bi-send' ?>"></i> <?= $isEdit ? 'Simpan perubahan' : 'Terbitkan' ?>
            </button>
        </div>
    </div>
</form>
<script>
    // Pratinjau alamat artikel dari judul (mengikuti slugify() di controller secara kasar)
    (function () {
        var judul = document.getElementById('judul');
        var out = document.getElementById('slug-preview');
        var base = <?= json_encode(preg_replace('#^https?://#', '', BASE_URL) . '/detail-berita/') ?>;
        function upd() {
            var s = judul.value.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '')
                .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            out.textContent = s ? base + s : '';
        }
        judul.addEventListener('input', upd);
        upd();
    })();
</script>
