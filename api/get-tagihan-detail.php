<?php

require('../path.php');
require_once(ROOT_PATH . '/app/db/db.php');
require_once(ROOT_PATH . '/app/helpers/api_tagihan.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    if (empty($_POST['id_pel'])) {
        $errors[] = 'Masukan No Sambung';
    } elseif (!is_numeric($_POST['id_pel'])) {
        $errors[] = 'No Sambung Harus Berupa Angka';
    }

    if (count($errors) == 0) {

        $id_pel = $_POST['id_pel'];
        $data = getTagihanDetail($id_pel);

        // print_r($data);

        // Retribusi dikenakan per periode, mulai RETRIBUSI_START_PERIODE dan seterusnya.
        // TAGIHAN dari API sudah termasuk retribusi, jadi dipecah: AIR = TAGIHAN - RETRIB.
        // Pelanggan tanpa retribusi / periode sebelumnya = 0; null = gagal diambil dari API
        if (($data['status'] ?? null) === 'true' && !empty($data['pelanggan'])) {
            $retribusi = getRetribusiPelanggan($id_pel);
            $startPeriode = (int) ($_ENV['RETRIBUSI_START_PERIODE'] ?? 202609);

            foreach ($data['pelanggan'] as &$item) {
                $tagihan = (int) ($item['TAGIHAN'] ?? 0);

                if ($retribusi === null) {
                    $item['RETRIB'] = null;
                } elseif ((int) ($item['PERIODE'] ?? 0) >= $startPeriode && $tagihan >= $retribusi) {
                    $item['RETRIB'] = $retribusi;
                } else {
                    $item['RETRIB'] = 0;
                }

                $item['AIR'] = $tagihan - (int) $item['RETRIB'];
            }
            unset($item);
        }

        if (count($data) > 0) {
            echo json_encode($data);
        } else {
            echo json_encode(['status' => false]);
        }
    } else {
        echo json_encode(['status' => false, 'error' => $errors]);
    }
}