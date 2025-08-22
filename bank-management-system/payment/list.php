<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php include __DIR__.'/../includes/header.php'; ?>

<?php
$isAdmin = is_admin();
if ($isAdmin) {
  $stmt = $pdo->query("
    SELECT p.*, l.loan_code
    FROM payments p
    LEFT JOIN loans l ON l.id=p.loan_id
    ORDER BY p.id DESC
  ");
  $rows = $stmt->fetchAll();
} else {
  $stmt = $pdo->prepare("
    SELECT p.*, l.loan_code
    FROM payments p
    INNER JOIN loans l ON l.id=p.loan_id
    WHERE l.cust_id=?
    ORDER BY p.id DESC
  ");
  $stmt->execute([$_SESSION['user']['id']]);
  $rows = $stmt->fetchAll();
}
?>
<h1><?php echo $isAdmin ? 'Payments' : 'My Payments'; ?></h1>
<?php if ($isAdmin): ?>
  <div class="toolbar"><div></div><a class="button" href="create.php">+ Add</a></div>
<?php endif; ?>

<table class="table">
  <tr>
    <th>Payment Code</th><th>Loan</th><th>Amount</th><th>Payment Date</th>
    <?php if ($isAdmin): ?><th>Actions</th><?php endif; ?>
  </tr>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?php echo h($r['payment_code']); ?></td>
      <td><?php echo h($r['loan_code']); ?></td>
      <td><?php echo h($r['amount']); ?></td>
      <td><?php echo h($r['payment_date']); ?></td>
      <?php if ($isAdmin): ?>
        <td>
          <a class="button" href="edit.php?id=<?php echo $r['id']; ?>">Edit</a>
          <a class="button danger" onclick="return confirm('Delete?')" href="delete.php?id=<?php echo $r['id']; ?>">Delete</a>
        </td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
</table>

<?php include __DIR__.'/../includes/footer.php'; ?>
