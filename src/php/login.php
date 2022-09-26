<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/login.css" rel="stylesheet">
    <link href="../css/basis.css" rel="stylesheet">
    <title>login</title>
</head>
<body>
<div>
    <p class="logo"><img src="../../img/images/login/logo.jpg" width="100px"></p>
</div>
<div class="div-f">
    <p>Sign in for Fisher</p>
</div>
<form method='post' onsubmit="return checkAll()">
    <p id="p1">
        Username/E-mail<br>
    </p>
    <input type="text" name='username' size="40">
    <p id="p2">
        Password<br>
    </p>
    <input type="password" name='password' size="40">
    <p id="p3">
        Re-enter
    </p>
    <input type="password" name="password2" size="40">
    <p id="p4">
        <input type="submit" value="Sign in" name="login" style="font-size:16px">
    </p>
</form>
<?php
session_start();

require_once("config.php");

function validLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sqlU = "SELECT * FROM traveluser WHERE Username=:user";

    $statementU = $pdo->prepare($sqlU);
    $statementU->bindValue(':user',$_POST['username']);
    $statementU->execute();
    $rowU = $statementU->fetch();
//对照用户名以及密码（可能加盐）
    if($statementU->rowCount()>0 && (password_verify($_POST['password'],$rowU['Pass']) || $_POST['password'] == $rowU['Pass'])){
        return true;
    }

    $sqlE = 'select * from traveluser where Email=:email';
    $statementE = $pdo->prepare($sqlE);
    $statementE->bindValue(':email',$_POST['username']);
    $statementE->execute();
    $rowE = $statementE->fetch();
//对照邮箱以及密码
    if($statementE->rowCount()>0 && (password_verify($_POST['password'],$rowE['Pass']) || $_POST['password'] == $rowE['Pass'])){
        return true;
    }
        return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(validLogin()){
        //成功登录则设置SESSION
        $_SESSION['Username']=$_POST['username'];
    } else {
        echo "<script> alert('账号或密码错误！')</script>";
    }

}
//若有SESSION则提示后跳转主页
if(isset($_SESSION['Username'])){
    echo "<script> alert('登录成功！') </script>";
    echo "<script type='text/javascript'>
    window.location.href='../../index.php'
</script>";
}
?>
<div class="div-s">
    New to Fisher?<a class="blue" href="register.php">creat a new Account</a>
</div>
<footer>
    <div class="footer-top">
        <div class="bottom-left">
            <a><p>使用条款</p></a>
            <a><p>隐私保护</p></a>
            <a><p>Cookie</p></a>
        </div>
        <div class="bottom-medium">
            <a><p>关于</p></a>
            <a><p>联系我们</p></a>
        </div>
        <div class="bottom-right">
            <img src="../../img/images/homepage/2Dcode.jpg" width="100px">
        </div>
    </div>
    <div class="footer-bottom">
        <p>粤网文[2017]6138-1456号 粤府新函[2001]87号 联系方式：13510107912</p>
    </div>
    <div class="footer-bottom">
        <p>Copyright © 2020-2021 Kelenten. All Rights Reserved. 备案号：粤BILIBILI备19307110295号</p>
    </div>
</footer>
</body>
</html>
<script src="../js/login.js"></script>