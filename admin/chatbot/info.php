<?php
include("../../path.php");
include(ROOT_PATH . "/app/controllers/chatbot.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 2]);

$all_info = selectAll('chat_info', [], 'id');
$editing = isset($_GET['info_id']) && $id !== '';
if (!empty($errors)) {
    $_SESSION['message'] = implode(' · ', $errors);
    $_SESSION['type'] = 'error';
}

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Pengetahuan dasar (tarif, jam layanan, prosedur) yang dipakai AI chatbot untuk menyusun jawaban.',
]);
?>

<div class="form-layout aside-left">
    <aside>
        <form action="info.php<?= $editing ? '?info_id=' . (int) $id : '' ?>" method="POST" class="form-card side-card" data-warn-unsaved>
            <div class="form-card-head">
                <h2><i class="bi <?= $editing ? 'bi-pencil-square' : 'bi-plus-circle' ?>"></i> <?= $editing ? 'Edit info' : 'Info baru' ?></h2>
                <p>Tulis fakta yang jelas dan terbaru, AI akan merangkumnya untuk pelanggan.</p>
            </div>
            <div class="form-card-body">
                <?php if ($editing) : ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>
                <div class="field mb-3">
                    <label for="judul">Judul info <span class="req">*</span></label>
                    <div class="input-icon">
                        <i class="bi bi-card-text"></i>
                        <input type="text" id="judul" name="judul" class="form-control" value="<?= h($judul) ?>"
                            placeholder="Contoh: Tarif Air Golongan Rumah Tangga" maxlength="150" required>
                    </div>
                </div>
                <div class="field">
                    <label for="konten">Konten / penjelasan <span class="req">*</span></label>
                    <textarea id="konten" name="konten" class="form-control" rows="11" required data-counter="#c-k"
                        placeholder="Tuliskan detail informasinya di sini…"><?= h($konten) ?></textarea>
                    <div class="field-hint"><span><i class="bi bi-robot"></i> Dipakai AI sebagai referensi jawaban.</span><span id="c-k"></span></div>
                </div>
            </div>
            <div class="form-card-body" style="border-top:1px solid var(--c-border);display:flex;gap:10px">
                <?php if ($editing) : ?>
                <a href="info.php" class="btn btn-ghost" style="flex:1">Batal</a>
                <?php endif; ?>
                <button type="submit" name="<?= $editing ? 'update-chat-info' : 'add-chat-info' ?>" class="btn btn-primary" style="flex:2">
                    <i class="bi bi-check2"></i> <?= $editing ? 'Simpan perubahan' : 'Tambah info' ?>
                </button>
            </div>
        </form>
    </aside>

    <section class="list-panel cards-sm">
        <div class="list-head">
            <div>
                <h2>Daftar Info Layanan <span class="count"><?= count($all_info) ?></span></h2>
                <p>Semakin lengkap, semakin akurat jawaban chatbot.</p>
            </div>
        </div>
        <table class="data-table table-cards table hover" id="tbl-info-chat" data-search="Cari judul atau isi…"
            data-empty="Belum ada info layanan.">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th class="datatable-nosort">Pratinjau Konten</th>
                    <th class="datatable-nosort text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_info as $i) : ?>
                <tr<?= $editing && (int) $i['id'] === (int) $id ? ' style="background:var(--c-primary-soft)"' : '' ?>>
                    <td class="c-primary">
                        <div class="cell-user">
                            <span class="avatar av-5"><i class="bi bi-info-lg"></i></span>
                            <span class="cell-title" style="white-space:normal"><?= h($i['judul']) ?></span>
                        </div>
                    </td>
                    <td class="c-block" data-label="Konten"><span class="truncate-2"><?= h(adminExcerpt($i['konten'], 220)) ?></span></td>
                    <td class="c-actions">
                        <div class="row-actions">
                            <button type="button" class="btn-icon danger" title="Hapus info"
                                data-action="<?= BASE_URL ?>/admin/chatbot/info.php" data-method="GET" data-param-del_info="<?= (int) $i['id'] ?>"
                                data-confirm="Hapus info ini?" data-confirm-text="Chatbot tidak akan memakai informasi ini lagi."
                                data-tone="danger" data-remove="tr" data-success="Info berhasil dihapus.">
                                <i class="bi bi-trash3"></i>
                            </button>
                            <a class="btn-chip" href="info.php?info_id=<?= (int) $i['id'] ?>"><i class="bi bi-pencil-square"></i> Edit</a>
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
