<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$row = $pdo->prepare("SELECT * FROM employees WHERE id=?");
$row->execute([$id]);
$r = $row->fetch();
if (!$r) { echo "Not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $emp_code = $_POST['emp_code'] ?? null;
  $name = $_POST['name'] ?? null;
  $email = $_POST['email'] ?? null;
  $contact = $_POST['contact'] ?? null;
  $age = $_POST['age'] ?? null;
  $address = $_POST['address'] ?? null;
  $branch_id = $_POST['branch_id'] ?? null;
  $is_admin = $_POST['is_admin'] ?? null;
  $password_hash = $_POST['password_hash'] ?? null;
  $stmt = $pdo->prepare("UPDATE employees SET `emp_code`=?, `name`=?, `email`=?, `contact`=?, `age`=?, `address`=?, `branch_id`=?, `is_admin`=?, `password_hash`=? WHERE id=?");
  $stmt->execute([$emp_code, $name, $email, $contact, $age, $address, $branch_id, $is_admin, $password_hash, $id]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Edit Employee</h1>
<form method='post' class='form card'>
<label>Emp Code<input type='text' name='emp_code' value="<?php echo h($r['emp_code']); ?>"/></label>
<label>Name<input type='text' name='name' value="<?php echo h($r['name']); ?>"/></label>
<label>Email<input type='text' name='email' value="<?php echo h($r['email']); ?>"/></label>
<label>Contact<input type='text' name='contact' value="<?php echo h($r['contact']); ?>"/></label>
<label>Age<input type='number' name='age' value="<?php echo h($r['age']); ?>"/></label>
<label class='full'>Address<input type='text' name='address' value="<?php echo h($r['address']); ?>"/></label>
<label>Branch ID<input type='number' name='branch_id' value="<?php echo h($r['branch_id']); ?>"/></label>
<label>Is Admin (0/1)<input type='number' name='is_admin' value="<?php echo h($r['is_admin']); ?>"/></label>
<label>Password Hash<input type='text' name='password_hash' value="<?php echo h($r['password_hash']); ?>"/></label>
<div class='full'><button class='button'>Update</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>