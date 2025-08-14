<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 text-capitalize">customer list</h3>
  <a href="/banking_system/customer/create.php" class="btn btn-success">+ Create</a>
</div>
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>CustID</th>
          <th>FName</th>
          <th>LName</th>
          <th>Address</th>
          <th>Contact</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$sql = "SELECT customer.CustID, customer.FName, customer.LName, customer.Address, customer.Contact FROM customer  ORDER BY customer.CustID DESC";
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["CustID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["FName"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["LName"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Address"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Contact"] ?? "") . "</td>";
    echo "<td>
      <a class='btn btn-sm btn-primary' href='/banking_system/customer/edit.php?id=" . urlencode($row["CustID"]) . "'>Edit</a>
      <a class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this record?');\" href='/banking_system/customer/delete.php?id=" . urlencode($row["CustID"]) . "'>Delete</a>
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
