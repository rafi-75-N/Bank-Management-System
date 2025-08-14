<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 text-capitalize">employee list</h3>
  <a href="/banking_system/employee/create.php" class="btn btn-success">+ Create</a>
</div>
<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>EmpID</th>
          <th>Name</th>
          <th>EmailID</th>
          <th>Address</th>
          <th>Contact</th>
          <th>Age</th>
          <th>ManagerID</th>
          <th>Employee_Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$sql = "SELECT employee.EmpID, employee.Name, employee.EmailID, employee.Address, employee.Contact, employee.Age, employee.ManagerID, t1.Name AS Employee_Name FROM employee  LEFT JOIN Employee t1 ON t1.EmpID = employee.ManagerID  ORDER BY employee.EmpID DESC";
$res = $conn->query($sql);
if ($res) {
  while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["EmpID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Name"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["EmailID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Address"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Contact"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Age"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["ManagerID"] ?? "") . "</td>";
    echo "<td>" . htmlspecialchars($row["Employee_Name"] ?? "") . "</td>";
    echo "<td>
      <a class='btn btn-sm btn-primary' href='/banking_system/employee/edit.php?id=" . urlencode($row["EmpID"]) . "'>Edit</a>
      <a class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this record?');\" href='/banking_system/employee/delete.php?id=" . urlencode($row["EmpID"]) . "'>Delete</a>
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
