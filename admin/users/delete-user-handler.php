<?php
include "../../path.php";
require_once(ROOT_PATH . '/app/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['id'];
    $delete = deleteF('users', $id);
    if ($delete) {
        echo 'Succes Deleted';
    }
}