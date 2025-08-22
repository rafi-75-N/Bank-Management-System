<?php
// includes/auth.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function current_user() {
    return $_SESSION['user'] ?? null;
}
function is_logged_in() {
    return isset($_SESSION['user']);
}
function is_admin() {
    return isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'ADMIN';
}
function require_login() {
    if (!is_logged_in()) {
        header("Location: /bank-management-system/auth/login.php");
        exit;
    }
}
function require_admin() {
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        echo "<h2 style='font-family:sans-serif'>Forbidden</h2><p>You must be an admin employee.</p>";
        exit;
    }
}
function flash($key, $msg=null) {
    if ($msg !== null) { $_SESSION['flash'][$key] = $msg; return; }
    if (!empty($_SESSION['flash'][$key])) { $m = $_SESSION['flash'][$key]; unset($_SESSION['flash'][$key]); return $m; }
    return null;
}
function h($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
?>
