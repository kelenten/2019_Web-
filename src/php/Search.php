<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/Search.css" rel="stylesheet">
    <link href="../css/basis.css" rel="stylesheet">
    <title>Search</title>
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
<nav id="nav">
    <a><img src="../../img/images/homepage/logo.jpg" id="img1"></a>
    <a class="left" href="../../index.php"><p class="normal">Home</p></a>
    <a class="left" href="Browser.php"><p class="normal">Browse</p></a>
    <a class="left" href="Search.php"><p class="active">Search</p></a>
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
<?php
//根据url输出相应的图片
function outputPaintings(){
    if(isset($_GET['Title'])) {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $title = '%' . $_GET['Title'] . '%';
        $sql = "select * from travelimage where Title like :title and PATH is not null";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':title', $title);
        $statement->execute();

        $totalCount = $statement->rowCount();
        $allPaintings = array();
        while ($row = $statement->fetch()) {
            $allPaintings[] = $row;
        }
        if($totalCount != 0) {
                $pageSize = 5;
                $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));

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
                    echo '<div class="introduce">';
                    echo '<div class="introduce-title">' . $allPaintings[($mark + $i)]['Title'] . '</div>';
                    echo '<div class="introduce-description">' . $allPaintings[($mark + $i)]['Description'] . '</div>';
                    echo '</div></div>';
                }

                echo '</div>' .
                    '<div class="wrapper page">' .
                    '<a href="Search.php?page=' . $firstPage . '&Title=' . $_GET['Title'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                    '<a href="Search.php?page=' . $prePage . '&Title=' . $_GET['Title'] . '"class="pageIndicator"><p>&lt</p></a>' .
                    '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                    '<a href="Search.php?page=' . $nextPage . '&Title=' . $_GET['Title'] . '"class="pageIndicator"><p>&gt</p></a>' .
                    '<a href="Search.php?page=' . $lastPage . '&Title=' . $_GET['Title'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                    '</div>' .
                    '</div>';
            } else {
            echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
        }
    } else if(isset($_GET['Description'])) {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $description = '%' . $_GET['Description'] . '%';
        $sql = "select * from travelimage where Description like :title and PATH is not null";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':title', $description);
        $statement->execute();

        $totalCount = $statement->rowCount();
        $allPaintings = array();
        while ($row = $statement->fetch()) {
            $allPaintings[] = $row;
        }

        if($totalCount != 0) {
            $pageSize = 5;
            $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));

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
                echo '<div class="introduce">';
                echo '<div class="introduce-title">' . $allPaintings[($mark + $i)]['Title'] . '</div>';
                echo '<div class="introduce-description">' . $allPaintings[($mark + $i)]['Description'] . '</div>';
                echo '</div></div>';
            }

            echo '<div class="wrapper page">' .
                '<a href="Search.php?page=' . $firstPage . '&Description=' . $_GET['Description'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                '<a href="Search.php?page=' . $prePage . '&Description=' . $_GET['Description'] . '"class="pageIndicator"><p>&lt</p></a>' .
                '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                '<a href="Search.php?page=' . $nextPage . '&Description=' . $_GET['Description'] . '"class="pageIndicator"><p>&gt</p></a>' .
                '<a href="Search.php?page=' . $lastPage . '&Description=' . $_GET['Description'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                '</div>';
        } else {
            echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
        }
    } else  {
        echo '<div class="no-label-pic"></div>';
    }
}
?>
<div class="subject">
    <div class="label">
        <div class="label-top">
            <p class="title">Search</p>
        </div>
        <div class="label-bottom">
            <div class="line">
                <input type="radio" name="radio" id="titleRadio"checked><p class="radio">Filter by Title</p>
            </div>
            <div class="line">
                <input type="text" name="text1" id="title">
            </div>
            <div class="line">
                <input type="radio" name="radio" id="descriptionRadio"><p class="radio">Filter by Description</p>
            </div>
            <div class="line">
                <textarea name="text2" id="description"></textarea>
            </div>
            <div class="line">
                <input type="button" name="button" value="Filter" id="filter">
            </div>
        </div>
    </div>
    <script src="../js/Search.js"></script>
    <div class="label">
        <div class="label-top">
            <p class="title">Result</p>
        </div>
        <?php outputPaintings(); ?>
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