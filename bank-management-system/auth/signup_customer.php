<?php
require_once __DIR__."/../config/db.php";
require_once __DIR__."/../includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first = trim($_POST['first_name'] ?? '');
  $last = trim($_POST['last_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $contact = trim($_POST['contact'] ?? '');
  $address = trim($_POST['address'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm'] ?? '';

  if ($password !== $confirm) {
    flash('error', 'Passwords do not match.');
    header("Location: /bank-management-system/auth/signup_customer.php");
    exit;
  }
  if (!$first || !$last || !$email || !$password) {
    flash('error', 'Please fill all required fields.');
    header("Location: /bank-management-system/auth/signup_customer.php");
    exit;
  }

  $code = 'C' . str_pad((string)random_int(1, 999999), 6, '0', STR_PAD_LEFT);
  $hash = password_hash($password, PASSWORD_BCRYPT);

  try {
    $stmt = $pdo->prepare("INSERT INTO customers (cust_code, first_name, last_name, address, contact, email, password_hash) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$code, $first, $last, $address, $contact, $email, $hash]);
    flash('ok', 'Customer registered. You can now log in.');
    header("Location: /bank-management-system/auth/login.php");
    exit;
  } catch (PDOException $e) {
    flash('error', 'Registration failed: ' . $e->getMessage());
    header("Location: /bank-management-system/auth/signup_customer.php");
    exit;
  }
}
?>
<?php include __DIR__."/../includes/header.php"; ?>
<div class="content">
  <h2>Customer Sign Up</h2>
  <?php if ($m = flash('error')): ?><div class="notice"><?php echo h($m); ?></div><?php endif; ?>
  <form method="post" class="form card">
    <label>First Name<input name="first_name" required /></label>
    <label>Last Name<input name="last_name" required /></label>
    <label class="full">Email<input type="email" name="email" required /></label>
    <label>Contact<input name="contact" /></label>
    <label class="full">Address<textarea name="address"></textarea></label>
    <label>Password<input type="password" name="password" required /></label>
    <label>Confirm Password<input type="password" name="confirm" required /></label>
    <div class="full"><button class="button" type="submit">Create Account</button></div>
  </form>
</div>
<?php include __DIR__."/../includes/footer.php"; ?>
