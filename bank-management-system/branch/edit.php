<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php $banks = $pdo->query("SELECT id, CONCAT(name,' (',bank_code,')') AS name FROM banks ORDER BY name")->fetchAll(); ?><?php
$id = (int)($_GET['id'] ?? 0);
$row = $pdo->prepare("SELECT * FROM branches WHERE id=?");
$row->execute([$id]);
$r = $row->fetch();
if (!$r) { echo "Not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $branch_code = $_POST['branch_code'] ?? null;
  $bank_id = $_POST['bank_id'] ?? null;
  $name = $_POST['name'] ?? null;
  $city = $_POST['city'] ?? null;
  $address = $_POST['address'] ?? null;
  $stmt = $pdo->prepare("UPDATE branches SET `branch_code`=?, `bank_id`=?, `name`=?, `city`=?, `address`=? WHERE id=?");
  $stmt->execute([$branch_code, $bank_id, $name, $city, $address, $id]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Edit Branch</h1>
<form method='post' class='form card'>
<label>Branch Code<input type='text' name='branch_code' value="<?php echo h($r['branch_code']); ?>"/></label>
<label>Bank<select name='bank_id'><?php foreach($banks as $opt): ?><option value="<?php echo $opt['id']; ?>" <?php if($r['bank_id']==$opt['id']) echo 'selected'; ?>><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Name<input type='text' name='name' value="<?php echo h($r['name']); ?>"/></label>
<label>City<input type='text' name='city' value="<?php echo h($r['city']); ?>"/></label>
<label class='full'>Address<input type='text' name='address' value="<?php echo h($r['address']); ?>"/></label>
<div class='full'><button class='button'>Update</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>