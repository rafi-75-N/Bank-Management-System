<?php
require_once __DIR__."/../config/db.php";
require_once __DIR__."/../includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'CUSTOMER'; // CUSTOMER or ADMIN (employee)

    if ($role === 'ADMIN') {
        $stmt = $pdo->prepare("SELECT * FROM employees WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        if ($row && password_verify($password, $row['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'role' => $row['is_admin'] ? 'ADMIN' : 'STAFF'
            ];
            header("Location: /bank-management-system/dashboard.php");
            exit;
        }
    } else {
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        if ($row && password_verify($password, $row['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $row['id'],
                'name' => $row['first_name'].' '.$row['last_name'],
                'email' => $row['email'],
                'role' => 'CUSTOMER'
            ];
            header("Location: /bank-management-system/dashboard.php");
            exit;
        }
    }

    flash('error', 'Invalid credentials.');
    header("Location: /bank-management-system/auth/login.php");
    exit;
}
?>
<?php include __DIR__."/../includes/header.php"; ?>
<div class="center">
  <?php if ($msg = flash('error')): ?>
    <div class="notice"><?php echo h($msg); ?></div>
  <?php endif; ?>
  <div class="card login-card">
    <h2>Log in</h2>
    <form method="post">
      <div class="form">
        <label class="full">Email
          <input required type="email" name="email" />
        </label>
        <label class="full">Password
          <input required type="password" name="password" />
        </label>
        <label class="full">I am logging in as
          <select name="role">
            <option value="CUSTOMER">Customer</option>
            <option value="ADMIN">Employee (Admin)</option>
          </select>
        </label>
        <div class="full">
          <button class="button" type="submit">Log in</button>
        </div>
      </div>
    </form>
    <p><small class="help">Sample admin: <b>admin@bank.com</b> / <b>Admin@123</b> | Sample customer: <b>michael@example.com</b> / <b>Cust@123</b></small></p>
    <div style="display:flex;gap:10px">
      <a class="button secondary" href="/bank-management-system/auth/signup_customer.php">Create Customer Account</a>
      <a class="button secondary" href="/bank-management-system/auth/signup_employee.php">Create Employee</a>
    </div>
  </div>
</div>
<?php include __DIR__."/../includes/footer.php"; ?>
