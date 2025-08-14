<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$stmt = $conn->prepare("DELETE FROM bank WHERE BankCode=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: /banking_system/bank/list.php");
    exit;
} else {
    echo "Delete failed: " . $stmt->error;
}
?>
