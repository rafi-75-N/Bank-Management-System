<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php $loans = $pdo->query("SELECT id, loan_code AS name FROM loans ORDER BY id DESC")->fetchAll(); $employees = $pdo->query("SELECT id, name FROM employees ORDER BY name")->fetchAll(); ?><?php
$id = (int)($_GET['id'] ?? 0);
$row = $pdo->prepare("SELECT * FROM payments WHERE id=?");
$row->execute([$id]);
$r = $row->fetch();
if (!$r) { echo "Not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $payment_code = $_POST['payment_code'] ?? null;
  $loan_id = $_POST['loan_id'] ?? null;
  $amount = $_POST['amount'] ?? null;
  $payment_date = $_POST['payment_date'] ?? null;
  $recorded_by = $_POST['recorded_by'] ?? null;
  $stmt = $pdo->prepare("UPDATE payments SET `payment_code`=?, `loan_id`=?, `amount`=?, `payment_date`=?, `recorded_by`=? WHERE id=?");
  $stmt->execute([$payment_code, $loan_id, $amount, $payment_date, $recorded_by, $id]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Edit Payment</h1>
<form method='post' class='form card'>
<label>Payment Code<input type='text' name='payment_code' value="<?php echo h($r['payment_code']); ?>"/></label>
<label>Loan<select name='loan_id'><?php foreach($loans as $opt): ?><option value="<?php echo $opt['id']; ?>" <?php if($r['loan_id']==$opt['id']) echo 'selected'; ?>><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Amount<input type='number' name='amount' value="<?php echo h($r['amount']); ?>"/></label>
<label>Payment Date<input type='date' name='payment_date' value="<?php echo h($r['payment_date']); ?>"/></label>
<label>Recorded By<select name='recorded_by'><?php foreach($employees as $opt): ?><option value="<?php echo $opt['id']; ?>" <?php if($r['recorded_by']==$opt['id']) echo 'selected'; ?>><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<div class='full'><button class='button'>Update</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>