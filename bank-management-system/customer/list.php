<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Customer List</h1>
<div class="toolbar"><div></div><a class="button" href="create.php">+ Add</a></div>
<?php $rows = $pdo->query("SELECT * FROM customers ORDER BY id DESC")->fetchAll(); ?>
<table class="table"><tr><th>Code</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Contact</th><th>Actions</th></tr>
<?php foreach($rows as $r): ?>
<tr><td><?php echo h($r['cust_code']); ?></td><td><?php echo h($r['first_name']); ?></td><td><?php echo h($r['last_name']); ?></td><td><?php echo h($r['email']); ?></td><td><?php echo h($r['contact']); ?></td><td><a class="button" href="edit.php?id=<?php echo $r['id']; ?>">Edit</a> <a class="button danger" href="delete.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?>
</table>
<?php include __DIR__.'/../includes/footer.php'; ?>