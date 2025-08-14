<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$stmt = $conn->prepare("DELETE FROM employee WHERE EmpID=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: /banking_system/employee/list.php");
    exit;
} else {
    echo "Delete failed: " . $stmt->error;
}
?>
