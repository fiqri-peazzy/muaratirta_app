<?php
include('../../path.php');
include(ROOT_PATH . '/app/controllers/struktur-organisasi.php');
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1]);

$bagian = empty($_GET['id']) ? null : selectOne('jabatan', ['kd_bagian' => $_GET['id']]);
if (!$bagian) {
    $_SESSION['message'] = 'Bagian tidak ditemukan.';
    $_SESSION['type'] = 'error';
    header('Location: ' . BASE_URL . '/admin/struktur-organisasi.php');
    exit();
}
$isEdit = !empty($bagian);

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => $isEdit ? 'Kode bagian ' . $bagian['kd_bagian'] . ' tidak berubah.' : 'Kode bagian dibuat otomatis (BGN-xxxx).',
    'back' => BASE_URL . '/admin/struktur-organisasi.php',
]);
?>

<form method="post" class="form-layout single" data-warn-unsaved>
    <section class="form-card mb-0">
        <div class="form-card-head">
            <h2><i class="bi bi-diagram-3"></i> <?= $isEdit ? 'Ubah nama bagian' : 'Bagian baru' ?></h2>
            <p>Nama bagian tampil sebagai judul kelompok di struktur organisasi.</p>
        </div>
        <div class="form-card-body">
            <?php if ($isEdit) : ?><input type="hidden" name="kd_bagian" value="<?= h($bagian['kd_bagian']) ?>"><?php endif; ?>
            <div class="field">
                <label for="bagian">Nama bagian <span class="req">*</span></label>
                <div class="input-icon"><i class="bi bi-diagram-3"></i>
                    <input class="form-control form-control-lg" id="bagian" type="text" name="bagian" required autofocus maxlength="100"
                        value="<?= h($bagian['bagian'] ?? '') ?>" placeholder="Contoh: Bagian Hubungan Langganan"></div>
                <span class="field-hint">Nama harus unik, tidak boleh sama dengan bagian lain.</span>
            </div>
        </div>
        <div class="form-card-body" style="border-top:1px solid var(--c-border);display:flex;justify-content:flex-end;gap:10px">
            <a href="<?= BASE_URL ?>/admin/struktur-organisasi.php" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary" name="<?= $isEdit ? 'edit-bagian' : 'add-bagian' ?>"><i class="bi bi-check2"></i> <?= $isEdit ? 'Simpan perubahan' : 'Tambah bagian' ?></button>
        </div>
    </section>
</form>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
