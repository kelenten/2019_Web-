<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/favor.css" rel="stylesheet">
    <link href="../css/basis.css" rel="stylesheet">
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <title>favor</title>
</head>
<body>
<nav id="nav">
    <a><img src="../../img/images/homepage/logo.jpg" id="img1"></a>
    <a class="left" href="../../index.php"><p class="normal">Home</p></a>
    <a class="left" href="Browser.php"><p class="normal">Browse</p></a>
    <a class="left" href="Search.php"><p class="normal">Search</p></a>
    <?php
    require_once("config.php");
    session_start();
    if(!isset($_SESSION['Username'])){
        echo '<div class="right_logout">
        <a href="login.php"><span class="login">Login</span></a>
    </div>';
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
    }
    ?>
</nav>
<script src="../js/index.js"></script>
<script></script>
<?php
echo '<script>
//将图片ID传向删除收藏的php
function deleteFavor() {
    let ID = event.srcElement.name;
   $.post(
       "deleteFavor.php",
       {
           favorID:ID
       },
       function(data,status) {
           alert("已取消收藏！");
           location.reload();
       });     
}
</script>';
//根据$_SESSION['Username']输出所有的收藏图片
function outputPaintings(){
    if(isset($_SESSION['Username'])){

        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql1 = "select * from traveluser where Username=:name";
        $statement1 = $pdo->prepare($sql1);
        $statement1->bindValue(':name',$_SESSION['Username']);
        $statement1->execute();
        $row1 = $statement1->fetch();
        $UID = $row1['UID'];

        $sql2 = "select * from travelimagefavor where UID=:UID";
        $statement2 = $pdo->prepare($sql2);
        $statement2->bindValue(':UID',$UID);
        $statement2->execute();

        $allFavorID = array();
        $allPaintings = array();
        while ($row2 = $statement2->fetch()){
            $allFavorID[] = $row2['FavorID'];
            $imageID = $row2['ImageID'];
            $pdo2 = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql3 = "select * from travelimage where ImageID=:imageID and PATH is not null";
            $statement3 = $pdo2->prepare($sql3);
            $statement3->bindValue(':imageID',$imageID);
            $statement3->execute();
            $row3 = $statement3->fetch();
            $allPaintings[] = $row3;
            $pdo2 = null;
        }

        $totalCount = count($allPaintings);
        $pdo = null;
        if($totalCount != 0) {
            $pageSize = 4;
            $totalPage = $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));

            if (!isset($_GET['page']))
                $currentPage = 1;
            else
                $currentPage = $_GET['page'];

            $mark = ($currentPage - 1) * $pageSize;
            $firstPage = 1;
            $lastPage = $totalPage;
            $prePage = ($currentPage > 1) ? $currentPage - 1 : 1;
            $nextPage = ($totalPage - $currentPage > 0) ? $currentPage + 1 : $totalPage;


            for ($i = 0; $i < $pageSize && isset($allPaintings[($mark + $i)]); $i++) {
                    echo '<div class="label-medium">';
                    echo '<a href="details.php?id=' . $allPaintings[($mark + $i)]['ImageID'] . '"><img src="../../img/travel-images/normal/medium/' . $allPaintings[($mark + $i)]['PATH'] . '" class="img" align="top"></a>';
                    echo '<div class="content">';
                    echo '<div><p class="title">' . $allPaintings[($mark + $i)]['Title'] . '</p></div>';
                    echo '<div><p class="description">' . $allPaintings[($mark + $i)]['Description'] . '</p></div>';
                    echo '<div class="button"><input type="button" name="' . $allFavorID[$mark + $i] . '" value="Delete" onclick="deleteFavor()"></div> ';
                    echo '</div></div>';
            }


            echo '<div class="label-bottom">' .
                '<div class="wrapper page">' .
                '<a href="favor.php?page=' . $firstPage . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                '<a href="favor.php?page=' . $prePage . '"class="pageIndicator"><p>&lt</p></a>' .
                '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                '<a href="favor.php?page=' . $nextPage . '"class="pageIndicator"><p>&gt</p></a>' .
                '<a href="favor.php?page=' . $lastPage . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                '</div>' .
                '</div>';
        } else {
            echo '<div class="no-label-pic"><p class="noResult">你还没有收藏任何图片，快去收藏一个吧</p></div>';
        }

    } else {
        echo '<div class="no-label-pic"><p class="noResult">请先登录</p></div>';
    }
}
?>
<div class="subject">
    <div class="label-top">
        <p class="label-title">My favorite</p>
    </div>
    <?php outputPaintings(); ?>
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