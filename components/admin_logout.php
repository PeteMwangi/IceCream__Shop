<?php
include 'connect.php';

setcookie('seller_id', '', time() - 3600, '/');
header('Location: ../admin panel/login.php');
exit;
?>
