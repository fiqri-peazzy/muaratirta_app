/*
 * Editor rich text untuk isi informasi/berita (Quill 2).
 * Markup: <div class="rte" data-rte data-target="#deskripsi" data-draft-key="...">
 *           <div class="rte-toolbar">…tombol ql-*…</div><div class="rte-editor">HTML awal</div>
 *           <div class="rte-foot">…</div></div>
 * Hasil disalin ke <textarea> target saat submit (getSemanticHTML -> ul/ol yang benar),
 * lalu dibersihkan lagi di server oleh sanitizeArticleHtml().
 */
(function () {
    'use strict';

    if (typeof Quill === 'undefined') return;

    // Rata teks sebagai style inline (bukan class ql-align-*) supaya tetap tampil di halaman publik
    Quill.register(Quill.import('attributors/style/align'), true);

    function store(key, val) {
        try {
            if (val === undefined) return localStorage.getItem(key);
            if (val === null) return localStorage.removeItem(key);
            localStorage.setItem(key, val);
        } catch (e) {
            return null;
        }
    }

    function fmtTime(ts) {
        var d = new Date(ts);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }) + ' ' +
            d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    function initEditor(box) {
        var target = document.querySelector(box.dataset.target);
        var form = box.closest('form');
        var toolbar = box.querySelector('.rte-toolbar');
        var area = box.querySelector('.rte-editor');
        var words = box.querySelector('[data-rte-words]');
        var saved = box.querySelector('[data-rte-saved]');
        var draftKey = box.dataset.draftKey ? 'mt-draft:' + box.dataset.draftKey : null;

        var quill = new Quill(area, {
            theme: 'snow',
            bounds: box, // tooltip tautan tidak keluar dari kotak editor
            placeholder: box.dataset.placeholder || 'Mulai menulis…',
            modules: {
                toolbar: {
                    container: toolbar,
                    handlers: {
                        undo: function () { quill.history.undo(); },
                        redo: function () { quill.history.redo(); },
                        link: function (on) {
                            if (!on) return quill.format('link', false);
                            var range = quill.getSelection(true);
                            if (!range || range.length === 0) {
                                MT.toast('Blok dulu teks yang ingin dijadikan tautan.', 'info');
                                return;
                            }
                            // Tooltip tautan inline milik tema Snow (labelnya diterjemahkan lewat CSS)
                            quill.theme.tooltip.edit('link', 'https://');
                        }
                    }
                },
                history: { delay: 800, maxStack: 200, userOnly: true }
            }
        });
        box.quill = quill;

        // Tautan dari editor selalu dibuka di tab baru
        var Link = Quill.import('formats/link');
        Link.PROTOCOL_WHITELIST = ['http', 'https', 'mailto', 'tel'];

        function html() {
            if (quill.getText().trim() === '') return '';
            // getSemanticHTML menyimpan spasi sebagai &nbsp; -> kembalikan ke spasi biasa
            return quill.getSemanticHTML().replace(/&nbsp;/g, ' ');
        }

        function updateStats() {
            var text = quill.getText().trim();
            var n = text ? text.split(/\s+/).length : 0;
            var mins = Math.max(1, Math.round(n / 200));
            if (words) words.textContent = n + ' kata · ±' + mins + ' menit baca';
        }

        // ------------------------------------------------------------- draf
        var draftTimer = null;
        function saveDraft() {
            if (!draftKey) return;
            var payload = {
                t: Date.now(),
                html: html(),
                judul: form.querySelector('[name="judul"]') ? form.querySelector('[name="judul"]').value : ''
            };
            store(draftKey, JSON.stringify(payload));
            if (saved) saved.textContent = 'Draf tersimpan ' + fmtTime(payload.t).split(' ').pop();
        }

        function scheduleDraft() {
            clearTimeout(draftTimer);
            if (saved) saved.textContent = 'Menyimpan draf…';
            draftTimer = setTimeout(saveDraft, 1200);
        }

        function offerDraft() {
            if (!draftKey) return;
            var raw = store(draftKey);
            if (!raw) return;
            var d;
            try { d = JSON.parse(raw); } catch (e) { return store(draftKey, null); }
            if (!d || !d.html || d.html === html()) return store(draftKey, null);

            var bar = document.createElement('div');
            bar.className = 'rte-draft';
            bar.innerHTML = '<i class="bi bi-clock-history"></i><span>Ada draf yang belum disimpan dari <b>' + MT.esc(fmtTime(d.t)) +
                '</b>.</span><button type="button" class="btn btn-sm btn-primary" data-act="restore">Pulihkan</button>' +
                '<button type="button" class="btn btn-sm btn-ghost" data-act="discard">Buang</button>';
            box.parentNode.insertBefore(bar, box);
            bar.addEventListener('click', function (e) {
                var act = e.target.closest('[data-act]');
                if (!act) return;
                if (act.dataset.act === 'restore') {
                    quill.setContents(quill.clipboard.convert({ html: d.html }), 'user');
                    var j = form.querySelector('[name="judul"]');
                    if (j && d.judul && !j.value) {
                        j.value = d.judul;
                        j.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                    MT.toast('Draf dipulihkan.', 'success');
                } else {
                    store(draftKey, null);
                }
                bar.remove();
            });
        }

        // ----------------------------------------------------- layar penuh
        box.querySelector('[data-rte-full]').addEventListener('click', function () {
            var on = box.classList.toggle('is-full');
            document.body.style.overflow = on ? 'hidden' : '';
            this.innerHTML = '<i class="bi ' + (on ? 'bi-fullscreen-exit' : 'bi-arrows-fullscreen') + '"></i>';
            this.title = on ? 'Keluar mode fokus (Esc)' : 'Mode fokus layar penuh';
            quill.focus();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && box.classList.contains('is-full')) box.querySelector('[data-rte-full]').click();
        });

        // ------------------------------------------------------------ event
        quill.on('text-change', function (delta, old, source) {
            updateStats();
            box.classList.remove('is-invalid');
            if (source === 'user') {
                form.dataset.dirty = '1';
                scheduleDraft();
            }
        });
        quill.root.addEventListener('focus', function () { box.classList.add('is-focus'); });
        quill.root.addEventListener('blur', function () { box.classList.remove('is-focus'); });

        // Tooltip toolbar dalam bahasa Indonesia
        var titles = {
            'ql-bold': 'Tebal (Ctrl+B)', 'ql-italic': 'Miring (Ctrl+I)', 'ql-underline': 'Garis bawah (Ctrl+U)',
            'ql-strike': 'Coret', 'ql-blockquote': 'Kutipan', 'ql-link': 'Sisipkan tautan (Ctrl+K)',
            'ql-clean': 'Hapus format', 'ql-undo': 'Batalkan (Ctrl+Z)', 'ql-redo': 'Ulangi (Ctrl+Y)'
        };
        toolbar.querySelectorAll('button').forEach(function (b) {
            Object.keys(titles).forEach(function (cls) { if (b.classList.contains(cls)) b.title = titles[cls]; });
            if (b.classList.contains('ql-list')) b.title = b.value === 'ordered' ? 'Daftar bernomor' : 'Daftar berpoin';
        });

        // Ctrl+K di dalam editor = tautan (bukan command palette)
        quill.root.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                e.stopPropagation();
                toolbar.querySelector('.ql-link').click();
            }
        });

        // Validasi + salin HTML sebelum dikirim. Didaftarkan fase capture supaya jalan sebelum
        // handler loading di console.js; tombol submit tidak di-disable (name-nya dibaca controller).
        form.addEventListener('submit', function (e) {
            var out = html();
            if (!out) {
                e.preventDefault();
                e.stopImmediatePropagation();
                box.classList.add('is-invalid');
                box.scrollIntoView({ behavior: 'smooth', block: 'center' });
                quill.focus();
                MT.toast('Isi informasi belum ditulis.', 'error', { title: 'Data belum lengkap' });
                return;
            }
            target.value = out;
            clearTimeout(draftTimer);
            store(draftKey, null);
        }, true);

        updateStats();
        offerDraft();
        // Isi awal dari server tidak dihitung sebagai perubahan
        quill.history.clear();
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-rte]').forEach(initEditor);
    });
})();
