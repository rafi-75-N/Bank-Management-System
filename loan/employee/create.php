<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO employee (Name, EmailID, Address, Contact, Age, ManagerID) VALUES (?, ?, ?, ?, ?, ?)");
    $Name = $_POST['Name'] ?? null;
    $EmailID = $_POST['EmailID'] ?? null;
    $Address = $_POST['Address'] ?? null;
    $Contact = $_POST['Contact'] ?? null;
    $Age = $_POST['Age'] ?? null;
    $ManagerID = $_POST['ManagerID'] ?? null;
    $stmt->bind_param('sissii', $Name, $EmailID, $Address, $Contact, $Age, $ManagerID);
    if ($stmt->execute()) {
        header("Location: /banking_system/employee/list.php");
        exit;
    } else {
        $errors[] = "Insert failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Create employee</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="Name" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">EmailID</label>
      <input type="text" name="EmailID" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="Address" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Contact</label>
      <input type="text" name="Contact" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Age</label>
      <input type="number" name="Age" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">ManagerID (Employee)</label>
      <select name="ManagerID" class="form-select" required>
        <option value="">-- select --</option>
        <?php
        $q = $conn->query("SELECT EmpID, Name FROM Employee ORDER BY Name");
        while ($o = $q->fetch_assoc()) {
            echo '<option value="'.htmlspecialchars($o['EmpID']).'">'.htmlspecialchars($o['Name']).' (ID: '.htmlspecialchars($o['EmpID']).')</option>';
        }
        ?>
      </select>
    </div>

  </div>
  <div class="mt-3">
    <button class="btn btn-success">Save</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
