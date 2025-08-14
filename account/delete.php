<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$stmt = $conn->prepare("DELETE FROM account WHERE AccountNo=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: /banking_system/account/list.php");
    exit;
} else {
    echo "Delete failed: " . $stmt->error;
}
?>
