<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$row = $pdo->prepare("SELECT * FROM customers WHERE id=?");
$row->execute([$id]);
$r = $row->fetch();
if (!$r) { echo "Not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cust_code = $_POST['cust_code'] ?? null;
  $first_name = $_POST['first_name'] ?? null;
  $last_name = $_POST['last_name'] ?? null;
  $email = $_POST['email'] ?? null;
  $contact = $_POST['contact'] ?? null;
  $address = $_POST['address'] ?? null;
  $password_hash = $_POST['password_hash'] ?? null;
  $stmt = $pdo->prepare("UPDATE customers SET `cust_code`=?, `first_name`=?, `last_name`=?, `email`=?, `contact`=?, `address`=?, `password_hash`=? WHERE id=?");
  $stmt->execute([$cust_code, $first_name, $last_name, $email, $contact, $address, $password_hash, $id]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Edit Customer</h1>
<form method='post' class='form card'>
<label>Code<input type='text' name='cust_code' value="<?php echo h($r['cust_code']); ?>"/></label>
<label>First Name<input type='text' name='first_name' value="<?php echo h($r['first_name']); ?>"/></label>
<label>Last Name<input type='text' name='last_name' value="<?php echo h($r['last_name']); ?>"/></label>
<label>Email<input type='text' name='email' value="<?php echo h($r['email']); ?>"/></label>
<label>Contact<input type='text' name='contact' value="<?php echo h($r['contact']); ?>"/></label>
<label class='full'>Address<input type='text' name='address' value="<?php echo h($r['address']); ?>"/></label>
<label>Password Hash<input type='text' name='password_hash' value="<?php echo h($r['password_hash']); ?>"/></label>
<div class='full'><button class='button'>Update</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>