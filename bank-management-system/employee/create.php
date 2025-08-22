<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php
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
  $stmt = $pdo->prepare("INSERT INTO employees (`emp_code`, `name`, `email`, `contact`, `age`, `address`, `branch_id`, `is_admin`, `password_hash`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([$emp_code, $name, $email, $contact, $age, $address, $branch_id, $is_admin, $password_hash]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Create Employee</h1>
<form method='post' class='form card'>
<label>Emp Code<input type='text' name='emp_code'/></label>
<label>Name<input type='text' name='name'/></label>
<label>Email<input type='text' name='email'/></label>
<label>Contact<input type='text' name='contact'/></label>
<label>Age<input type='number' name='age'/></label>
<label class='full'>Address<input type='text' name='address'/></label>
<label>Branch ID<input type='number' name='branch_id'/></label>
<label>Is Admin (0/1)<input type='number' name='is_admin'/></label>
<label>Password Hash<input type='text' name='password_hash'/></label>
<div class='full'><button class='button'>Save</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>