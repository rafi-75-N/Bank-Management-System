<?php require_once __DIR__."/includes/auth.php"; require_login(); ?>
<?php include __DIR__."/includes/header.php"; ?>
<h1>Dashboard</h1>
<p>Welcome to the Bank Management System.</p>
<div class="card">
  <?php if (is_admin()): ?>
    <div class="toolbar">
      <h3>Quick Links</h3>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px">
      <a class="button" href="/bank-management-system/employee/list.php">Manage Employees</a>
      <a class="button" href="/bank-management-system/customer/list.php">Manage Customers</a>
      <a class="button" href="/bank-management-system/account/list.php">Manage Accounts</a>
      <a class="button" href="/bank-management-system/loan/list.php">Manage Loans</a>
      <a class="button" href="/bank-management-system/payment/list.php">Record Payments</a>
      <a class="button" href="/bank-management-system/bank/list.php">Banks & Branches</a>
    </div>
  <?php else: ?>
    <div class="notice">You are logged in as a customer. You can view your Accounts and Loans.</div>
    <div style="display:flex;gap:10px">
      <a class="button" href="/bank-management-system/account/list.php">My Accounts</a>
      <a class="button" href="/bank-management-system/loan/list.php">My Loans</a>
      <a class="button" href="/bank-management-system/payment/list.php">My Payments</a>
    </div>
  <?php endif; ?>
</div>
<?php include __DIR__."/includes/footer.php"; ?>
