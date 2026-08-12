<?php

// Pastikan session sudah start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database functions untuk validasi
if (!function_exists('selectOne')) {
    require_once(ROOT_PATH . '/app/db/db.php');
}

/**
 * Mencegah user yang belum login masuk ke halaman tertentu
 * Validasi ketat dengan pengecekan database
 */
function adminOnly($redirect = '/login')
{
    // 1. Cek dasar: Session ID harus ada
    if (empty($_SESSION['id'])) {
        header('Location: ' . BASE_URL . $redirect);
        exit(0);
    }

    // 2. Validasi Ketat: Cek apakah data user valid di database
    $user = selectOne('users', ['id' => $_SESSION['id']]);

    if (!$user) {
        // Jika session ada tapi user tidak ditemukan (misal dihapus),
        // bersihkan session dan paksa logout
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . $redirect);
        exit(0);
    }

    // 3. Regenerate session ID untuk keamanan (mencegah session fixation)
    if (!isset($_SESSION['last_regeneration'])) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 300) { // Setiap 5 menit
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

/**
 * Mencegah user yang login masuk kembali ke halaman Login/Register
 */
function guestsOnly($redirect = '/admin/')
{
    if (isset($_SESSION['id'])) {
        // Validasi bahwa user masih ada di database
        $user = selectOne('users', ['id' => $_SESSION['id']]);

        if ($user) {
            // User valid, redirect ke admin
            header('Location: ' . BASE_URL . $redirect);
            exit(0);
        } else {
            // User tidak valid, bersihkan session
            session_unset();
            session_destroy();
        }
    }
}

/**
 * Helper untuk cek level user dengan cepat
 */
function checkLevel($levels = [])
{
    if (!isset($_SESSION['level'])) return false;
    return in_array($_SESSION['level'], $levels);
}