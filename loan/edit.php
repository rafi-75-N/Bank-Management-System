<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$rec = $conn->query("SELECT * FROM loan WHERE LoanID=".(int)$id)->fetch_assoc();
if (!$rec) { die('Record not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("UPDATE loan SET Amount=?, Date=?, PaidAmount=?, BranchID=?, CustID=? WHERE LoanID=?");
    $Amount = $_POST['Amount'] ?? null;
    $Date = $_POST['Date'] ?? null;
    $PaidAmount = $_POST['PaidAmount'] ?? null;
    $BranchID = $_POST['BranchID'] ?? null;
    $CustID = $_POST['CustID'] ?? null;
    $stmt->bind_param('dsdiii', $Amount, $Date, $PaidAmount, $BranchID, $CustID, $id);
    if ($stmt->execute()) {
        header("Location: /banking_system/loan/list.php");
        exit;
    } else {
        $errors[] = "Update failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Edit loan</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Amount</label>
      <input type="number" name="Amount" class="form-control" value="<?php echo htmlspecialchars($rec['Amount']); ?>" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Date</label>
      <input type="date" name="Date" class="form-control" value="<?php echo htmlspecialchars($rec['Date']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">PaidAmount</label>
      <input type="number" name="PaidAmount" class="form-control" value="<?php echo htmlspecialchars($rec['PaidAmount']); ?>" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">BranchID (Branch)</label>
      <select name="BranchID" class="form-select" required>
        <option value="">-- select --</option>
        <?php
        $q = $conn->query("SELECT BranchID, Name FROM Branch ORDER BY Name");
        while ($o = $q->fetch_assoc()) {
            $sel = ($rec['BranchID'] == $o['BranchID']) ? 'selected' : '';
            echo '<option '+$sel+' value="'.htmlspecialchars($o['BranchID']).'">'.htmlspecialchars($o['Name']).' (ID: '.htmlspecialchars($o['BranchID']).')</option>';
        }
        ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">CustID (Customer)</label>
      <select name="CustID" class="form-select" required>
        <option value="">-- select --</option>
        <?php
        $q = $conn->query("SELECT CustID, FName FROM Customer ORDER BY FName");
        while ($o = $q->fetch_assoc()) {
            $sel = ($rec['CustID'] == $o['CustID']) ? 'selected' : '';
            echo '<option '+$sel+' value="'.htmlspecialchars($o['CustID']).'">'.htmlspecialchars($o['FName']).' (ID: '.htmlspecialchars($o['CustID']).')</option>';
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
