<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$row = $pdo->prepare("SELECT * FROM banks WHERE id=?");
$row->execute([$id]);
$r = $row->fetch();
if (!$r) { echo "Not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bank_code = $_POST['bank_code'] ?? null;
  $name = $_POST['name'] ?? null;
  $city = $_POST['city'] ?? null;
  $address = $_POST['address'] ?? null;
  $stmt = $pdo->prepare("UPDATE banks SET `bank_code`=?, `name`=?, `city`=?, `address`=? WHERE id=?");
  $stmt->execute([$bank_code, $name, $city, $address, $id]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Edit Bank</h1>
<form method='post' class='form card'>
<label>Code<input type='text' name='bank_code' value="<?php echo h($r['bank_code']); ?>"/></label>
<label>Name<input type='text' name='name' value="<?php echo h($r['name']); ?>"/></label>
<label>City<input type='text' name='city' value="<?php echo h($r['city']); ?>"/></label>
<label class='full'>Address<input type='text' name='address' value="<?php echo h($r['address']); ?>"/></label>
<div class='full'><button class='button'>Update</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>