<?php

include(ROOT_PATH . '/app/db/db.php');


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
        $image = time() . "_" . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/info/" . $image;

        $results = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($results) {

            // resizeImage($destination, $destination, 600, 800);
            $_POST['image'] = $image;
        }
    }

    $judul = $_POST['judul'];

    $slug = slugify($judul);
    $tag = $_POST['tag'];
    $deskripsi = $_POST['deskripsi'];
    $author = getUser()['nm_lengkap'];
    $img = $_POST['image'];

    if ($judul || $judul !== '') {
        $sql = "INSERT INTO informasi (judul,slug,deskripsi,tag,image,author) VALUES('$judul','$slug','$deskripsi','$tag','$img','$author')";
        $conn->query($sql);
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


        $image = time() . "_" . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/info/" . $image;
        $path = ROOT_PATH . '/assets/info/';

        $results = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($results) {
            if ($info_id['image'] !== null && file_exists($path . $info_id['image'])) {
                unlink($path . $info_id['image']);
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
    $img = $_POST['image'];

    if (!empty($judul) || $judul !== '') {

        $sql = "UPDATE informasi SET judul='$judul',slug='$slug', tag='$tag',deskripsi='$deskripsi',author='$author',image='$img' WHERE id=$id";
        $conn->query($sql);
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

    $path = ROOT_PATH . '/assets/info/';
    $info_id = selectOne('informasi', ['id' => $_GET['hapus']]);
    if ($info_id['image'] !== null && file_exists($path . $info_id['image'])) {
        unlink($path . $info_id['image']);
    }
    $count = deleteF('informasi', $_GET['hapus']);

    header('Location:' . BASE_URL . '/admin/informasi.php');
}