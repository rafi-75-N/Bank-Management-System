<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 text-capitalize">payment list</h3>
  <a href="/banking_system/payment/create.php" class="btn btn-success">+ Create</a>
</div>
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>PaymentID</th>
          <th>Amount</th>
          <th>PaymentDate</th>
          <th>LoanID</th>
          <th>Loan_LoanID</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$sql = "SELECT payment.PaymentID, payment.Amount, payment.PaymentDate, payment.LoanID, t1.LoanID AS Loan_LoanID FROM payment  LEFT JOIN Loan t1 ON t1.LoanID = payment.LoanID  ORDER BY payment.PaymentID DESC";
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["PaymentID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Amount"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["PaymentDate"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["LoanID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Loan_LoanID"] ?? "") . "</td>";
    echo "<td>
      <a class='btn btn-sm btn-primary' href='/banking_system/payment/edit.php?id=" . urlencode($row["PaymentID"]) . "'>Edit</a>
      <a class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this record?');\" href='/banking_system/payment/delete.php?id=" . urlencode($row["PaymentID"]) . "'>Delete</a>
    </td>";
    echo "</tr>";
  }
}
?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
