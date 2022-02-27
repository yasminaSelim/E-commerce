<?php
session_start();
unset($_SESSION['user']);
setcookie("user", "", time() - 3600,'/');
header('location:login.php');die();
?>