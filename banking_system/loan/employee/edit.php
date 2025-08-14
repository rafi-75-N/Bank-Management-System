<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$rec = $conn->query("SELECT * FROM employee WHERE EmpID=".(int)$id)->fetch_assoc();
if (!$rec) { die('Record not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("UPDATE employee SET Name=?, EmailID=?, Address=?, Contact=?, Age=?, ManagerID=? WHERE EmpID=?");
    $Name = $_POST['Name'] ?? null;
    $EmailID = $_POST['EmailID'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $Contact = $_POST['Contact'] ?? null;
    $Age = $_POST['Age'] ?? null;
    $ManagerID = $_POST['ManagerID'] ?? null;
    $stmt->bind_param('sissiii', $Name, $EmailID, $Address, $Contact, $Age, $ManagerID, $id);
    if ($stmt->execute()) {
        header("Location: /banking_system/employee/list.php");
        exit;
    } else {
        $errors[] = "Update failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Edit employee</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="Name" class="form-control" value="<?php echo htmlspecialchars($rec['Name']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">EmailID</label>
      <input type="text" name="EmailID" class="form-control" value="<?php echo htmlspecialchars($rec['EmailID']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="Address" class="form-control" value="<?php echo htmlspecialchars($rec['Address']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Contact</label>
      <input type="text" name="Contact" class="form-control" value="<?php echo htmlspecialchars($rec['Contact']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Age</label>
      <input type="number" name="Age" class="form-control" value="<?php echo htmlspecialchars($rec['Age']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">ManagerID (Employee)</label>
      <select name="ManagerID" class="form-select" required>
        <option value="">-- select --</option>
        <?php
        $q = $conn->query("SELECT EmpID, Name FROM Employee ORDER BY Name");
        while ($o = $q->fetch_assoc()) {
            $sel = ($rec['ManagerID'] == $o['EmpID']) ? 'selected' : '';
            echo '<option '+$sel+' value="'.htmlspecialchars($o['EmpID']).'">'.htmlspecialchars($o['Name']).' (ID: '.htmlspecialchars($o['EmpID']).')</option>';
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
