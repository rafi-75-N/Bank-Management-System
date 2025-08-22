<?php require_once __DIR__."/../includes/auth.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bank Management System</title>
  <link rel="stylesheet" href="/bank-management-system/assets/style.css" />
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">Bank Management<br/>System</div>
    <nav>
      <a href="/bank-management-system/dashboard.php">Dashboard</a>
      <?php if (is_logged_in() && is_admin()): ?>
        <a href="/bank-management-system/bank/list.php">Banks</a>
        <a href="/bank-management-system/branch/list.php">Branches</a>
        <a href="/bank-management-system/customer/list.php">Customers</a>
        <a href="/bank-management-system/account/list.php">Accounts</a>
        <a href="/bank-management-system/employee/list.php">Employees</a>
        <a href="/bank-management-system/loan/list.php">Loans</a>
        <a href="/bank-management-system/payment/list.php">Payments</a>
      <?php endif; ?>
      <?php if (is_logged_in() && !is_admin()): ?>
      <a href="/bank-management-system/account/list.php">My Accounts</a>
  <a href="/bank-management-system/loan/list.php">My Loans</a>
  <a href="/bank-management-system/loan/request.php">Request Loan</a>
  <a href="/bank-management-system/payment/create.php">Make Payment</a>
  <a href="/bank-management-system/payment/list.php">My Payments</a>
      <?php endif; ?>
    </nav>
    <div class="spacer"></div>
    <div class="userbar">
      <?php if (is_logged_in()): ?>
        <div class="user">
          <div class="hello">Hello, <?php echo h($_SESSION['user']['name']); ?></div>
          <a class="logout" href="/bank-management-system/auth/logout.php">Log out</a>
        </div>
      <?php else: ?>
        <a class="btn" href="/bank-management-system/auth/login.php">Log in</a>
      <?php endif; ?>
    </div>
  </aside>
  <main class="content">
