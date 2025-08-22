<?php
require_once __DIR__."/../config/db.php";
require_once __DIR__."/../includes/auth.php";

// Allow signup even if no admin logged in (first admin). If logged-in but not admin, block.
if (is_logged_in() && !is_admin()) { http_response_code(403); echo "Only admins can create employees."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $contact = trim($_POST['contact'] ?? '');
  $address = trim($_POST['address'] ?? '');
  $age = (int)($_POST['age'] ?? 0);
  $branch_id = $_POST['branch_id'] ?: null;
  $is_admin = isset($_POST['is_admin']) ? 1 : 0;
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm'] ?? '';

  if ($password !== $confirm) {
    flash('error', 'Passwords do not match.');
    header("Location: /bank-management-system/auth/signup_employee.php");
    exit;
  }

  $code = 'EMP' . str_pad((string)random_int(1, 9999), 4, '0', STR_PAD_LEFT);
  $hash = password_hash($password, PASSWORD_BCRYPT);

  try {
    $stmt = $pdo->prepare("INSERT INTO employees (emp_code, name, email, address, contact, age, branch_id, is_admin, password_hash) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$code, $name, $email, $address, $contact, $age, $branch_id, $is_admin, $hash]);
    flash('ok', 'Employee created. They can now log in.');
    header("Location: /bank-management-system/auth/login.php");
    exit;
  } catch (PDOException $e) {
    flash('error', 'Creation failed: ' . $e->getMessage());
    header("Location: /bank-management-system/auth/signup_employee.php");
    exit;
  }
}
$branches = $pdo->query("SELECT id, name FROM branches ORDER BY name")->fetchAll();
?>
<?php include __DIR__."/../includes/header.php"; ?>
<div class="content">
  <h2>Create Employee</h2>
  <?php if ($m = flash('error')): ?><div class="notice"><?php echo h($m); ?></div><?php endif; ?>
  <form method="post" class="form card">
    <label class="full">Name<input name="name" required /></label>
    <label class="full">Email<input type="email" name="email" required /></label>
    <label>Contact<input name="contact" /></label>
    <label>Age<input type="number" name="age" min="18" /></label>
    <label class="full">Address<textarea name="address"></textarea></label>
    <label class="full">Branch
      <select name="branch_id">
        <option value="">-- None --</option>
        <?php foreach($branches as $b): ?>
          <option value="<?php echo $b['id']; ?>"><?php echo h($b['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label><input type="checkbox" name="is_admin" checked /> Is Admin</label>
    <label>Password<input type="password" name="password" required /></label>
    <label>Confirm Password<input type="password" name="confirm" required /></label>
    <div class="full"><button class="button" type="submit">Create Employee</button></div>
  </form>
</div>
<?php include __DIR__."/../includes/footer.php"; ?>
