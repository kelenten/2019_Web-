<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/css/home.css" rel="stylesheet">
    <link href="src/css/basis.css" rel="stylesheet">
    <title>Home</title>
</head>
<body>
<nav id="nav">
    <a><img src="img/images/homepage/logo.jpg" id="img1"></a>
    <a class="left" href="src/php/index.php"><p class="active">Home</p></a>
    <a class="left" href="src/php/Browser.php"><p class="normal">Browse</p></a>
    <a class="left" href="src/php/Search.php"><p class="normal">Search</p></a>
    <?php
    require_once("src/php/config.php");
    session_start();
    //若没登陆，则显示“login”
    if(!isset($_SESSION['Username'])){
        echo '<div class="right_logout">
        <a href="src/php/login.php"><span class="login">Login</span></a>
    </div>';
    } else {
        //若已经登录则显示用户中心
        echo '<div class="right_login">
        <span class="drop-ul">My account</span>
        <img src="img/images/homepage/drop-down.jpg" width="20px">
        <div class="drop-li">
            <a href="src/php/upload.php"><p class="li"><img src="img/images/homepage/upload.png" width="25px" align="absmiddle">&emsp;upload</p></a>
            <a href="src/php/my_photo.php"><p class="li"><img src="img/images/homepage/my_photo.png" width="25px" align="absmiddle">&emsp;my photo</p></a>
            <a href="src/php/favor.php"><p class="li"><img src="img/images/homepage/favor.png" width="25px" align="absmiddle">&emsp;favor</p></a>
            <a onclick="logout()"><p class="li"><img src="img/images/homepage/login.png" width="25px" align="absmiddle">&emsp;logout</p></a>
        </div>
    </div>';
    }
    ?>
    <script src="src/js/index.js"></script>
</nav>
<?php
//检查随机数是否有重复
function checkNum($n){
    for ($i = 0;$i < 6;$i++){
        for($j = $i + 1;$j < 6 ;$j++){
            if($n[$i] == $n[$j]){
                return true;
            }
        }
    }
    return false;
}

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from travelimage where PATH is not null";
$result = $pdo->query($sql);

$rowArray = array();
//将搜索结果储存在数组中
while ($row = $result->fetch()){
    $rowArray[] = $row;
}
$num = array();
//生成六个无重复的随机数
do{
    for($i = 0;$i < 6;$i++) {
        $num[$i] = rand(0,count($rowArray)-1);
    }
} while(checkNum($num));

//找到被收藏最多的图片
$HotNum = 0;
$HotID = 0;
for($i = 0;$i < count($rowArray);$i++){
    $sql = 'select * from travelimageFavor where ImageID=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $rowArray[$i]['ImageID']);
    $statement->execute();
    if($statement->rowCount() > $HotNum){
        $HotNum = $statement->rowCount();
        $HotID = $rowArray[$i]['ImageID'];
    }
}
//打印热门图片函数
function outputHotImage($HotID){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select * from travelimage where ImageID=:id and PATH is not null';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $HotID);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    echo '<a href="src/php/details.php?id=' . $HotID . '"><img src="img/travel-images/normal/medium/' . $row['PATH'] . '" id="big-img"></a>';
}

?>
<div class="big-img">
<?php outputHotImage($HotID); ?>
</div>
<div class="button-one">
    <a href="index.php#nav"><img src="img/images/homepage/toTop.png" id="img-top"></a>
</div>
<!--刷新网页按钮-->
<div class="button-two">
    <a onclick="location.reload()"><img src="img/images/homepage/refresh.png" id="img-refresh"></a>
</div>
<!--打印随机图片-->
<div class="table">
    <div class="element">
        <?php echo '<a href="src/php/details.php?id=' . $rowArray[$num[0]]['ImageID'] . '"><img src="img/travel-images/medium/' . $rowArray[$num[0]]['PATH'] . '" class="small-img"></a>' .
            '<p class="title">"' . $rowArray[$num[0]]['Title'] . '"</p>' .
            '<p class="describe">' . $rowArray[$num[0]]['Description'] . '</p>';
        ?>
    </div>
    <div class="element">
        <?php echo '<a href="src/php/details.php?id=' . $rowArray[$num[1]]['ImageID'] . '"><img src="img/travel-images/medium/' . $rowArray[$num[1]]['PATH'] . '" class="small-img"></a>' .
            '<p class="title">"' . $rowArray[$num[1]]['Title'] . '"</p>' .
            '<p class="describe">' . $rowArray[$num[1]]['Description'] . '</p>';
        ?>
    </div>
    <div class="element">
        <?php echo '<a href="src/php/details.php?id=' . $rowArray[$num[2]]['ImageID'] . '"><img src="img/travel-images/medium/' . $rowArray[$num[2]]['PATH'] . '" class="small-img"></a>' .
            '<p class="title">"' . $rowArray[$num[2]]['Title'] . '"</p>' .
            '<p class="describe">' . $rowArray[$num[2]]['Description'] . '</p>';
        ?>
    </div>
    <div class="element">
        <?php echo '<a href="src/php/details.php?id=' . $rowArray[$num[3]]['ImageID'] . '"><img src="img/travel-images/medium/' . $rowArray[$num[3]]['PATH'] . '" class="small-img"></a>' . '<p class="title">"' . $rowArray[$num[3]]['Title'] . '"</p>' . '<p class="describe">' . $rowArray[$num[3]]['Description'] . '</p>';
        ?>
    </div>
    <div class="element">
        <?php echo '<a href="src/php/details.php?id=' . $rowArray[$num[4]]['ImageID'] . '"><img src="img/travel-images/medium/' . $rowArray[$num[4]]['PATH'] . '" class="small-img"></a>' .
            '<p class="title">"' . $rowArray[$num[4]]['Title'] . '"</p>' .
            '<p class="describe">' . $rowArray[$num[4]]['Description'] . '</p>';
        ?>
    </div>
    <div class="element">
        <?php echo '<a href="src/php/details.php?id=' . $rowArray[$num[5]]['ImageID'] . '"><img src="img/travel-images/medium/' . $rowArray[$num[5]]['PATH'] . '" class="small-img"></a>' .
            '<p class="title">"' . $rowArray[$num[5]]['Title'] . '"</p>' .
            '<p class="describe">' . $rowArray[$num[5]]['Description'] . '</p>';
        ?>
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
            <img src="img/images/homepage/2Dcode.jpg" width="100px">
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