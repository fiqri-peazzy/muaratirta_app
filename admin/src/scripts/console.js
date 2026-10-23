/*
 * Muara Tirta Admin Console
 * Tema, sidebar ciut, command palette (Ctrl+K), dan pustaka komponen UI kecil (window.MT):
 * toast, dialog konfirmasi, request/form AJAX, upload gambar, lightbox, aksi baris tabel.
 * Vanilla JS supaya tidak bergantung pada urutan load jQuery/DeskApp di tiap halaman.
 * Tema & status sidebar awal sudah dipasang di <head> oleh inc/consoleHead.php.
 */
(function () {
    'use strict';

    var root = document.documentElement;
    var MT = window.MT = window.MT || {};

    function store(key, value) {
        try {
            if (value === undefined) return localStorage.getItem(key);
            localStorage.setItem(key, value);
        } catch (e) {
            return null;
        }
    }

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    MT.esc = esc;

    // ================================================================ tema
    function setTheme(theme) {
        root.setAttribute('data-theme', theme);
        store('mt-theme', theme);
        document.dispatchEvent(new CustomEvent('mt:themechange', { detail: { theme: theme } }));
    }

    function toggleTheme() {
        setTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    }

    // ======================================================= sidebar ciut
    function toggleSidebar() {
        var collapsed = root.classList.toggle('sb-collapsed');
        store('mt-sb', collapsed ? '1' : '0');
        // beri kesempatan chart/datatable menyesuaikan lebar setelah transisi
        setTimeout(function () {
            window.dispatchEvent(new Event('resize'));
        }, 260);
    }

    // =============================================================== toast
    var TOAST_ICON = {
        success: 'bi-check-circle-fill',
        error: 'bi-x-circle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info: 'bi-info-circle-fill'
    };
    var TOAST_TITLE = { success: 'Berhasil', error: 'Gagal', warning: 'Perhatian', info: 'Info' };

    /**
     * MT.toast('Pesan', 'success'|'error'|'warning'|'info', { title, duration })
     */
    MT.toast = function (message, type, opts) {
        type = TOAST_ICON[type] ? type : (type === 'danger' ? 'error' : 'info');
        opts = opts || {};
        var duration = opts.duration || (type === 'error' ? 6000 : 4000);

        var stack = document.querySelector('.toast-stack');
        if (!stack) {
            stack = document.createElement('div');
            stack.className = 'toast-stack';
            stack.setAttribute('aria-live', 'polite');
            document.body.appendChild(stack);
        }

        var el = document.createElement('div');
        el.className = 'mt-toast t-' + type;
        el.setAttribute('role', type === 'error' ? 'alert' : 'status');
        el.innerHTML =
            '<span class="t-icon"><i class="bi ' + TOAST_ICON[type] + '"></i></span>' +
            '<span class="t-body"><b class="t-title">' + esc(opts.title || TOAST_TITLE[type]) + '</b>' +
            (message ? '<span class="t-msg">' + esc(message) + '</span>' : '') + '</span>' +
            '<button type="button" class="t-close" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>' +
            '<span class="t-bar" style="animation-duration:' + duration + 'ms"></span>';
        stack.appendChild(el);

        // maksimal 4 toast sekaligus
        while (stack.children.length > 4) stack.removeChild(stack.firstChild);

        function close() {
            if (el.classList.contains('leaving')) return;
            el.classList.add('leaving');
            setTimeout(function () { el.remove(); }, 200);
        }
        el.querySelector('.t-close').addEventListener('click', close);
        el.querySelector('.t-bar').addEventListener('animationend', close);
        return { close: close };
    };

    // Kompatibilitas untuk skrip lama yang masih memanggil toastr.*
    window.toastr = {
        success: function (m) { MT.toast(m, 'success'); },
        error: function (m) { MT.toast(m, 'error'); },
        warning: function (m) { MT.toast(m, 'warning'); },
        info: function (m) { MT.toast(m, 'info'); },
        remove: function () {},
        clear: function () {}
    };

    // ============================================================== dialog
    /**
     * MT.confirm({ title, text, confirmText, cancelText, tone: 'danger'|'primary'|'success', icon })
     * -> Promise<boolean>
     */
    MT.confirm = function (opts) {
        opts = opts || {};
        var tone = opts.tone || 'primary';
        var icon = opts.icon || (tone === 'danger' ? 'bi-trash3' : tone === 'success' ? 'bi-check2-circle' : 'bi-question-circle');
        var btnClass = tone === 'danger' ? 'btn-danger' : tone === 'success' ? 'btn-success' : 'btn-primary';

        return new Promise(function (resolve) {
            var prevFocus = document.activeElement;
            var wrap = document.createElement('div');
            wrap.className = 'mt-dialog tone-' + tone;
            wrap.setAttribute('role', 'alertdialog');
            wrap.setAttribute('aria-modal', 'true');
            wrap.innerHTML =
                '<div class="mt-dialog-box">' +
                '<div class="mt-dialog-icon"><i class="bi ' + icon + '"></i></div>' +
                '<h3>' + esc(opts.title || 'Lanjutkan?') + '</h3>' +
                (opts.text ? '<p>' + esc(opts.text) + '</p>' : '') +
                '<div class="mt-dialog-actions">' +
                '<button type="button" class="btn btn-ghost" data-act="no">' + esc(opts.cancelText || 'Batal') + '</button>' +
                '<button type="button" class="btn ' + btnClass + '" data-act="yes">' + esc(opts.confirmText || 'Ya, lanjutkan') + '</button>' +
                '</div></div>';
            document.body.appendChild(wrap);
            document.body.style.overflow = 'hidden';

            var yes = wrap.querySelector('[data-act="yes"]');
            var no = wrap.querySelector('[data-act="no"]');
            setTimeout(function () { (tone === 'danger' ? no : yes).focus(); }, 30);

            function done(val) {
                document.removeEventListener('keydown', onKey, true);
                wrap.classList.add('leaving');
                document.body.style.overflow = '';
                setTimeout(function () { wrap.remove(); }, 150);
                if (prevFocus && prevFocus.focus) prevFocus.focus();
                resolve(val);
            }

            function onKey(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                    e.stopPropagation();
                    done(false);
                } else if (e.key === 'Tab') {
                    // jebak fokus di dalam dialog
                    e.preventDefault();
                    (document.activeElement === yes ? no : yes).focus();
                }
            }

            document.addEventListener('keydown', onKey, true);
            yes.addEventListener('click', function () { done(true); });
            no.addEventListener('click', function () { done(false); });
            wrap.addEventListener('mousedown', function (e) {
                if (e.target === wrap) done(false);
            });
        });
    };

    // ============================================================= request
    /**
     * MT.request(url, { method, data (objek | FormData) }) -> Promise<{ ok, status, data, text }>
     * Balasan JSON otomatis di-parse. Sesi habis (401) -> toast + arahkan ke halaman login.
     */
    MT.request = function (url, opts) {
        opts = opts || {};
        var method = (opts.method || 'GET').toUpperCase();
        var body = null;
        var data = opts.data;

        if (data && !(data instanceof FormData)) {
            var fd = new FormData();
            Object.keys(data).forEach(function (k) { fd.append(k, data[k]); });
            data = fd;
        }
        if (method === 'GET' && data) {
            var qs = new URLSearchParams(data).toString();
            url += (url.indexOf('?') === -1 ? '?' : '&') + qs;
        } else {
            body = data;
        }

        return fetch(url, {
            method: method,
            body: body,
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json, text/plain, */*' }
        }).then(function (res) {
            return res.text().then(function (text) {
                var json = null;
                try { json = JSON.parse(text); } catch (e) { /* bukan JSON */ }
                // Handler lama kadang redirect ke halaman login saat sesi habis
                var loginRedirect = res.redirected && /\/login(\?|$)/.test(res.url);
                if (res.status === 401 || loginRedirect) {
                    MT.toast('Sesi login berakhir. Mengarahkan ke halaman login…', 'warning');
                    setTimeout(function () { window.location.href = (window.MT_BASE || '') + '/login'; }, 1600);
                }
                return { ok: res.ok && !loginRedirect, status: res.status, data: json, text: text };
            });
        }).catch(function () {
            return { ok: false, status: 0, data: null, text: '' };
        });
    };

    MT.loading = function (btn, on) {
        if (!btn) return;
        btn.classList.toggle('is-loading', !!on);
        btn.setAttribute('aria-busy', on ? 'true' : 'false');
    };

    // =========================================================== form AJAX
    /*
     * <form data-ajax-form [data-reset] [data-redirect="url"]> -> dikirim via fetch.
     * Format balasan handler lama: { status: 1|0, msg, error: { field: pesan } }.
     * Error per field ditampilkan di span.{field}_error / [data-error-for=field].
     */
    function clearErrors(form) {
        form.querySelectorAll('.error-text, .field-error').forEach(function (el) { el.textContent = ''; });
        form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
    }

    function showErrors(form, errors) {
        var first = null;
        Object.keys(errors).forEach(function (field) {
            var msg = errors[field];
            var target = form.querySelector('.' + field + '_error') || form.querySelector('[data-error-for="' + field + '"]');
            if (target) target.textContent = msg;
            var input = form.querySelector('[name="' + field + '"]');
            if (input) {
                input.classList.add('is-invalid');
                if (!first) first = input;
            }
        });
        if (first) {
            first.focus({ preventScroll: true });
            first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        MT.toast('Periksa kembali isian yang ditandai merah.', 'error', { title: 'Data belum valid' });
    }

    function submitAjaxForm(form, submitter) {
        if (form.dataset.busy === '1') return;
        form.dataset.busy = '1';
        var btn = submitter || form.querySelector('[type="submit"]');
        MT.loading(btn, true);
        clearErrors(form);

        var fd = new FormData(form);
        if (submitter && submitter.name) fd.append(submitter.name, submitter.value || '1');

        MT.request(form.getAttribute('action') || window.location.href, {
            method: form.getAttribute('method') || 'POST',
            data: fd
        }).then(function (res) {
            form.dataset.busy = '0';
            MT.loading(btn, false);
            var r = res.data;
            if (res.status === 401) return;
            if (!r) {
                MT.toast('Server tidak memberi balasan yang valid. Coba lagi beberapa saat.', 'error');
                return;
            }
            if (r.error && Object.keys(r.error).length) {
                showErrors(form, r.error);
                return;
            }
            if (r.status == 1 || r.success == 1) {
                MT.toast(r.msg || 'Data berhasil disimpan.', 'success');
                form.dataset.dirty = '0';
                if (form.hasAttribute('data-reset')) {
                    form.reset();
                    form.querySelectorAll('[data-upload]').forEach(resetUpload);
                    form.querySelectorAll('.strength').forEach(function (s) { s.setAttribute('data-level', '0'); });
                }
                form.dispatchEvent(new CustomEvent('mt:saved', { detail: r }));
                if (form.dataset.redirect) {
                    setTimeout(function () { window.location.href = form.dataset.redirect; }, 900);
                }
            } else {
                MT.toast(r.msg || 'Gagal menyimpan data.', 'error');
            }
        });
    }

    // ============================================================== upload
    function fmtSize(bytes) {
        return bytes > 1048576 ? (bytes / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(bytes / 1024)) + ' KB';
    }

    function resetUpload(box) {
        var input = box.querySelector('input[type="file"]');
        var img = box.querySelector('.upload-preview img');
        if (input) input.value = '';
        if (box.dataset.initial) {
            img.src = box.dataset.initial;
            box.classList.add('has-file');
            setUploadName(box, box.dataset.initialName || 'Gambar saat ini', '');
        } else {
            if (img) img.removeAttribute('src');
            box.classList.remove('has-file');
        }
    }

    function setUploadName(box, name, size) {
        var n = box.querySelector('.ub-name');
        if (n) n.innerHTML = esc(name) + (size ? '<small>' + esc(size) + '</small>' : '');
    }

    function initUpload(box) {
        if (box.dataset.ready) return;
        box.dataset.ready = '1';
        var input = box.querySelector('input[type="file"]');
        var img = box.querySelector('.upload-preview img');
        var maxMb = parseFloat(box.dataset.maxMb || '5');
        if (img && img.getAttribute('src')) {
            box.dataset.initial = img.getAttribute('src');
            box.classList.add('has-file');
            setUploadName(box, box.dataset.initialName || 'Gambar saat ini', '');
        }

        function handle(file) {
            if (!file) return resetUpload(box);
            if (!/^image\//.test(file.type)) {
                MT.toast('File harus berupa gambar (JPG atau PNG).', 'error');
                return resetUpload(box);
            }
            if (file.size > maxMb * 1048576) {
                MT.toast('Ukuran gambar maksimal ' + maxMb + ' MB (file ini ' + fmtSize(file.size) + ').', 'error');
                return resetUpload(box);
            }
            img.src = URL.createObjectURL(file);
            box.classList.add('has-file');
            setUploadName(box, file.name, fmtSize(file.size));
            var form = box.closest('form');
            if (form) form.dataset.dirty = '1';
        }

        input.addEventListener('change', function () { handle(input.files[0]); });
        ['dragenter', 'dragover'].forEach(function (ev) {
            box.addEventListener(ev, function (e) { e.preventDefault(); box.classList.add('drag'); });
        });
        ['dragleave', 'drop'].forEach(function (ev) {
            box.addEventListener(ev, function () { box.classList.remove('drag'); });
        });
        box.addEventListener('drop', function (e) {
            e.preventDefault();
            var f = e.dataTransfer.files && e.dataTransfer.files[0];
            if (!f) return;
            try {
                var dt = new DataTransfer();
                dt.items.add(f);
                input.files = dt.files;
            } catch (err) { /* browser lama: tetap tampilkan preview */ }
            handle(f);
        });
    }

    // ============================================================ password
    function scorePassword(v) {
        var s = 0;
        if (v.length >= 8) s++;
        if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s++;
        if (/\d/.test(v)) s++;
        if (/[^A-Za-z0-9]/.test(v) || v.length >= 12) s++;
        return v ? Math.max(1, s) : 0;
    }

    // ============================================================ lightbox
    MT.lightbox = function (src, caption) {
        var lb = document.createElement('figure');
        lb.className = 'lightbox';
        lb.innerHTML = '<a class="lb-open" href="' + esc(src) + '" target="_blank" rel="noopener" title="Buka di tab baru"><i class="bi bi-box-arrow-up-right"></i></a>' +
            '<button type="button" class="lb-close" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>' +
            '<img src="' + esc(src) + '" alt="">' + (caption ? '<figcaption>' + esc(caption) + '</figcaption>' : '');
        document.body.appendChild(lb);
        document.body.style.overflow = 'hidden';

        function close() {
            document.removeEventListener('keydown', onKey);
            document.body.style.overflow = '';
            lb.remove();
        }

        function onKey(e) { if (e.key === 'Escape') close(); }
        document.addEventListener('keydown', onKey);
        lb.addEventListener('click', function (e) {
            if (e.target === lb || e.target.closest('.lb-close')) close();
        });
    };

    // ===================================================== aksi baris/hapus
    /*
     * <button data-action="url" data-method="POST" data-param-id="5"
     *         data-confirm="Hapus pengaduan?" data-confirm-text="..." data-tone="danger"
     *         data-remove="tr" data-redirect="url" data-success="Pesan sukses">
     */
    function removeRow(el, selector) {
        var target = el.closest(selector);
        if (!target) return;
        var tableEl = target.closest('table');
        if (target.tagName === 'TR' && window.jQuery && tableEl && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable(tableEl)) {
            jQuery(target).css('opacity', .3);
            setTimeout(function () { jQuery(tableEl).DataTable().row(target).remove().draw(false); }, 180);
            return;
        }
        target.style.transition = 'opacity .25s ease, transform .25s ease';
        target.style.opacity = '0';
        target.style.transform = 'scale(.97)';
        setTimeout(function () {
            target.remove();
            document.dispatchEvent(new CustomEvent('mt:removed'));
        }, 250);
    }

    function runAction(btn) {
        var ds = btn.dataset;
        var params = {};
        Object.keys(ds).forEach(function (k) {
            if (k.indexOf('param') === 0 && k.length > 5) {
                // dataset mengubah data-param-hapus-img -> paramHapusImg; kembalikan ke "hapus-img"
                var name = k.slice(5);
                name = name.charAt(0).toLowerCase() + name.slice(1).replace(/[A-Z]/g, function (c) { return '-' + c.toLowerCase(); });
                params[name] = ds[k];
            }
        });

        var go = function () {
            MT.loading(btn, true);
            MT.request(ds.action, { method: ds.method || 'POST', data: params }).then(function (res) {
                MT.loading(btn, false);
                if (res.status === 401) return;
                var r = res.data;
                var failed = !res.ok || (r && (r.success === 0 || r.status === 0));
                if (failed) {
                    MT.toast((r && r.msg) || 'Aksi gagal diproses. Coba lagi.', 'error');
                    return;
                }
                MT.toast(ds.success || (r && r.msg) || 'Berhasil.', 'success');
                if (ds.remove) removeRow(btn, ds.remove);
                btn.dispatchEvent(new CustomEvent('mt:done', { bubbles: true, detail: r }));
                if (ds.redirect) setTimeout(function () { window.location.href = ds.redirect; }, 900);
            });
        };

        if (ds.confirm) {
            MT.confirm({
                title: ds.confirm,
                text: ds.confirmText || (ds.tone === 'danger' ? 'Data yang dihapus tidak bisa dikembalikan.' : ''),
                confirmText: ds.confirmBtn || (ds.tone === 'danger' ? 'Ya, hapus' : 'Ya, lanjutkan'),
                tone: ds.tone || 'danger'
            }).then(function (ok) { if (ok) go(); });
        } else {
            go();
        }
    }

    // ===================================================== command palette
    var palette, input, list, items = [], filtered = [], selected = 0;

    function collectItems() {
        var out = [];
        var group = 'Menu';
        document.querySelectorAll('#accordion-menu > li').forEach(function (li) {
            var label = li.querySelector('.menu-label');
            if (label) {
                group = label.textContent.trim();
                return;
            }
            var parentLink = li.querySelector(':scope > a');
            var parentIcon = parentLink && parentLink.querySelector('.micon');
            var iconClass = parentIcon ? parentIcon.className.replace('micon', '').trim() : 'bi bi-dot';
            var subs = li.querySelectorAll('.submenu a[href]');
            if (subs.length) {
                var parentText = parentLink.textContent.trim();
                subs.forEach(function (a) {
                    out.push({ group: group, text: a.textContent.trim(), hint: parentText, href: a.href, icon: iconClass });
                });
            } else if (parentLink && parentLink.getAttribute('href') && parentLink.getAttribute('href').indexOf('javascript') !== 0) {
                out.push({ group: group, text: parentLink.textContent.trim(), href: parentLink.href, icon: iconClass });
            }
        });

        document.querySelectorAll('[data-cmdk-extra]').forEach(function (a) {
            out.push({
                group: 'Lainnya',
                text: a.getAttribute('data-cmdk-extra'),
                href: a.getAttribute('href'),
                icon: a.getAttribute('data-cmdk-icon') || 'bi bi-dot',
                target: a.getAttribute('target') || ''
            });
        });

        out.push({ group: 'Lainnya', text: 'Ganti tema terang / gelap', icon: 'bi bi-moon-stars', action: toggleTheme });
        return out;
    }

    function render() {
        var q = input.value.trim().toLowerCase();
        filtered = items.filter(function (it) {
            return !q || (it.text + ' ' + (it.hint || '') + ' ' + it.group).toLowerCase().indexOf(q) !== -1;
        });
        if (selected >= filtered.length) selected = 0;

        if (!filtered.length) {
            list.innerHTML = '<li class="cmdk-empty">Tidak ada menu yang cocok dengan "' + esc(input.value) + '"</li>';
            return;
        }

        var html = '', lastGroup = null;
        filtered.forEach(function (it, i) {
            if (it.group !== lastGroup) {
                html += '<li class="cmdk-group">' + esc(it.group) + '</li>';
                lastGroup = it.group;
            }
            html += '<li class="cmdk-item' + (i === selected ? ' sel' : '') + '" data-i="' + i + '">' +
                '<a href="' + esc(it.href || 'javascript:;') + '"' + (it.target ? ' target="' + esc(it.target) + '" rel="noopener"' : '') + '>' +
                '<i class="' + esc(it.icon) + '"></i><span>' + esc(it.text) + '</span>' +
                (it.hint ? '<small>' + esc(it.hint) + '</small>' : '') +
                '</a></li>';
        });
        list.innerHTML = html;
        var sel = list.querySelector('.sel');
        if (sel) sel.scrollIntoView({ block: 'nearest' });
    }

    function run(i) {
        var it = filtered[i];
        if (!it) return;
        closePalette();
        if (it.action) return it.action();
        if (it.target === '_blank') window.open(it.href, '_blank', 'noopener');
        else window.location.href = it.href;
    }

    function openPalette() {
        if (!palette) return;
        items = collectItems();
        selected = 0;
        input.value = '';
        render();
        palette.classList.add('open');
        palette.setAttribute('aria-hidden', 'false');
        setTimeout(function () { input.focus(); }, 10);
    }

    function closePalette() {
        if (!palette) return;
        palette.classList.remove('open');
        palette.setAttribute('aria-hidden', 'true');
    }

    function initPalette() {
        palette = document.getElementById('cmdk');
        if (!palette) return;
        input = palette.querySelector('input');
        list = palette.querySelector('.cmdk-list');

        input.addEventListener('input', function () {
            selected = 0;
            render();
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selected = Math.min(selected + 1, filtered.length - 1);
                render();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selected = Math.max(selected - 1, 0);
                render();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                run(selected);
            }
        });

        list.addEventListener('click', function (e) {
            var li = e.target.closest('.cmdk-item');
            if (!li) return;
            e.preventDefault();
            run(parseInt(li.getAttribute('data-i'), 10));
        });

        list.addEventListener('mousemove', function (e) {
            var li = e.target.closest('.cmdk-item');
            if (!li) return;
            var i = parseInt(li.getAttribute('data-i'), 10);
            if (i !== selected) {
                selected = i;
                list.querySelectorAll('.cmdk-item').forEach(function (el) {
                    el.classList.toggle('sel', el === li);
                });
            }
        });

        palette.addEventListener('mousedown', function (e) {
            if (e.target === palette) closePalette();
        });
    }

    // ===================================================== chip filter tabel
    /*
     * <div class="chips" data-dt-filter="#tabel" data-col="4">
     *   <button class="chip active" data-value="">Semua</button>
     *   <button class="chip" data-value="Proses">Proses</button>
     */
    function initChipFilters() {
        document.querySelectorAll('[data-dt-filter]').forEach(function (group) {
            group.addEventListener('click', function (e) {
                var chip = e.target.closest('.chip');
                if (!chip || !window.jQuery) return;
                var tableEl = document.querySelector(group.dataset.dtFilter);
                if (!tableEl || !jQuery.fn.dataTable.isDataTable(tableEl)) return;
                group.querySelectorAll('.chip').forEach(function (c) { c.classList.toggle('active', c === chip); });
                var v = chip.dataset.value || '';
                var col = parseInt(group.dataset.col, 10);
                jQuery(tableEl).DataTable().column(col)
                    .search(v ? '^\\s*' + v.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\s*$' : '', true, false)
                    .draw();
            });
        });
    }

    // Gambar yang gagal dimuat (file hilang di R2/legacy) -> tandai wadahnya supaya tampil placeholder
    document.addEventListener('error', function (e) {
        var img = e.target;
        if (img.tagName !== 'IMG') return;
        var box = img.closest('.photo-card, .g-media, .thumb, .avatar, .upload-preview');
        if (box && !box.classList.contains('img-broken')) box.classList.add('img-broken');
    }, true);

    // ================================================================ init
    // Gambar yang sudah gagal sebelum skrip ini berjalan (skrip dimuat defer)
    window.addEventListener('load', function () {
        document.querySelectorAll('.photo-card img, .g-media img, .thumb img, .avatar img').forEach(function (img) {
            if (img.getAttribute('src') && img.complete && img.naturalWidth === 0) {
                img.parentNode.classList.add('img-broken');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        initPalette();
        initChipFilters();
        document.querySelectorAll('[data-upload]').forEach(initUpload);

        // Pengukur kekuatan password
        document.querySelectorAll('input[data-strength]').forEach(function (inp) {
            var meter = document.querySelector(inp.dataset.strength);
            if (!meter) return;
            inp.addEventListener('input', function () { meter.setAttribute('data-level', scorePassword(inp.value)); });
        });

        // Penghitung karakter
        document.querySelectorAll('[data-counter]').forEach(function (inp) {
            var out = document.querySelector(inp.dataset.counter);
            var max = inp.getAttribute('maxlength');
            var upd = function () { if (out) out.textContent = inp.value.length + (max ? ' / ' + max : '') + ' karakter'; };
            inp.addEventListener('input', upd);
            upd();
        });

        // Form: AJAX, status loading, dan peringatan perubahan belum disimpan
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('input', function () { form.dataset.dirty = '1'; });
            form.addEventListener('submit', function (e) {
                if (form.hasAttribute('data-ajax-form')) {
                    e.preventDefault();
                    submitAjaxForm(form, e.submitter);
                    return;
                }
                if (form.method.toLowerCase() !== 'post') return;
                if (form.dataset.busy === '1') {
                    e.preventDefault();
                    return;
                }
                form.dataset.busy = '1';
                form.dataset.dirty = '0';
                // Jangan disable tombol submit: name-nya (mis. "add-info") dipakai controller.
                MT.loading(e.submitter || form.querySelector('[type="submit"]'), true);
            });
        });

        window.addEventListener('beforeunload', function (e) {
            var dirty = document.querySelector('form[data-warn-unsaved][data-dirty="1"]');
            if (dirty) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        document.addEventListener('click', function (e) {
            var t;
            if ((t = e.target.closest('[data-theme-toggle]'))) {
                e.preventDefault();
                toggleTheme();
            } else if ((t = e.target.closest('[data-sidebar-collapse]'))) {
                e.preventDefault();
                toggleSidebar();
            } else if ((t = e.target.closest('[data-cmdk-open]'))) {
                e.preventDefault();
                openPalette();
            } else if ((t = e.target.closest('[data-action]'))) {
                e.preventDefault();
                runAction(t);
            } else if ((t = e.target.closest('[data-password-toggle]'))) {
                e.preventDefault();
                var pw = t.parentNode.querySelector('input');
                var show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                t.innerHTML = '<i class="bi ' + (show ? 'bi-eye-slash' : 'bi-eye') + '"></i>';
                t.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
            } else if ((t = e.target.closest('[data-lightbox]'))) {
                e.preventDefault();
                MT.lightbox(t.getAttribute('href') || t.dataset.lightbox, t.dataset.caption || '');
            } else if ((t = e.target.closest('[data-copy]'))) {
                e.preventDefault();
                var text = t.dataset.copy;
                (navigator.clipboard ? navigator.clipboard.writeText(text) : Promise.reject())
                    .then(function () { MT.toast('"' + text + '" disalin ke clipboard.', 'success', { title: 'Tersalin', duration: 2200 }); })
                    .catch(function () { MT.toast('Browser tidak mengizinkan salin otomatis.', 'warning'); });
            } else if ((t = e.target.closest('[data-tab]'))) {
                e.preventDefault();
                var tabs = t.closest('[role="tablist"]');
                tabs.querySelectorAll('[data-tab]').forEach(function (b) {
                    var on = b === t;
                    b.classList.toggle('active', on);
                    b.setAttribute('aria-selected', on ? 'true' : 'false');
                    var panel = document.querySelector(b.dataset.tab);
                    if (panel) panel.hidden = !on;
                });
                if (history.replaceState) history.replaceState(null, '', t.dataset.tab);
            }
        });

        // Buka tab sesuai hash URL (mis. profile.php#tab-password)
        if (location.hash) {
            var tabBtn = document.querySelector('[data-tab="' + location.hash + '"]');
            if (tabBtn) tabBtn.click();
        }

        document.addEventListener('keydown', function (e) {
            if (document.querySelector('.mt-dialog, .lightbox')) return;
            var typing = /^(INPUT|TEXTAREA|SELECT)$/.test(e.target.tagName) || e.target.isContentEditable;
            if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                palette && palette.classList.contains('open') ? closePalette() : openPalette();
            } else if (e.key === '/' && !typing) {
                e.preventDefault();
                openPalette();
            } else if (e.key === 'Escape') {
                closePalette();
            }
        });

        // Tampilan Mac pakai simbol ⌘ di shortcut
        if (/Mac|iPhone|iPad/.test(navigator.platform)) {
            document.querySelectorAll('.kbd-mod').forEach(function (el) { el.textContent = '⌘'; });
        }

        // Notifikasi dari server (flash session) yang dititipkan halaman
        (window.MT_FLASH || []).forEach(function (f) { MT.toast(f.message, f.type); });
    });
})();
