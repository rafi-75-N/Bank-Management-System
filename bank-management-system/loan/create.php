<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php $customers = $pdo->query("SELECT id, CONCAT(first_name,' ',last_name) AS name FROM customers ORDER BY first_name")->fetchAll(); $branches = $pdo->query("SELECT id, name FROM branches ORDER BY name")->fetchAll(); $employees = $pdo->query("SELECT id, name FROM employees WHERE is_admin=1 ORDER BY name")->fetchAll(); ?><?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $loan_code = $_POST['loan_code'] ?? null;
  $cust_id = $_POST['cust_id'] ?? null;
  $branch_id = $_POST['branch_id'] ?? null;
  $amount = $_POST['amount'] ?? null;
  $loan_date = $_POST['loan_date'] ?? null;
  $paid_amount = $_POST['paid_amount'] ?? null;
  $status = $_POST['status'] ?? null;
  $approved_by = $_POST['approved_by'] ?? null;
  $stmt = $pdo->prepare("INSERT INTO loans (`loan_code`, `cust_id`, `branch_id`, `amount`, `loan_date`, `paid_amount`, `status`, `approved_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([$loan_code, $cust_id, $branch_id, $amount, $loan_date, $paid_amount, $status, $approved_by]);
  header('Location: list.php'); exit; }
?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Create Loan</h1>
<form method='post' class='form card'>
<label>Loan Code<input type='text' name='loan_code'/></label>
<label>Customer<select name='cust_id'><?php foreach($customers as $opt): ?><option value="<?php echo $opt['id']; ?>"><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Branch<select name='branch_id'><?php foreach($branches as $opt): ?><option value="<?php echo $opt['id']; ?>"><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<label>Amount<input type='number' name='amount'/></label>
<label>Loan Date<input type='date' name='loan_date'/></label>
<label>Paid Amount<input type='number' name='paid_amount'/></label>
<label>Status (PENDING/APPROVED/REJECTED)<input type='text' name='status'/></label>
<label>Approved By (Employee)<select name='approved_by'><?php foreach($employees as $opt): ?><option value="<?php echo $opt['id']; ?>"><?php echo h($opt['name']); ?></option><?php endforeach; ?></select></label>
<div class='full'><button class='button'>Save</button></div></form>
<?php include __DIR__.'/../includes/footer.php'; ?>