<?php
require_once __DIR__."/includes/auth.php";
if (is_logged_in()) {
  header("Location: /bank-management-system/dashboard.php");
} else {
  header("Location: /bank-management-system/auth/login.php");
}
exit;
