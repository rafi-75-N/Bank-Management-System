<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
$rec = $conn->query("SELECT * FROM account WHERE AccountNo=".(int)$id)->fetch_assoc();
if (!$rec) { die('Record not found'); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("UPDATE account SET Balance=?, AccountType=?, MaximumLimit=?, YearlyFee=?, MinimumBalance=?, InterestRate=?, CustID=? WHERE AccountNo=?");
    $Balance = $_POST['Balance'] ?? null;
    $AccountType = $_POST['AccountType'] ?? null;
    $MaximumLimit = $_POST['MaximumLimit'] ?? null;
    $YearlyFee = $_POST['YearlyFee'] ?? null;
    $MinimumBalance = $_POST['MinimumBalance'] ?? null;
    $InterestRate = $_POST['InterestRate'] ?? null;
    $CustID = $_POST['CustID'] ?? null;
    $stmt->bind_param('dsddddii', $Balance, $AccountType, $MaximumLimit, $YearlyFee, $MinimumBalance, $InterestRate, $CustID, $id);
    if ($stmt->execute()) {
        header("Location: /banking_system/account/list.php");
        exit;
    } else {
        $errors[] = "Update failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Edit account</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Balance</label>
      <input type="number" name="Balance" class="form-control" value="<?php echo htmlspecialchars($rec['Balance']); ?>" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">AccountType</label>
      <input type="text" name="AccountType" class="form-control" value="<?php echo htmlspecialchars($rec['AccountType']); ?>" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">MaximumLimit</label>
      <input type="number" name="MaximumLimit" class="form-control" value="<?php echo htmlspecialchars($rec['MaximumLimit']); ?>" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">YearlyFee</label>
      <input type="number" name="YearlyFee" class="form-control" value="<?php echo htmlspecialchars($rec['YearlyFee']); ?>" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">MinimumBalance</label>
      <input type="number" name="MinimumBalance" class="form-control" value="<?php echo htmlspecialchars($rec['MinimumBalance']); ?>" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">InterestRate</label>
      <input type="number" name="InterestRate" class="form-control" value="<?php echo htmlspecialchars($rec['InterestRate']); ?>" step="0.01" required>
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
