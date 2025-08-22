<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php $customers = $pdo->query("SELECT id, CONCAT(first_name,' ',last_name) AS name FROM customers ORDER BY first_name")->fetchAll(); $employees = $pdo->query("SELECT id, name FROM employees ORDER BY name")->fetchAll(); ?><?php
$id = (int)($_GET['id'] ?? 0);
$row = $pdo->prepare("SELECT * FROM accounts WHERE id=?");
$row->execute([$id]);
$r = $row->fetch();
if (!$r) { echo "Not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $account_no = $_POST['account_no'] ?? null;
  $cust_id = $_POST['cust_id'] ?? null;
  $employee_id = $_POST['employee_id'] ?? null;
  $account_type = $_POST['account_type'] ?? null;
  $balance = $_POST['balance'] ?? null;
  $maximum_limit = $_POST['maximum_limit'] ?? null;
  $yearly_fee = $_POST['yearly_fee'] ?? null;
  $minimum_balance = $_POST['minimum_balance'] ?? null;
  $interest_rate = $_POST['interest_rate'] ?? null;
  $stmt = $pdo->prepare("UPDATE accounts SET `account_no`=?, `cust_id`=?, `employee_id`=?, `account_type`=?, `balance`=?, `maximum_limit`=?, `yearly_fee`=?, `minimum_balance`=?, `interest_rate`=? WHERE id=?");
  $stmt->execute([$account_no, $cust_id, $employee_id, $account_type, $balance, $maximum_limit, $yearly_fee, $minimum_balance, $interest_rate, $id]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Edit Account</h1>
<form method='post' class='form card'>
<label>Account No<input type='number' name='account_no' value="<?php echo h($r['account_no']); ?>"/></label>
<label>Customer<select name='cust_id'><?php foreach($customers as $opt): ?><option value="<?php echo $opt['id']; ?>" <?php if($r['cust_id']==$opt['id']) echo 'selected'; ?>><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Employee<select name='employee_id'><?php foreach($employees as $opt): ?><option value="<?php echo $opt['id']; ?>" <?php if($r['employee_id']==$opt['id']) echo 'selected'; ?>><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Account Type (SAVINGS/CURRENT)<input type='text' name='account_type' value="<?php echo h($r['account_type']); ?>"/></label>
<label>Balance<input type='number' name='balance' value="<?php echo h($r['balance']); ?>"/></label>
<label>Maximum Limit (CURRENT)<input type='number' name='maximum_limit' value="<?php echo h($r['maximum_limit']); ?>"/></label>
<label>Yearly Fee (CURRENT)<input type='number' name='yearly_fee' value="<?php echo h($r['yearly_fee']); ?>"/></label>
<label>Minimum Balance (SAVINGS)<input type='number' name='minimum_balance' value="<?php echo h($r['minimum_balance']); ?>"/></label>
<label>Interest Rate % (SAVINGS)<input type='number' name='interest_rate' value="<?php echo h($r['interest_rate']); ?>"/></label>
<div class='full'><button class='button'>Update</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>