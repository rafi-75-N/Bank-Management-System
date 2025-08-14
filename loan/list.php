<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 text-capitalize">loan list</h3>
  <a href="/banking_system/loan/create.php" class="btn btn-success">+ Create</a>
</div>
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>LoanID</th>
          <th>Amount</th>
          <th>Date</th>
          <th>PaidAmount</th>
          <th>BranchID</th>
          <th>CustID</th>
          <th>Branch_Name</th>
          <th>Customer_FName</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$sql = "SELECT loan.LoanID, loan.Amount, loan.Date, loan.PaidAmount, loan.BranchID, loan.CustID, t1.Name AS Branch_Name, t2.FName AS Customer_FName FROM loan  LEFT JOIN Branch t1 ON t1.BranchID = loan.BranchID  LEFT JOIN Customer t2 ON t2.CustID = loan.CustID  ORDER BY loan.LoanID DESC";
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["LoanID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Amount"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Date"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["PaidAmount"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["BranchID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["CustID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Branch_Name"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Customer_FName"] ?? "") . "</td>";
    echo "<td>
      <a class='btn btn-sm btn-primary' href='/banking_system/loan/edit.php?id=" . urlencode($row["LoanID"]) . "'>Edit</a>
      <a class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this record?');\" href='/banking_system/loan/delete.php?id=" . urlencode($row["LoanID"]) . "'>Delete</a>
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
