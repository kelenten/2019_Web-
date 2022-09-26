<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/register.css" rel="stylesheet">
    <link href="../css/basis.css" rel="stylesheet">
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <title>register</title>
</head>
<body>

<div>
    <p class="logo"><img src="../../img/images/login/logo.jpg" width="100px"></p>
</div>
<div class="div-f">
    <p>Sign in for Fisher</p>
</div>
<form method='post' onsubmit="return checkAll()">
    <p id="p1">Username:</p>
    <input type="text" name='username' size="40">
    <p id="p2">E-mail:</p>
    <input type="email" name='email' size="40">
    <p id="p3">Password:</p>
    <input type="password" name='password' size="40">
    <p id="p4">Confirm Your Password:</p>
    <input type="password" name="Confirm_password" size="40">
    <p id="p5">
        <input type="submit" value="Sign in" name="login" style="font-size:16px">
    </p>
</form>
<script src="../js/register.js"></script>
<?php
session_start();
require_once("config.php");

function validLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sqlU = "SELECT * FROM traveluser WHERE Username=:user";

    $statementU = $pdo->prepare($sqlU);
    $statementU->bindValue(':user',$_POST['username']);
    $statementU->execute();

    $sqlE = 'select * from traveluser where Email=:email';
    $statementE = $pdo->prepare($sqlE);
    $statementE->bindValue(':email',$_POST['email']);
    $statementE->execute();
//当账号和密码都没有重复时返回true
    if($statementU->rowCount() === 0 && $statementE->rowCount() === 0) {

        return true;
    } else {
        if($statementU->rowCount() > 0){
            //提醒账号重复
            echo "<script>  ExistUser();</script>";
        }
        if($statementE->rowCount() > 0){
            //提醒邮箱重复
            echo "<script>  ExistEmail();</script>";
        }
        return false;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(validLogin()){
        //获取用户名，邮箱，密码
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        //加盐
        $hashPass = password_hash($pass,PASSWORD_DEFAULT);

        $DateJoined = date("Y-m-d H:i:s");
        $DateLastModified = date("Y-m-d H:i:s");
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql1 = 'select max(UID) from traveluser';
        $statement1 = $pdo->query($sql1);
        $UID = $statement1->fetch()['max(UID)'] + 1;
        //将新用户的信息传到数据库
        $sql2 = "insert into traveluser (UID,Email,UserName,Pass,State,DateJoined,DateLastModified) values (:UID,:email,:username,:pass,1,:datejoined,:DateLastModified)";
        $statement2 = $pdo->prepare($sql2);
        $statement2->bindValue(':UID',$UID);
        $statement2->bindValue(':email',$email);
        $statement2->bindValue(':username',$userName);
        $statement2->bindValue(':pass',$hashPass);
        $statement2->bindValue(':datejoined',$DateJoined);
        $statement2->bindValue(':DateLastModified',$DateLastModified);
        $statement2->execute();
        //注册成功后跳转登录页
        echo "<script>
alert('注册成功！');
window.location.href = 'clearSession.php';
    window.location.href='login.php';
</script>";
    }
}
?>
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
</body>
</html>
