<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 text-capitalize">bank list</h3>
  <a href="/banking_system/bank/create.php" class="btn btn-success">+ Create</a>
</div>
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>BankCode</th>
          <th>Name</th>
          <th>City</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$sql = "SELECT bank.BankCode, bank.Name, bank.City, bank.Address FROM bank  ORDER BY bank.BankCode DESC";
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["BankCode"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Name"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["City"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Address"] ?? "") . "</td>";
    echo "<td>
      <a class='btn btn-sm btn-primary' href='/banking_system/bank/edit.php?id=" . urlencode($row["BankCode"]) . "'>Edit</a>
      <a class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this record?');\" href='/banking_system/bank/delete.php?id=" . urlencode($row["BankCode"]) . "'>Delete</a>
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
