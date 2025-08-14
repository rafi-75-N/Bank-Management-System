<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banking System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/banking_system/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/banking_system/index.php">Banking System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/banking_system/bank/list.php">Banks</a></li>
        <li class="nav-item"><a class="nav-link" href="/banking_system/branch/list.php">Branches</a></li>
        <li class="nav-item"><a class="nav-link" href="/banking_system/customer/list.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="/banking_system/account/list.php">Accounts</a></li>
        <li class="nav-item"><a class="nav-link" href="/banking_system/employee/list.php">Employees</a></li>
        <li class="nav-item"><a class="nav-link" href="/banking_system/loan/list.php">Loans</a></li>
        <li class="nav-item"><a class="nav-link" href="/banking_system/payment/list.php">Payments</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
