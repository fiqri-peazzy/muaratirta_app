<?php

// Database configuration production
$host = 'localhost';
$user = 'u1369127_user28';
$pass = '&U#6*.Cp!AbWpJ_R';
$db_name = 'u1369127_muaratirta';

// Development configuration
// $host = 'localhost';
// $user = 'root';
// $pass = '';
// $db_name = 'muaratirta';


$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Database connection error : ' . $conn->connect_error);
}