<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO customer (FName, LName, Address, Contact) VALUES (?, ?, ?, ?)");
    $FName = $_POST['FName'] ?? null;
    $LName = $_POST['LName'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $Contact = $_POST['Contact'] ?? null;
    $stmt->bind_param('ssss', $FName, $LName, $Address, $Contact);
    if ($stmt->execute()) {
        header("Location: /banking_system/customer/list.php");
        exit;
    } else {
        $errors[] = "Insert failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Create customer</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">FName</label>
      <input type="text" name="FName" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">LName</label>
      <input type="text" name="LName" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="Address" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Contact</label>
      <input type="text" name="Contact" class="form-control" required>
    </div>

  </div>
  <div class="mt-3">
    <button class="btn btn-success">Save</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
