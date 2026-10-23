<?php
include("../../path.php");
include(ROOT_PATH . "/app/controllers/chatbot.php");
include(ROOT_PATH . '/app/helpers/middleware.php');
adminOnly();
adminLevel([1, 2]);

$all_history = selectAll('chat_history', [], 'created_at');
$sessions = count(array_unique(array_column($all_history, 'session_id')));
$today = count(array_filter($all_history, function ($h) {
    return date('Y-m-d', strtotime($h['created_at'])) === date('Y-m-d');
}));
$intents = array_count_values(array_map(function ($h) {
    return $h['intent'] ?: 'umum';
}, $all_history));
arsort($intents);
$topIntent = $intents ? array_key_first($intents) : '-';

include ROOT_PATH . '/admin/inc/layoutStart.php';

adminPageHeader([
    'desc' => 'Percakapan pelanggan dengan asisten chatbot di website. Pakai untuk menemukan pertanyaan yang belum ada di FAQ.',
]);
?>

<section class="mini-stats">
    <div class="mini-stat tone-blue"><span class="kpi-icon"><i class="bi bi-chat-dots"></i></span>
        <div><b><?= count($all_history) ?></b><small>Total pesan</small></div>
    </div>
    <div class="mini-stat tone-violet"><span class="kpi-icon"><i class="bi bi-people"></i></span>
        <div><b><?= $sessions ?></b><small>Sesi percakapan</small></div>
    </div>
    <div class="mini-stat tone-green"><span class="kpi-icon"><i class="bi bi-calendar-event"></i></span>
        <div><b><?= $today ?></b><small>Pesan hari ini</small></div>
    </div>
    <div class="mini-stat tone-amber"><span class="kpi-icon"><i class="bi bi-lightning"></i></span>
        <div><b style="font-size:16px"><?= h($topIntent) ?></b><small>Topik terbanyak</small></div>
    </div>
</section>

<section class="list-panel cards-sm">
    <div class="list-head">
        <div>
            <h2>Log Percakapan <span class="count"><?= count($all_history) ?></span></h2>
            <p>Terbaru di atas.</p>
        </div>
        <?php if ($intents) : ?>
        <div class="chips" data-dt-filter="#tbl-history" data-col="1" role="group" aria-label="Filter topik">
            <button type="button" class="chip active" data-value="">Semua</button>
            <?php foreach (array_slice($intents, 0, 5, true) as $intent => $n) : ?>
            <button type="button" class="chip" data-value="<?= h($intent) ?>"><?= h($intent) ?> <span class="n"><?= $n ?></span></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <table class="data-table table-cards table" id="tbl-history" data-search="Cari isi pesan…" data-empty="Belum ada percakapan.">
        <thead>
            <tr>
                <th class="datatable-nosort">Percakapan</th>
                <th>Topik</th>
                <th>Sesi</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_history as $h) : $intent = $h['intent'] ?: 'umum'; ?>
            <tr>
                <td class="c-block" data-label="Percakapan">
                    <div class="chat-thread">
                        <div class="bubble user"><small>Pelanggan</small><?= h($h['user_message']) ?></div>
                        <div class="bubble bot"><small><i class="bi bi-robot"></i> Chatbot</small><?= h(adminExcerpt($h['bot_response'], 320)) ?></div>
                    </div>
                </td>
                <td class="c-status" data-search="<?= h($intent) ?>"><span class="tag tag-blue"><?= h($intent) ?></span></td>
                <td data-label="Sesi"><span class="mono" title="<?= h($h['session_id']) ?>">…<?= h(substr($h['session_id'], -8)) ?></span></td>
                <td class="c-primary" data-label="Waktu" data-order="<?= strtotime($h['created_at']) ?>">
                    <div>
                        <span class="cell-title" style="font-weight:500"><?= h(adminDate($h['created_at'], true)) ?></span>
                        <span class="cell-sub"><?= h(adminTimeHint($h['created_at'])) ?></span>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php include ROOT_PATH . '/admin/inc/layoutEnd.php'; ?>
</body>

</html>
