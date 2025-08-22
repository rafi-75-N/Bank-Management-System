<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php $banks = $pdo->query("SELECT id, CONCAT(name,' (',bank_code,')') AS name FROM banks ORDER BY name")->fetchAll(); ?><?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $branch_code = $_POST['branch_code'] ?? null;
  $bank_id = $_POST['bank_id'] ?? null;
  $name = $_POST['name'] ?? null;
  $city = $_POST['city'] ?? null;
  $address = $_POST['address'] ?? null;
  $stmt = $pdo->prepare("INSERT INTO branches (`branch_code`, `bank_id`, `name`, `city`, `address`) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$branch_code, $bank_id, $name, $city, $address]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Create Branch</h1>
<form method='post' class='form card'>
<label>Branch Code<input type='text' name='branch_code'/></label>
<label>Bank<select name='bank_id'><?php foreach($banks as $opt): ?><option value="<?php echo $opt['id']; ?>"><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Name<input type='text' name='name'/></label>
<label>City<input type='text' name='city'/></label>
<label class='full'>Address<input type='text' name='address'/></label>
<div class='full'><button class='button'>Save</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>