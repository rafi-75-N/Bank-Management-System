<?php
// config/db.php
// Update $dbname if you change the database name.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
