<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO bank (Name, City, Address) VALUES (?, ?, ?)");
    $Name = $_POST['Name'] ?? null;
    $City = $_POST['City'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $stmt->bind_param('sss', $Name, $City, $Address);
    if ($stmt->execute()) {
        header("Location: /banking_system/bank/list.php");
        exit;
    } else {
        $errors[] = "Insert failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Create bank</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="Name" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">City</label>
      <input type="text" name="City" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="Address" class="form-control" required>
    </div>

  </div>
  <div class="mt-3">
    <button class="btn btn-success">Save</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
