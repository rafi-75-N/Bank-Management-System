<?php
require_once __DIR__."/../includes/auth.php";
session_destroy();
header("Location: /bank-management-system/auth/login.php");
exit;
