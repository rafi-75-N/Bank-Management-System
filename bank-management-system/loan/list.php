<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php include __DIR__.'/../includes/header.php'; ?>

<?php
$isAdmin = is_admin();
if ($isAdmin) {
  $stmt = $pdo->query("
    SELECT l.*, CONCAT(c.first_name,' ',c.last_name) AS customer_name
    FROM loans l
    LEFT JOIN customers c ON c.id=l.cust_id
    ORDER BY l.id DESC
  ");
  $rows = $stmt->fetchAll();
} else {
  $stmt = $pdo->prepare("
    SELECT l.*, CONCAT(c.first_name,' ',c.last_name) AS customer_name
    FROM loans l
    LEFT JOIN customers c ON c.id=l.cust_id
    WHERE l.cust_id=?
    ORDER BY l.id DESC
  ");
  $stmt->execute([$_SESSION['user']['id']]);
  $rows = $stmt->fetchAll();
}
?>
<h1><?php echo $isAdmin ? 'Loans' : 'My Loans'; ?></h1>
<?php if ($isAdmin): ?>
  <div class="toolbar"><div></div><a class="button" href="create.php">+ Add</a></div>
<?php endif; ?>

<table class="table">
  <tr>
    <th>Loan Code</th>
    <?php if ($isAdmin): ?><th>Customer</th><?php endif; ?>
    <th>Amount</th><th>Status</th>
    <?php if ($isAdmin): ?><th>Actions</th><?php endif; ?>
  </tr>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?php echo h($r['loan_code']); ?></td>
      <?php if ($isAdmin): ?><td><?php echo h($r['customer_name']); ?></td><?php endif; ?>
      <td><?php echo h($r['amount']); ?></td>
      <td><?php echo h($r['status']); ?></td>
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
