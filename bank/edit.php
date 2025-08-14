<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$rec = $conn->query("SELECT * FROM bank WHERE BankCode=".(int)$id)->fetch_assoc();
if (!$rec) { die('Record not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("UPDATE bank SET Name=?, City=?, Address=? WHERE BankCode=?");
    $Name = $_POST['Name'] ?? null;
    $City = $_POST['City'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $stmt->bind_param('sssi', $Name, $City, $Address, $id);
    if ($stmt->execute()) {
        header("Location: /banking_system/bank/list.php");
        exit;
    } else {
        $errors[] = "Update failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Edit bank</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="Name" class="form-control" value="<?php echo htmlspecialchars($rec['Name']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">City</label>
      <input type="text" name="City" class="form-control" value="<?php echo htmlspecialchars($rec['City']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="Address" class="form-control" value="<?php echo htmlspecialchars($rec['Address']); ?>" required>
    </div>

  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Update</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
