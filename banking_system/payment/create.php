<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO payment (Amount, PaymentDate, LoanID) VALUES (?, ?, ?)");
    $Amount = $_POST['Amount'] ?? null;
    $PaymentDate = $_POST['PaymentDate'] ?? null;
    $LoanID = $_POST['LoanID'] ?? null;
    $stmt->bind_param('dsi', $Amount, $PaymentDate, $LoanID);
    if ($stmt->execute()) {
        header("Location: /banking_system/payment/list.php");
        exit;
    } else {
        $errors[] = "Insert failed: " . $stmt->error;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<h3 class="mb-3 text-capitalize">Create payment</h3>
<?php if (!empty($errors)) { echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>'; } ?>
<form method="post" class="card p-3 shadow-sm">
  <div class="row g-3">

    <div class="col-md-6">
      <label class="form-label">Amount</label>
      <input type="number" name="Amount" class="form-control" step="0.01" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">PaymentDate</label>
      <input type="date" name="PaymentDate" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">LoanID (Loan)</label>
      <select name="LoanID" class="form-select" required>
        <option value="">-- select --</option>
        <?php
        $q = $conn->query("SELECT LoanID, LoanID FROM Loan ORDER BY LoanID");
        while ($o = $q->fetch_assoc()) {
            echo '<option value="'.htmlspecialchars($o['LoanID']).'">'.htmlspecialchars($o['LoanID']).' (ID: '.htmlspecialchars($o['LoanID']).')</option>';
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
