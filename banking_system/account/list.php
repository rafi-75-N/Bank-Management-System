<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 text-capitalize">account list</h3>
  <a href="/banking_system/account/create.php" class="btn btn-success">+ Create</a>
</div>
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>AccountNo</th>
          <th>Balance</th>
          <th>AccountType</th>
          <th>MaximumLimit</th>
          <th>YearlyFee</th>
          <th>MinimumBalance</th>
          <th>InterestRate</th>
          <th>CustID</th>
          <th>Customer_FName</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$sql = "SELECT account.AccountNo, account.Balance, account.AccountType, account.MaximumLimit, account.YearlyFee, account.MinimumBalance, account.InterestRate, account.CustID, t1.FName AS Customer_FName FROM account  LEFT JOIN Customer t1 ON t1.CustID = account.CustID  ORDER BY account.AccountNo DESC";
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["AccountNo"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Balance"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["AccountType"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["MaximumLimit"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["YearlyFee"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["MinimumBalance"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["InterestRate"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["CustID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Customer_FName"] ?? "") . "</td>";
    echo "<td>
      <a class='btn btn-sm btn-primary' href='/banking_system/account/edit.php?id=" . urlencode($row["AccountNo"]) . "'>Edit</a>
      <a class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this record?');\" href='/banking_system/account/delete.php?id=" . urlencode($row["AccountNo"]) . "'>Delete</a>
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
