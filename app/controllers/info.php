<?php

include(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/r2_helper.php');


$id = '';
$judul = '';
$deskripsi = '';
$author = '';
$img = '';



$sql = 'SELECT * FROM informasi';
$res = mysqli_query($conn, $sql);



$informasi = selectAll('informasi');


$row = mysqli_fetch_assoc($res);
$count_row = mysqli_num_rows($res);

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
function resizeImage($source, $destination, $width, $height)
{
    list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($source);

    if ($sourceType == IMAGETYPE_JPEG) {
        $sourceImage = imagecreatefromjpeg($source);
    } elseif ($sourceType == IMAGETYPE_PNG) {
        $sourceImage = imagecreatefrompng($source);
    } else {
        // Handle other image types if needed
        return;
    }

    $resizedImage = imagecreatetruecolor($width, $height);

    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

    if ($sourceType == IMAGETYPE_JPEG) {
        imagejpeg($resizedImage, $destination, 90); // 90 is the quality, change as needed
    } elseif ($sourceType == IMAGETYPE_PNG) {
        imagepng($resizedImage, $destination, 9); // 9 is the compression level, change as needed
    }

    imagedestroy($sourceImage);
    imagedestroy($resizedImage);
}



if (isset($_POST['add-info'])) {

    if (!empty($_FILES['image']['name'])) {
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = time() . "_" . uniqid() . "." . $extension;

        $results = uploadToR2($_FILES['image']['tmp_name'], 'informasi', $image);

        if ($results) {
            $_POST['image'] = $image;
        }
    }

    $judul = $_POST['judul'];

    $slug = slugify($judul);
    $tag = $_POST['tag'];
    $deskripsi = $_POST['deskripsi'];
    $author = getUser()['nm_lengkap'];
    $img = $_POST['image'] ?? '';

    if ($judul || $judul !== '') {
        create('informasi', [
            'judul' => $judul,
            'slug' => $slug,
            'deskripsi' => $deskripsi,
            'tag' => $tag,
            'image' => $img,
            'author' => $author,
        ]);
        $_SESSION['message'] = 'Berhasil Tambah data';
        $_SESSION['type'] = 'success';
        header('Location:' . BASE_URL . '/admin/informasi.php');
        exit();
    } else {
        $_SESSION['message'] = 'Gagal Tambah data';
        $_SESSION['type'] = 'error';
        header('Location:' . BASE_URL . '/admin/informasi.php');
    }
}

if (isset($_POST['update-info'])) {
    $id = $_GET['id'];

    if (!empty($_FILES['image']['name'])) {

        $info_id = selectOne('informasi', ['id' => $id]);

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image = time() . "_" . uniqid() . "." . $extension;

        $results = uploadToR2($_FILES['image']['tmp_name'], 'informasi', $image);

        if ($results) {
            if (!empty($info_id['image'])) {
                $legacyPath = ROOT_PATH . '/assets/info/' . $info_id['image'];
                if (file_exists($legacyPath)) {
                    unlink($legacyPath);
                }
                deleteFromR2('informasi', $info_id['image']);
            }

            $_POST['image'] = $image;
        }
    } else {

        if (selectOne('informasi', ['id' => $id])['image'] !== null) {
            $_POST['image'] = selectOne('informasi', ['id' => $id])['image'];
        }
    }
    $judul = $_POST['judul'];
    $slug = slugify($judul);
    $tag = $_POST['tag'];
    $deskripsi = $_POST['deskripsi'];
    $author = getUser()['nm_lengkap'];
    $img = $_POST['image'] ?? '';

    if (!empty($judul) || $judul !== '') {

        update('informasi', $id, [
            'judul' => $judul,
            'slug' => $slug,
            'tag' => $tag,
            'deskripsi' => $deskripsi,
            'author' => $author,
            'image' => $img,
        ]);
        $_SESSION['message'] = 'Berhasil Update data';
        $_SESSION['type'] = 'success';
        header('Location:' . BASE_URL . '/admin/informasi.php');
        exit();
    } else {
        $_SESSION['message'] = 'Gagal Update data';
        $_SESSION['type'] = 'error';
        header('Location:' . BASE_URL . '/admin/informasi.php');
    }
}

if (isset($_GET['hapus'])) {

    $info_id = selectOne('informasi', ['id' => $_GET['hapus']]);
    if (!empty($info_id['image'])) {
        $legacyPath = ROOT_PATH . '/assets/info/' . $info_id['image'];
        if (file_exists($legacyPath)) {
            unlink($legacyPath);
        }
        deleteFromR2('informasi', $info_id['image']);
    }
    $count = deleteF('informasi', $_GET['hapus']);

    header('Location:' . BASE_URL . '/admin/informasi.php');
}