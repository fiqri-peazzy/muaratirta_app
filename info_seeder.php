<?php

include("path.php");

include(ROOT_PATH . '/app/controllers/users.php');

function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}
$informasi =  selectAll('informasi', []);
// $post_slug = [];
foreach ($informasi as $info) {
    $judul = $info['judul'];
    $slug = slugify($judul);
    $update = update('informasi', $info['id'], ['slug' => $slug]);
}

echo "if you only see this text, its done";