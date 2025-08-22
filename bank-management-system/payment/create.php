<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>

<?php
$isAdmin = is_admin();

// Load data for forms
if ($isAdmin) {
  $loans = $pdo->query("SELECT id, loan_code FROM loans ORDER BY id DESC")->fetchAll();
} else {
  $cust_id = $_SESSION['user']['id'];
  $loans   = $pdo->prepare("SELECT id, loan_code FROM loans WHERE cust_id=? ORDER BY id DESC");
  $loans->execute([$cust_id]);
  $loans = $loans->fetchAll();

  $savings = $pdo->prepare("
    SELECT id, account_no, balance
    FROM accounts
    WHERE cust_id=? AND account_type='SAVINGS'
    ORDER BY id DESC
  ");
  $savings->execute([$cust_id]);
  $savings = $savings->fetchAll();
}

$done_msg = null; $error_msg = null;

// Handle submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($isAdmin) {
    // Admin: standard loan payment
    $payment_code = $_POST['payment_code'] ?: ('PMT'.str_pad((string)random_int(1,999999),6,'0',STR_PAD_LEFT));
    $loan_id      = (int)($_POST['loan_id'] ?? 0);
    $amount       = (float)($_POST['amount'] ?? 0);
    $payment_date = $_POST['payment_date'] ?: date('Y-m-d');
    $recorded_by  = $_SESSION['user']['id'] ?? null;

    if ($loan_id && $amount > 0) {
      $stmt = $pdo->prepare("INSERT INTO payments (payment_code, loan_id, amount, payment_date, recorded_by) VALUES (?,?,?,?,?)");
      $stmt->execute([$payment_code, $loan_id, $amount, $payment_date, $recorded_by]);
      $pdo->prepare("UPDATE loans SET paid_amount = paid_amount + ? WHERE id=?")->execute([$amount, $loan_id]);
      $done_msg = "Payment recorded and loan updated.";
    } else {
      $error_msg = "Please choose a loan and enter a positive amount.";
    }
  } else {
    // Customer: choose between Savings deposit or Loan repayment
    $mode  = $_POST['mode'] ?? 'SAVINGS'; // SAVINGS | LOAN
    $amount = (float)($_POST['amount'] ?? 0);
    $date   = $_POST['date'] ?: date('Y-m-d');

    if ($mode === 'SAVINGS') {
      $account_id = (int)($_POST['account_id'] ?? 0);
      // Verify ownership & type
      $chk = $pdo->prepare("SELECT id FROM accounts WHERE id=? AND cust_id=? AND account_type='SAVINGS'");
      $chk->execute([$account_id, $cust_id]);
      if ($chk->fetch() && $amount > 0) {
        $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id=?")->execute([$amount, $account_id]);
        $done_msg = "Deposited to your savings account.";
      } else {
        $error_msg = "Select your savings account and enter a valid amount.";
      }
    } else { // LOAN repayment
      $loan_id = (int)($_POST['loan_id'] ?? 0);
      if ($loan_id && $amount > 0) {
        $payment_code = 'PMT'.str_pad((string)random_int(1,999999),6,'0',STR_PAD_LEFT);
        $stmt = $pdo->prepare("INSERT INTO payments (payment_code, loan_id, amount, payment_date, recorded_by) VALUES (?,?,?,?,NULL)");
        $stmt->execute([$payment_code, $loan_id, $amount, $date]);
        $pdo->prepare("UPDATE loans SET paid_amount = paid_amount + ? WHERE id=?")->execute([$amount, $loan_id]);
        $done_msg = "Loan payment successful.";
      } else {
        $error_msg = "Choose a loan and enter a valid amount.";
      }
    }
  }
}
?>

<?php include __DIR__.'/../includes/header.php'; ?>
<h1><?php echo $isAdmin ? 'Record Payment' : 'Make Payment'; ?></h1>
<?php if ($done_msg): ?><div class="notice"><?php echo h($done_msg); ?></div><?php endif; ?>
<?php if ($error_msg): ?><div class="notice"><?php echo h($error_msg); ?></div><?php endif; ?>

<?php if ($isAdmin): ?>
<form method="post" class="form card">
  <label>Payment Code <input name="payment_code"/></label>
  <label>Loan
    <select name="loan_id">
      <?php foreach($loans as $l): ?>
        <option value="<?php echo $l['id']; ?>"><?php echo h($l['loan_code']); ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Amount <input type="number" step="0.01" name="amount"/></label>
  <label>Payment Date <input type="date" name="payment_date" value="<?php echo date('Y-m-d'); ?>"/></label>
  <div class="full"><button class="button">Save</button></div>
</form>

<?php else: ?>
<form method="post" class="form card">
  <label class="full">Payment For
    <select name="mode" id="mode">
      <option value="SAVINGS">Savings (Deposit)</option>
      <option value="LOAN">Loan (Repayment)</option>
    </select>
  </label>

  <div id="savingsFields">
    <label class="full">Choose Savings Account
      <select name="account_id">
        <?php foreach($savings as $s): ?>
          <option value="<?php echo $s['id']; ?>">
            #<?php echo h($s['account_no']); ?> (Balance: <?php echo h($s['balance']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>

  <div id="loanFields" style="display:none">
    <label class="full">Choose Loan
      <select name="loan_id">
        <?php foreach($loans as $l): ?>
          <option value="<?php echo $l['id']; ?>"><?php echo h($l['loan_code']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>

  <label>Amount <input type="number" step="0.01" name="amount" required /></label>
  <label>Date <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" /></label>
  <div class="full"><button class="button">Submit</button></div>
</form>

<script>
  const mode = document.getElementById('mode');
  const s = document.getElementById('savingsFields');
  const l = document.getElementById('loanFields');
  function toggle(){ if(mode.value==='LOAN'){ s.style.display='none'; l.style.display='block'; } else { s.style.display='block'; l.style.display='none'; } }
  mode.addEventListener('change', toggle); toggle();
</script>
<?php endif; ?>

<?php include __DIR__.'/../includes/footer.php'; ?>
