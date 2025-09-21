<?php

$DB_HOST = 'localhost';
$DB_NAME = 'tsa2';
$DB_USER = 'root';
$DB_PASS = '';


$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

try{
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Debug only (remove in production)
    die("Database connection failed: " . $e->getMessage());
}