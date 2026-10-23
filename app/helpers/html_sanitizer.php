<?php
// Pembersih HTML isi artikel (informasi/berita). Isi ini dicetak mentah di halaman publik
// (detail-berita.php, promo-detail.php, info-gangguan-detail.php), jadi hanya tag & atribut
// format dasar yang dibiarkan. Selebihnya dibuang supaya tidak bisa dipakai untuk XSS.

if (!function_exists('sanitizeArticleHtml')) {
    function sanitizeArticleHtml($html)
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        // Teks polos (tanpa tag): ubah baris kosong jadi paragraf, enter tunggal jadi <br>
        if (strpos($html, '<') === false) {
            $paras = preg_split('/\R{2,}/', $html);
            return implode('', array_map(function ($p) {
                return '<p>' . nl2br(htmlspecialchars(trim($p), ENT_QUOTES, 'UTF-8'), false) . '</p>';
            }, array_filter($paras, 'strlen')));
        }

        $allowed = [
            'p' => [], 'br' => [], 'h2' => [], 'h3' => [], 'h4' => [],
            'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'u' => [], 's' => [],
            'sub' => [], 'sup' => [], 'code' => [], 'pre' => [], 'hr' => [],
            'ul' => [], 'ol' => [], 'li' => [], 'blockquote' => [],
            'a' => ['href', 'target'], 'span' => [], 'div' => [],
        ];
        // Tag yang dibuang beserta seluruh isinya
        $drop = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'link', 'meta', 'svg', 'math', 'template', 'noscript'];

        $doc = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="__root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        $root = $doc->getElementById('__root');
        if (!$root) {
            return htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8');
        }

        $clean = function (DOMNode $node) use (&$clean, $allowed, $drop, $doc) {
            for ($i = $node->childNodes->length - 1; $i >= 0; $i--) {
                $child = $node->childNodes->item($i);
                if ($child instanceof DOMComment) {
                    $node->removeChild($child);
                    continue;
                }
                if (!($child instanceof DOMElement)) {
                    continue;
                }
                $tag = strtolower($child->nodeName);

                if (in_array($tag, $drop, true)) {
                    $node->removeChild($child);
                    continue;
                }

                $clean($child);

                if (!isset($allowed[$tag])) {
                    // Tag tak dikenal: buka bungkusnya, pertahankan isinya
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                // Rata teks satu-satunya gaya yang boleh (dari tombol align editor)
                $align = '';
                if (preg_match('/text-align\s*:\s*(left|right|center|justify)/i', $child->getAttribute('style'), $m)) {
                    $align = strtolower($m[1]);
                }

                foreach (iterator_to_array($child->attributes) as $attr) {
                    if (!in_array(strtolower($attr->name), $allowed[$tag], true)) {
                        $child->removeAttribute($attr->name);
                    }
                }
                if ($align !== '' && in_array($tag, ['p', 'h2', 'h3', 'h4', 'li', 'blockquote', 'div'], true)) {
                    $child->setAttribute('style', 'text-align: ' . $align);
                }

                if ($tag === 'a') {
                    $href = trim($child->getAttribute('href'));
                    if ($href === '' || !preg_match('#^(https?://|mailto:|tel:|/|\#)#i', $href)) {
                        $child->removeAttribute('href');
                    }
                    if ($child->getAttribute('target') !== '') {
                        $child->setAttribute('target', '_blank');
                        $child->setAttribute('rel', 'noopener noreferrer');
                    }
                }
            }
        };
        $clean($root);

        $out = '';
        foreach ($root->childNodes as $c) {
            $out .= $doc->saveHTML($c);
        }
        // Buang paragraf kosong di akhir (sisa editor)
        return trim(preg_replace('#(<p>(<br>|\s|&nbsp;)*</p>)+$#i', '', $out));
    }
}
