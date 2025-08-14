<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$rec = $conn->query("SELECT * FROM customer WHERE CustID=".(int)$id)->fetch_assoc();
if (!$rec) { die('Record not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("UPDATE customer SET FName=?, LName=?, Address=?, Contact=? WHERE CustID=?");
    $FName = $_POST['FName'] ?? null;
    $LName = $_POST['LName'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $Contact = $_POST['Contact'] ?? null;
    $stmt->bind_param('ssssi', $FName, $LName, $Address, $Contact, $id);
    if ($stmt->execute()) {
        header("Location: /banking_system/customer/list.php");
        exit;
    } else {
        $errors[] = "Update failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Edit customer</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">FName</label>
      <input type="text" name="FName" class="form-control" value="<?php echo htmlspecialchars($rec['FName']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">LName</label>
      <input type="text" name="LName" class="form-control" value="<?php echo htmlspecialchars($rec['LName']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="Address" class="form-control" value="<?php echo htmlspecialchars($rec['Address']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Contact</label>
      <input type="text" name="Contact" class="form-control" value="<?php echo htmlspecialchars($rec['Contact']); ?>" required>
    </div>

  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Update</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
