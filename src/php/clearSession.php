<?php
//清除SESSION后跳转到登陆页面
session_start();
unset($_SESSION['Username']);
header("Location: login.php");
?>