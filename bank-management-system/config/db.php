<?php
// config/db.php - PDO connection
$DB_HOST = "127.0.0.1";
$DB_NAME = "bank_management";
$DB_USER = "root";
$DB_PASS = ""; // XAMPP default is empty. Change if you set a password.

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
