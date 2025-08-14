<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$rec = $conn->query("SELECT * FROM branch WHERE BranchID=".(int)$id)->fetch_assoc();
if (!$rec) { die('Record not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("UPDATE branch SET Name=?, City=?, Address=?, BankCode=? WHERE BranchID=?");
    $Name = $_POST['Name'] ?? null;
    $City = $_POST['City'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $BankCode = $_POST['BankCode'] ?? null;
    $stmt->bind_param('sssii', $Name, $City, $Address, $BankCode, $id);
    if ($stmt->execute()) {
        header("Location: /banking_system/branch/list.php");
        exit;
    } else {
        $errors[] = "Update failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Edit branch</h3>
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

    <div class="col-md-6">
      <label class="form-label">BankCode (Bank)</label>
      <select name="BankCode" class="form-select" required>
        <option value="">-- select --</option>
        <?php
        $q = $conn->query("SELECT BankCode, Name FROM Bank ORDER BY Name");
        while ($o = $q->fetch_assoc()) {
            $sel = ($rec['BankCode'] == $o['BankCode']) ? 'selected' : '';
            echo '<option '+$sel+' value="'.htmlspecialchars($o['BankCode']).'">'.htmlspecialchars($o['Name']).' (ID: '.htmlspecialchars($o['BankCode']).')</option>';
        }
        ?>
      </select>
    </div>

  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Update</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
