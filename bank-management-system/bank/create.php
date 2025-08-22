<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bank_code = $_POST['bank_code'] ?? null;
  $name = $_POST['name'] ?? null;
  $city = $_POST['city'] ?? null;
  $address = $_POST['address'] ?? null;
  $stmt = $pdo->prepare("INSERT INTO banks (`bank_code`, `name`, `city`, `address`) VALUES (?, ?, ?, ?)");
  $stmt->execute([$bank_code, $name, $city, $address]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Create Bank</h1>
<form method='post' class='form card'>
<label>Code<input type='text' name='bank_code'/></label>
<label>Name<input type='text' name='name'/></label>
<label>City<input type='text' name='city'/></label>
<label class='full'>Address<input type='text' name='address'/></label>
<div class='full'><button class='button'>Save</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>