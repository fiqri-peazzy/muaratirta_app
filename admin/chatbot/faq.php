<?php
include("../../path.php");
include(ROOT_PATH . "/app/controllers/chatbot.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 2]);

$all_faq = selectAll('chat_faq', [], 'id');
$editing = isset($_GET['id']) && $id !== '';
$activeCount = count(array_filter($all_faq, function ($f) {
    return (int) $f['is_active'] === 1;
}));
if (!empty($errors)) {
    $_SESSION['message'] = implode(' · ', $errors);
    $_SESSION['type'] = 'error';
}

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Pertanyaan yang sering diajukan. Asisten chatbot memakai jawaban ini sebagai acuan utama.',
]);
?>

<div class="form-layout aside-left">
    <aside>
        <form action="faq.php<?= $editing ? '?id=' . (int) $id : '' ?>" method="POST" class="form-card side-card" data-warn-unsaved>
            <div class="form-card-head">
                <h2><i class="bi <?= $editing ? 'bi-pencil-square' : 'bi-plus-circle' ?>"></i> <?= $editing ? 'Edit FAQ' : 'FAQ baru' ?></h2>
                <p><?= $editing ? 'Perubahan langsung dipakai chatbot setelah disimpan.' : 'Tulis pertanyaan seperti yang biasa diketik pelanggan.' ?></p>
            </div>
            <div class="form-card-body">
                <?php if ($editing) : ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>
                <div class="field mb-3">
                    <label for="pertanyaan">Pertanyaan <span class="req">*</span></label>
                    <textarea id="pertanyaan" name="pertanyaan" class="form-control" rows="3" maxlength="255" required
                        placeholder="Contoh: Bagaimana cara cek tagihan air?" data-counter="#c-q"><?= h($pertanyaan) ?></textarea>
                    <div class="field-hint"><span>Singkat dan jelas.</span><span id="c-q"></span></div>
                </div>
                <div class="field mb-3">
                    <label for="jawaban">Jawaban <span class="req">*</span></label>
                    <textarea id="jawaban" name="jawaban" class="form-control" rows="7" required
                        placeholder="Jawaban lengkap yang akan dikirim chatbot…" data-counter="#c-a"><?= h($jawaban) ?></textarea>
                    <div class="field-hint"><span>Boleh beberapa paragraf.</span><span id="c-a"></span></div>
                </div>
                <input type="hidden" name="is_active" value="0">
                <label class="switch">
                    <input type="checkbox" name="is_active" value="1" <?= (int) $is_active === 1 ? 'checked' : '' ?>>
                    <span class="track"></span> Aktif dipakai chatbot
                </label>
            </div>
            <div class="form-card-body" style="border-top:1px solid var(--c-border);display:flex;gap:10px">
                <?php if ($editing) : ?>
                <a href="faq.php" class="btn btn-ghost" style="flex:1">Batal</a>
                <?php endif; ?>
                <button type="submit" name="<?= $editing ? 'update-faq' : 'add-faq' ?>" class="btn btn-primary" style="flex:2">
                    <i class="bi bi-check2"></i> <?= $editing ? 'Simpan perubahan' : 'Tambah FAQ' ?>
                </button>
            </div>
        </form>
    </aside>

    <section class="list-panel cards-sm">
        <div class="list-head">
            <div>
                <h2>Daftar FAQ <span class="count"><?= count($all_faq) ?></span></h2>
                <p><?= $activeCount ?> aktif · <?= count($all_faq) - $activeCount ?> nonaktif</p>
            </div>
            <div class="chips" data-dt-filter="#tbl-faq" data-col="1" role="group" aria-label="Filter status">
                <button type="button" class="chip active" data-value="">Semua</button>
                <button type="button" class="chip chip-done" data-value="Aktif"><span class="dot"></span>Aktif</button>
                <button type="button" class="chip chip-open" data-value="Nonaktif"><span class="dot"></span>Nonaktif</button>
            </div>
        </div>
        <table class="data-table table-cards table hover" id="tbl-faq" data-search="Cari pertanyaan atau jawaban…"
            data-empty="Belum ada FAQ.">
            <thead>
                <tr>
                    <th>Pertanyaan &amp; Jawaban</th>
                    <th>Status</th>
                    <th class="datatable-nosort text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_faq as $f) : $on = (int) $f['is_active'] === 1; ?>
                <tr<?= $editing && (int) $f['id'] === (int) $id ? ' style="background:var(--c-primary-soft)"' : '' ?>>
                    <td class="c-primary">
                        <div style="min-width:0">
                            <span class="cell-title" style="white-space:normal;max-width:520px"><?= h($f['pertanyaan']) ?></span>
                            <span class="cell-sub truncate-2" style="max-width:520px"><?= h(adminExcerpt($f['jawaban'], 160)) ?></span>
                        </div>
                    </td>
                    <td class="c-status" data-search="<?= $on ? 'Aktif' : 'Nonaktif' ?>">
                        <span class="status-pill <?= $on ? 'is-done' : 'is-open' ?>"><?= $on ? 'Aktif' : 'Nonaktif' ?></span>
                    </td>
                    <td class="c-actions">
                        <div class="row-actions">
                            <button type="button" class="btn-icon danger" title="Hapus FAQ"
                                data-action="<?= BASE_URL ?>/admin/chatbot/faq.php" data-method="GET" data-param-del_faq="<?= (int) $f['id'] ?>"
                                data-confirm="Hapus FAQ ini?" data-confirm-text="Chatbot tidak akan memakai jawaban ini lagi."
                                data-tone="danger" data-remove="tr" data-success="FAQ berhasil dihapus.">
                                <i class="bi bi-trash3"></i>
                            </button>
                            <a class="btn-chip" href="faq.php?id=<?= (int) $f['id'] ?>"><i class="bi bi-pencil-square"></i> Edit</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
