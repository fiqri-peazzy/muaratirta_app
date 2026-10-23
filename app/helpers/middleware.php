<?php

// Pastikan session sudah start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database functions untuk validasi
if (!function_exists('selectOne')) {
    require_once(ROOT_PATH . '/app/db/db.php');
}

// File ini di-include dari banyak tempat (halaman admin, controller, handler AJAX),
// kadang lebih dari sekali dalam satu request -> jangan deklarasi ulang fungsi.
if (!function_exists('adminOnly')) {

    /**
     * Ambil user yang sedang login dan masih valid di database, atau null.
     */
    function currentAdmin()
    {
        static $user = false;
        if ($user !== false) {
            return $user;
        }
        $user = empty($_SESSION['id']) ? null : (selectOne('users', ['id' => $_SESSION['id']]) ?: null);
        return $user;
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
        if (!currentAdmin()) {
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
     * Versi adminOnly() untuk endpoint AJAX/JSON: balas 401/403 berupa JSON alih-alih redirect,
     * supaya frontend bisa menampilkan pesan yang jelas. $levels kosong = semua level boleh.
     */
    function adminAjaxOnly($levels = [])
    {
        $user = currentAdmin();
        if (!$user) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['status' => 0, 'success' => 0, 'msg' => 'Sesi login berakhir. Silakan login ulang.']);
            exit(0);
        }
        if ($levels && !in_array((int) $user['level'], $levels, true)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['status' => 0, 'success' => 0, 'msg' => 'Anda tidak punya akses untuk aksi ini.']);
            exit(0);
        }
        return $user;
    }

    /**
     * Batasi halaman admin ke level tertentu (1 = Administrator, 2 = CS, 3 = Arsip).
     * Panggil sesudah adminOnly().
     */
    function adminLevel($levels)
    {
        $user = currentAdmin();
        if (!$user || !in_array((int) $user['level'], $levels, true)) {
            $_SESSION['message'] = 'Anda tidak punya akses ke halaman tersebut.';
            $_SESSION['type'] = 'error';
            header('Location: ' . BASE_URL . '/admin/');
            exit(0);
        }
    }
}

if (!function_exists('guestsOnly')) {
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
}
