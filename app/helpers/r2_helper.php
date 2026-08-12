<?php

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

if (!function_exists('getR2Client')) {
    function getR2Client()
    {
        static $client = null;
        if ($client === null) {
            $client = new S3Client([
                'version' => 'latest',
                'region' => 'auto',
                'endpoint' => $_ENV['R2_ENDPOINT'],
                'credentials' => [
                    'key' => $_ENV['R2_ACCESS_KEY'],
                    'secret' => $_ENV['R2_SECRET_KEY'],
                ],
                'http' => [
                    'connect_timeout' => 5,
                    'timeout' => 15,
                ],
            ]);
        }
        return $client;
    }
}

/**
 * Upload file lokal (hasil $_FILES[...]['tmp_name']) ke bucket R2.
 * Return nama file (key relatif dalam folder) jika sukses, atau false jika gagal.
 */
if (!function_exists('uploadToR2')) {
    function uploadToR2($tmpFilePath, $folderName, $fileName)
    {
        try {
            $key = trim($folderName, '/') . '/' . $fileName;
            getR2Client()->putObject([
                'Bucket' => $_ENV['R2_BUCKET'],
                'Key' => $key,
                'SourceFile' => $tmpFilePath,
                'ContentType' => mime_content_type($tmpFilePath) ?: 'application/octet-stream',
            ]);
            return $fileName;
        } catch (AwsException $e) {
            error_log('uploadToR2 error: ' . $e->getMessage());
            return false;
        }
    }
}

/**
 * Hapus file dari bucket R2.
 */
if (!function_exists('deleteFromR2')) {
    function deleteFromR2($folderName, $fileName)
    {
        if (empty($fileName)) {
            return false;
        }
        try {
            $key = trim($folderName, '/') . '/' . $fileName;
            getR2Client()->deleteObject([
                'Bucket' => $_ENV['R2_BUCKET'],
                'Key' => $key,
            ]);
            return true;
        } catch (AwsException $e) {
            error_log('deleteFromR2 error: ' . $e->getMessage());
            return false;
        }
    }
}

/**
 * Hasilkan URL publik (CDN) untuk sebuah file di R2.
 */
if (!function_exists('getR2Url')) {
    function getR2Url($folderName, $fileName)
    {
        if (empty($fileName)) {
            return '';
        }
        return rtrim($_ENV['R2_PUBLIC_URL'], '/') . '/' . trim($folderName, '/') . '/' . $fileName;
    }
}

/**
 * Ambil isi file dari R2 lewat API (bukan HTTP publik) dan simpan ke file temp lokal.
 * Dipakai saat butuh file lokal yang pasti ada & cepat diakses (mis. render PDF),
 * supaya tidak bergantung pada koneksi jaringan ke CDN publik yang bisa lambat/putus.
 * Return path file temp jika sukses, atau false jika gagal. Pemanggil wajib unlink() sendiri.
 */
if (!function_exists('downloadR2ToTemp')) {
    function downloadR2ToTemp($folderName, $fileName)
    {
        if (empty($fileName)) {
            return false;
        }
        try {
            $key = trim($folderName, '/') . '/' . $fileName;
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $tempPath = tempnam(sys_get_temp_dir(), 'r2dl_') . ($extension ? '.' . $extension : '');
            getR2Client()->getObject([
                'Bucket' => $_ENV['R2_BUCKET'],
                'Key' => $key,
                'SaveAs' => $tempPath,
            ]);
            return $tempPath;
        } catch (AwsException $e) {
            error_log('downloadR2ToTemp error: ' . $e->getMessage());
            return false;
        }
    }
}

/**
 * Resolusi URL gambar selama masa transisi migrasi ke R2:
 * kalau file masih ada di folder lokal lama, pakai itu; kalau tidak, anggap sudah di R2.
 */
if (!function_exists('resolveImageUrl')) {
    function resolveImageUrl($fileName, $r2Folder, array $legacyLocalDirs = [])
    {
        if (empty($fileName)) {
            return '';
        }
        foreach ($legacyLocalDirs as $dir) {
            $dir = trim($dir, '/');
            if (file_exists(ROOT_PATH . '/' . $dir . '/' . $fileName)) {
                return BASE_URL . '/' . $dir . '/' . $fileName;
            }
        }
        return getR2Url($r2Folder, $fileName);
    }
}
