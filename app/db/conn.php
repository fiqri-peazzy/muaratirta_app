<?php

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? '';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Database connection error : ' . $conn->connect_error);
}