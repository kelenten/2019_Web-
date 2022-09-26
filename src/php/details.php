<?php

require_once('config.php');

session_start();
//根据图片id输出收藏数，国家城市类别等信息
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql1 = 'select * from travelimage where ImageID=:id';
    $id =  $_GET['id'];
    $statement1 = $pdo->prepare($sql1);
    $statement1->bindValue(':id', $id);
    $statement1->execute();

    $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
    $UID = $row1['UID'];
    $country = $row1['CountryCodeISO'];
    $city = $row1['CityCode'];


    $sql2 = 'select * from geocountries where ISO=:iso';
    $statement2 = $pdo->prepare($sql2);
    $statement2->bindValue(':iso', $country);
    $statement2->execute();

    $row2 = $statement2->fetch(PDO::FETCH_ASSOC);

    $sql3 = 'select * from geocities where GeoNameID=:code';
    $statement3 = $pdo->prepare($sql3);
    $statement3->bindValue(':code', $city);
    $statement3->execute();


    $row3 = $statement3->fetch(PDO::FETCH_ASSOC);

    $sql4 = 'select * from travelimagefavor where ImageID=:id';
    $statement4 = $pdo->prepare($sql4);
    $statement4->bindValue(':id', $id);
    $statement4->execute();

    $likeNum = $statement4->rowCount();

    $sql5 = 'select * from traveluser where UID=:UID';
    $statement5 = $pdo->prepare($sql5);
    $statement5->bindValue(':UID', $UID);
    $statement5->execute();
    $row5 = $statement5->fetch();
    $uploader = $row5['UserName'];

    $pdo = null;
}
catch (PDOException $e) {
    die( $e->getMessage() );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/details.css" rel="stylesheet">
    <link href="../css/basis.css" rel="stylesheet">
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <title>details</title>
</head>
<body>
<nav id="nav">
    <a><img src="../../img/images/homepage/logo.jpg" id="img1"></a>
    <a class="left" href="../../index.php"><p class="normal">Home</p></a>
    <a class="left" href="Browser.php"><p class="normal">Browse</p></a>
    <a class="left" href="Search.php"><p class="normal">Search</p></a>
    <?php
    if(!isset($_SESSION['Username'])){
        echo '<div class="right_logout">
        <a href="login.php"><span class="login">Login</span></a>
    </div>';
        echo '<div id="username" hidden></div>';
    } else {
        echo '<div class="right_login">
        <span class="drop-ul">My account</span>
        <img src="../../img/images/homepage/drop-down.jpg" width="20px">
        <div class="drop-li">
            <a href="upload.php"><p class="li"><img src="../../img/images/homepage/upload.png" width="25px" align="absmiddle">&emsp;upload</p></a>
            <a href="my_photo.php"><p class="li"><img src="../../img/images/homepage/my_photo.png" width="25px" align="absmiddle">&emsp;my photo</p></a>
            <a href="favor.php"><p class="li"><img src="../../img/images/homepage/favor.png" width="25px" align="absmiddle">&emsp;favor</p></a>
            <a onclick="logout()"><p class="li"><img src="../../img/images/homepage/login.png" width="25px" align="absmiddle">&emsp;logout</p></a>
        </div>
    </div>';
        echo '<div id="username" hidden>' . $_SESSION['Username'] . '</div>
<div id="ImageID" hidden>' . $id . '</div>';
    }
    ?>
</nav>
<script src="../js/index.js"></script>
<script>
    function collect() {
        //获取用户名
        let username = document.getElementById('username').innerText;
        if(username != ''){
            //获取图片ID
            let ImageID = document.getElementById('ImageID').innerText;
            $.post(
                'collect.php',
                {
                    username:username,
                    ImageID:ImageID
                },
                function (data,status) {
                    if(data == 1){
                        alert('你已经收藏过了！');
                    } else {
                alert('收藏成功！');
                location.reload();
            }
        }
            );
        } else {
            alert("请先登录！");
        }

    }
</script>
<div class="title">
    <p class="title-p">Details</p>
</div>
<div class="details">
    <div class="details-top">
        <p class="details-title">
            <?php
            echo '"' . $row1['Title'] . '"';
            ?>
        </p>
        <p class="details-creator">
            <?php
            echo 'by ' . $uploader;
            ?>
        </p>
    </div>
    <div class="details-medium">
        <div>
            <div class="details-content">
                <?php
                echo '<img src="../../img/travel-images/normal/medium/' . $row1['PATH'] . '" width="700px" id="img">';
                ?>
            </div>
            <div class="details-content">
                <div class="label1">
                    <div class="label-title">
                        <p class="title-p">Like Number</p>
                    </div>
                    <div class="label-bottom">
                        <p class="label1-content-p">
                            <?php echo $likeNum ?>
                        </p>
                    </div>
                </div>
                <div class="label2">
                    <div class="label-title">
                        <p class="title-p">Image Details</p>
                    </div>
                    <div class="label-medium">
                        <p class="label2-p">Content:&emsp;<?php echo $row1['Content'] ?></p>
                    </div>
                    <div class="label-medium">
                        <p class="label2-p">Country:&emsp;<?php echo $row2['CountryName'] ?></p>
                    </div>
                    <div class="label-bottom">
                        <p class="label2-p">City:&emsp;<?php
                            if($city != null) {
                                echo $row3['AsciiName'];
                            }?></p>
                    </div>
                </div>
                <button type="submit" name="收藏" onclick="collect()">
                    <img src="../../img/images/details/红心.gif" class="redheart" align="absmiddle">收藏
                </button>
            </div>
        </div>
    </div>
    <div class="details-bottom">
        <p><?php echo $row1['Description'] ?></p>
    </div>
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
