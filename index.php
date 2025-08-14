<?php include __DIR__ . '/includes/header.php'; ?>
<div class="row g-4">
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/bank/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Banks</h5>
          <p class="card-text">Manage banks.</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/branch/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Branches</h5>
          <p class="card-text">Manage branches and link to banks.</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/customer/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Customers</h5>
          <p class="card-text">Create and update customers.</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/account/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Accounts</h5>
          <p class="card-text">Accounts belong to customers.</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/employee/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Employees</h5>
          <p class="card-text">CRUD for employees (with managers).</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/loan/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Loans</h5>
          <p class="card-text">Loans linked to customers & branches.</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-6 col-lg-4">
    <a class="text-decoration-none" href="/banking_system/payment/list.php">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Payments</h5>
          <p class="card-text">Payments linked to loans.</p>
        </div>
      </div>
    </a>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
