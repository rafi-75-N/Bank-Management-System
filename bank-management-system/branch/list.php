<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Branch List</h1>
<div class="toolbar"><div></div><a class="button" href="create.php">+ Add</a></div>
<?php $rows = $pdo->query("SELECT * FROM branches ORDER BY id DESC")->fetchAll(); ?>
<table class="table"><tr><th>Branch Code</th><th>Bank</th><th>Name</th><th>City</th><th>Actions</th></tr>
<?php foreach($rows as $r): ?>
<tr><td><?php echo h($r['branch_code']); ?></td><td><?php echo h($r['bank_id']); ?></td><td><?php echo h($r['name']); ?></td><td><?php echo h($r['city']); ?></td><td><a class="button" href="edit.php?id=<?php echo $r['id']; ?>">Edit</a> <a class="button danger" href="delete.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?>
</table>
<?php include __DIR__.'/../includes/footer.php'; ?>