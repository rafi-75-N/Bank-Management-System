<?php require_once __DIR__.'/../includes/auth.php'; require_login(); ?>
<?php require_admin(); ?>
<?php require_once __DIR__.'/../config/db.php'; ?>
<?php $id = (int)($_GET['id'] ?? 0); $stmt = $pdo->prepare('DELETE FROM branches WHERE id=?'); $stmt->execute([$id]); header('Location: list.php'); exit; ?>