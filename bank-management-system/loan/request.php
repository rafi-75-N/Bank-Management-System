<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php include __DIR__.'/../includes/header.php'; ?>

<?php
// Customers request; default status = PENDING
$branches = $pdo->query("SELECT id, name FROM branches ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !is_admin()) {
  $cust_id   = $_SESSION['user']['id'];
  $branch_id = $_POST['branch_id'] ?? null;
  $amount    = (float)($_POST['amount'] ?? 0);
  $loan_date = $_POST['loan_date'] ?: date('Y-m-d');

  if (!$branch_id || $amount <= 0) {
    echo "<div class='notice'>Please choose a branch and enter a valid amount.</div>";
  } else {
    $code = 'L' . str_pad((string)random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    $stmt = $pdo->prepare("
      INSERT INTO loans (loan_code, cust_id, branch_id, amount, loan_date, status)
      VALUES (?,?,?,?,?,'PENDING')
    ");
    $stmt->execute([$code, $cust_id, $branch_id, $amount, $loan_date]);
    echo "<div class='notice'>Loan request submitted. Status is <b>PENDING</b> until an admin reviews it.</div>";
  }
}
?>

<h1>Request a Loan</h1>
<form method="post" class="form card">
  <label class="full">Branch
    <select name="branch_id" required>
      <option value="">-- Choose a branch --</option>
      <?php foreach($branches as $b): ?>
        <option value="<?php echo $b['id']; ?>"><?php echo h($b['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Amount <input type="number" step="0.01" name="amount" required /></label>
  <label>Loan Date <input type="date" name="loan_date" value="<?php echo date('Y-m-d'); ?>" /></label>
  <div class="full"><button class="button">Submit Request</button></div>
</form>

<?php include __DIR__.'/../includes/footer.php'; ?>
