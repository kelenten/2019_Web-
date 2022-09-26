
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/basis.css" rel="stylesheet">
    <link href="../css/browser.css" rel="stylesheet">
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <title>Browser</title>
</head>
<body>
<nav id="nav">
    <a><img src="../../img/images/homepage/logo.jpg" id="img1"></a>
    <a class="left" href="../../index.php"><p class="normal">Home</p></a>
    <a class="left" href="Browser.php"><p class="active">Browse</p></a>
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
<?php
//根据不同的url输出图片
function outputPaintings(){
    try{
        if(isset($_GET['c1']) && isset($_GET['c2']) && isset($_GET['c3'])){
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "select * from travelimage where Content=:content and CountryCodeISO=:ISO and CityCode=:city and PATH is not null";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':content',$_GET['c1']);
            $statement->bindValue(':ISO',$_GET['c2']);
            $statement->bindValue(':city',$_GET['c3']);
            $statement->execute();

            $totalCount = $statement->rowCount();
            //将所有搜索结果储存在一个数组中
            $allPaintings = array();
            while($row = $statement->fetch()){
                $allPaintings[] = $row;
            }
            if($totalCount != 0){
                //每页输出16张图片
                $pageSize = 16;
                //总页数
                $totalPage = (int)(($totalCount%$pageSize==0)?($totalCount/$pageSize):($totalCount/$pageSize+1));
                //根据url判断当前页数
                if(!isset($_GET['page']))
                    $currentPage = 1;
                else
                    $currentPage = $_GET['page'];

                $mark = ($currentPage-1)*$pageSize;
                //页码的变量
                $firstPage = 1;
                $lastPage = $totalPage;
                $prePage = ($currentPage>1)?$currentPage-1:1;
                $nextPage = ($totalPage-$currentPage>0)?$currentPage+1:$totalPage;

                echo '<div class="label-pic">' .
                    '<div class="Paintings">';

                for($i = 0;$i < 16 && isset($allPaintings[($mark+$i)]);$i++){
                        echo '<div class="block"><a href="details.php?id=' . $allPaintings[($mark+$i)]['ImageID'] . '"><img src="../../img/travel-images/normal/medium/' . $allPaintings[($mark+$i)]['PATH'] . '" class="singlePainting"></a></div>';
                }
                //页码
                echo '</div>' .
                    '<div class="wrapper page">' .
                    '<a href="Browser.php?page=' . $firstPage . '&c1=' . $_GET['c1'] . '&c2=' . $_GET['c2'] . '&c3=' . $_GET['c3'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                    '<a href="Browser.php?page=' . $prePage . '&c1=' . $_GET['c1'] . '&c2=' . $_GET['c2'] . '&c3=' . $_GET['c3'] . '"class="pageIndicator"><p>&lt</p></a>' .
                    '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                    '<a href="Browser.php?page=' . $nextPage . '&c1=' . $_GET['c1'] . '&c2=' . $_GET['c2'] . '&c3=' . $_GET['c3'] . '"class="pageIndicator"><p>&gt</p></a>' .
                    '<a href="Browser.php?page=' . $lastPage . '&c1=' . $_GET['c1'] . '&c2=' . $_GET['c2'] . '&c3=' . $_GET['c3'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                    '</div>' .
                    '</div>';
            }  else {
                echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
            }
        } else if(isset($_GET['content'])){
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "select * from travelimage where Content like :content and PATH is not null";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':content',$_GET['content']);
            $statement->execute();

            $totalCount = $statement->rowCount();
            $allPaintings = array();
            while($row = $statement->fetch()){
                $allPaintings[] = $row;
            }

            if($totalCount != 0){
                $pageSize = 16;
                $totalPage = (int)(($totalCount%$pageSize==0)?($totalCount/$pageSize):($totalCount/$pageSize+1));

                if(!isset($_GET['page']))
                    $currentPage = 1;
                else
                    $currentPage = $_GET['page'];

                $mark = ($currentPage-1)*$pageSize;
                $firstPage = 1;
                $lastPage = $totalPage;
                $prePage = ($currentPage>1)?$currentPage-1:1;
                $nextPage = ($totalPage-$currentPage>0)?$currentPage+1:$totalPage;

                echo '<div class="label-pic">' .
                    '<div class="Paintings">';

                for($i = 0;$i < 16 && isset($allPaintings[($mark+$i)]);$i++){
                    echo '<div class="block"><a href="details.php?id=' . $allPaintings[($mark+$i)]['ImageID'] . '"><img src="../../img/travel-images/normal/medium/' . $allPaintings[($mark+$i)]['PATH'] . '" class="singlePainting"></a></div>';
                }

                echo '</div>' .
                    '<div class="wrapper page">' .
                    '<a href="Browser.php?page=' . $firstPage . '&content=' . $_GET['content'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                    '<a href="Browser.php?page=' . $prePage . '&content=' . $_GET['content'] . '"class="pageIndicator"><p>&lt</p></a>' .
                    '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                    '<a href="Browser.php?page=' . $nextPage . '&content=' . $_GET['content'] . '"class="pageIndicator"><p>&gt</p></a>' .
                    '<a href="Browser.php?page=' . $lastPage . '&content=' . $_GET['content'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                    '</div>' .
                    '</div>';
            }  else {
                echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
            }
        }else if(isset($_GET['country'])){
                $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "select * from travelimage where CountryCodeISO like :ISO and PATH is not null";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(':ISO',$_GET['country']);
                $statement->execute();

                $totalCount = $statement->rowCount();
                $allPaintings = array();
                while($row = $statement->fetch()){
                    $allPaintings[] = $row;
                }
                if($totalCount != 0) {
                    $pageSize = 16;
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

                    echo '<div class="label-pic">' .
                        '<div class="Paintings">';

                    for($i = 0;$i < 16 && isset($allPaintings[($mark+$i)]);$i++){
                        echo '<div class="block"><a href="details.php?id=' . $allPaintings[($mark+$i)]['ImageID'] . '"><img src="../../img/travel-images/normal/medium/' . $allPaintings[($mark+$i)]['PATH'] . '" class="singlePainting"></a></div>';
                    }

                    echo '</div>' .
                        '<div class="wrapper page">' .
                        '<a href="Browser.php?page=' . $firstPage . '&country=' . $_GET['country'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                        '<a href="Browser.php?page=' . $prePage . '&country=' . $_GET['country'] . '"class="pageIndicator"><p>&lt</p></a>' .
                        '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                        '<a href="Browser.php?page=' . $nextPage . '&country=' . $_GET['country'] . '"class="pageIndicator"><p>&gt</p></a>' .
                        '<a href="Browser.php?page=' . $lastPage . '&country=' . $_GET['country'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                        '</div>' .
                        '</div>';
                } else {
                echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
            }
        } else if(isset($_GET['city'])){
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "select * from travelimage where CityCode like :citycode and PATH is not null";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':citycode',$_GET['city']);
            $statement->execute();

            $totalCount = $statement->rowCount();
            $allPaintings = array();
            while($row = $statement->fetch()){
                $allPaintings[] = $row;
            }
            if($totalCount != 0) {
                $pageSize = 16;
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

                echo '<div class="label-pic">' .
                    '<div class="Paintings">';

                for($i = 0;$i < 16 && isset($allPaintings[($mark+$i)]);$i++){
                    echo '<div class="block"><a href="details.php?id=' . $allPaintings[($mark+$i)]['ImageID'] . '"><img src="../../img/travel-images/normal/medium/' . $allPaintings[($mark+$i)]['PATH'] . '" class="singlePainting"></a></div>';
                }

                echo '</div>' .
                    '<div class="wrapper page">' .
                    '<a href="Browser.php?page=' . $firstPage . '&city=' . $_GET['city'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                    '<a href="Browser.php?page=' . $prePage . '&city=' . $_GET['city'] . '"class="pageIndicator"><p>&lt</p></a>' .
                    '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                    '<a href="Browser.php?page=' . $nextPage . '&city=' . $_GET['city'] . '"class="pageIndicator"><p>&gt</p></a>' .
                    '<a href="Browser.php?page=' . $lastPage . '&city=' . $_GET['city'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .
                    '</div>' .
                    '</div>';
            } else {
                echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
            }
        } else if(isset($_GET['title']) && $_GET['title'] != ''){
            $input = '%' . $_GET['title'] . '%';

            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "select * from travelimage where Title like :s and PATH is not null";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':s',$input);
            $statement->execute();

            $totalCount = $statement->rowCount();
            $allPaintings = array();
            while($row = $statement->fetch()){
                $allPaintings[] = $row;
            }

            if($totalCount != 0){
                $pageSize = 16;
                $totalPage = (int)(($totalCount%$pageSize==0)?($totalCount/$pageSize):($totalCount/$pageSize+1));

                if(!isset($_GET['page']))
                    $currentPage = 1;
                else
                    $currentPage = $_GET['page'];

                $mark = ($currentPage-1)*$pageSize;
                $firstPage = 1;
                $lastPage = $totalPage;
                $prePage = ($currentPage>1)?$currentPage-1:1;
                $nextPage = ($totalPage-$currentPage>0)?$currentPage+1:$totalPage;

                echo '<div class="label-pic">' .
                    '<div class="Paintings">';

                for($i = 0;$i < 16 && isset($allPaintings[($mark+$i)]);$i++){
                    echo '<div class="block"><a href="details.php?id=' . $allPaintings[($mark+$i)]['ImageID'] . '"><img src="../../img/travel-images/normal/medium/' . $allPaintings[($mark+$i)]['PATH'] . '" class="singlePainting"></a></div>';
                }

                echo '</div>' .
                    '<div class="wrapper page">' .
                    '<a href="Browser.php?page=' . $firstPage . '&title=' . $_GET['title'] . '"class="pageIndicator"><p>&lt&lt</p></a>' .
                    '<a href="Browser.php?page=' . $prePage . '&title=' . $_GET['title'] . '"class="pageIndicator"><p>&lt</p></a>' .
                    '<a class="pageIndicator"><p>'. $currentPage . '</p></a>' .
                    '<a href="Browser.php?page=' . $nextPage . '&title=' . $_GET['title'] . '"class="pageIndicator"><p>&gt</p></a>' .
                    '<a href="Browser.php?page=' . $lastPage . '&title=' . $_GET['title'] . '"class="pageIndicator"><p>&gt&gt</p></a>' .

                    '</div>' .
                    '</div>';
            } else {
                echo '<div class="no-label-pic"><p class="noResult">没有搜索结果</p></div>';
            }
            $pdo = null;

        } else {
            echo '<div class="no-label-pic"></div>';
        }
        $pdo = null;
    } catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
//输出热门内容
function generateHotContent(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql1 = "select * from travelimagefavor";
    $statement1 = $pdo->prepare($sql1);
    $statement1->execute();

    $GLOBALS['allHotContent'] = array();

    while($rowFavor = $statement1->fetch()){
        $sql2 = "select * from travelimage where PATH is not null";
        $statement2 = $pdo->prepare($sql2);
        $statement2->execute();
        while ($rowImage = $statement2->fetch()){
            if($rowFavor['ImageID'] == $rowImage['ImageID']){
                if(isset($GLOBALS['allHotContent'][$rowImage['Content']])){
                    $GLOBALS['allHotContent'][$rowImage['Content']]++;
                } else {
                    $GLOBALS['allHotContent'][$rowImage['Content']] = 1;
                }
            }
        }
    }
    $pdo = null;
    $bigValue = 0;
    $bigKey = '';
    foreach ($GLOBALS['allHotContent'] as $key => $value){
        if($value > $bigValue){
            $bigValue = $value;
            $bigKey = $key;
        }
    }
    echo '<div class="label-bottom">' .
        '<a href="Browser.php?content=' . $bigKey . '"><p class="label-p">' . $bigKey . '</p></a>' .
        '</div>';

    if(count($GLOBALS['allHotContent']) > 1){
        unset($GLOBALS['allHotContent'][$bigKey]);
        $bigValue = 0;
        $bigKey = '';
        foreach ($GLOBALS['allHotContent'] as $key => $value){
            if($value > $bigValue){
                $bigValue = $value;
                $bigKey = $key;
            }
        }
        echo '<div class="label-bottom">
                <a href="Browser.php?content=' . $bigKey . '"><p class="label-p">' . $bigKey . '</p></a>' .
            '</div>';
    }
}
//输出热门国家
function generateHotCountry(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql1 = "select * from travelimagefavor";
    $statement1 = $pdo->prepare($sql1);
    $statement1->execute();

    $GLOBALS['allHotCountry'] = array();

    while($rowFavor = $statement1->fetch()){
        $sql2 = "select * from travelimage where PATH is not null";
        $statement2 = $pdo->prepare($sql2);
        $statement2->execute();
        while ($rowImage = $statement2->fetch()){
            if($rowFavor['ImageID'] == $rowImage['ImageID']){
                if(isset($GLOBALS['allHotCountry'][$rowImage['CountryCodeISO']])){
                    $GLOBALS['allHotCountry'][$rowImage['CountryCodeISO']]++;
                } else {
                    $GLOBALS['allHotCountry'][$rowImage['CountryCodeISO']] = 1;
                }
            }
        }
    }
    $pdo = null;
    $bigValue = 0;
    $bigKey = '';
    foreach ($GLOBALS['allHotCountry'] as $key => $value){
        if($value > $bigValue){
            $bigValue = $value;
            $bigKey = $key;
        }
    }
    echo '<div class="label-medium country">' .
        '<a href="Browser.php?country=' . $bigKey . '"><p class="label-p">' . transCountry($bigKey) . '</p></a>' .
        '</div>';
    unset($GLOBALS['allHotCountry'][$bigKey]);
    if(count($GLOBALS['allHotCountry']) > 0){
        $bigValue = 0;
        $bigKey = '';
        foreach ($GLOBALS['allHotCountry'] as $key => $value){
            if($value > $bigValue){
                $bigValue = $value;
                $bigKey = $key;
            }
        }
        echo '<div class="label-medium country">' .
            '<a href="Browser.php?country=' . $bigKey . '"><p class="label-p">' . transCountry($bigKey) . '</p></a>' .
            '</div>';
        unset($GLOBALS['allHotCountry'][$bigKey]);
        if(count($GLOBALS['allHotCountry']) > 0){
            $bigValue = 0;
            $bigKey = '';
            foreach ($GLOBALS['allHotCountry'] as $key => $value){
                if($value > $bigValue){
                    $bigValue = $value;
                    $bigKey = $key;
                }
            }
            echo '<div class="label-medium country">' .
                '<a href="Browser.php?country=' . $bigKey . '"><p class="label-p">' . transCountry($bigKey) . '</p></a>' .
                '</div>';
            unset($GLOBALS['allHotCountry'][$bigKey]);
            if(count($GLOBALS['allHotCountry']) > 0){
                $bigValue = 0;
                $bigKey = '';
                foreach ($GLOBALS['allHotCountry'] as $key => $value){
                    if($value > $bigValue){
                        $bigValue = $value;
                        $bigKey = $key;
                    }
                }
                echo '<div class="label-bottom country">' .
                    '<a href="Browser.php?country=' . $bigKey . '"><p class="label-p">' . transCountry($bigKey) . '</p></a>' .
                    '</div>';
                unset($GLOBALS['allHotCountry'][$bigKey]);
            } else {
                echo '<script>let city = document.getElementsByClassName("country")[2];city.className = "label-bottom country";</script>';
            }
        } else {
            echo '<script>let city = document.getElementsByClassName("country")[1];city.className = "label-bottom country";</script>';
        }
    } else {
        echo '<script>let city = document.getElementsByClassName("country")[0];city.className = "label-bottom country";</script>';
    }
}
//输出热门城市
function generateHotCity(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql1 = "select * from travelimagefavor";
    $statement1 = $pdo->prepare($sql1);
    $statement1->execute();

    $GLOBALS['allHotCity'] = array();

    while($rowFavor = $statement1->fetch()){
        $sql2 = "select * from travelimage where PATH is not null and CityCode is not null";
        $statement2 = $pdo->prepare($sql2);
        $statement2->execute();
        while ($rowImage = $statement2->fetch()){
            if($rowFavor['ImageID'] == $rowImage['ImageID']){
                if(isset($GLOBALS['allHotCity'][$rowImage['CityCode']])){
                    $GLOBALS['allHotCity'][$rowImage['CityCode']]++;
                } else {
                    $GLOBALS['allHotCity'][$rowImage['CityCode']] = 1;
                }
            }
        }
    }
    $pdo = null;
    $bigValue = 0;
    $bigKey = '';
    foreach ($GLOBALS['allHotCity'] as $key => $value){
        if($value > $bigValue){
            $bigValue = $value;
            $bigKey = $key;
        }
    }
    echo '<div class="label-medium city">' .
        '<a href="Browser.php?city=' . $bigKey . '"><p class="label-p">' . transCity($bigKey) . '</p></a>' .
        '</div>';
    unset($GLOBALS['allHotCity'][$bigKey]);
    if(count($GLOBALS['allHotCity']) > 0){
        $bigValue = 0;
        $bigKey = '';
        foreach ($GLOBALS['allHotCity'] as $key => $value){
            if($value > $bigValue){
                $bigValue = $value;
                $bigKey = $key;
            }
        }
        echo '<div class="label-medium city">' .
            '<a href="Browser.php?city=' . $bigKey . '"><p class="label-p">' . transCity($bigKey) . '</p></a>' .
            '</div>';
        unset($GLOBALS['allHotCity'][$bigKey]);
        if(count($GLOBALS['allHotCity']) > 0){
            unset($GLOBALS['allHotCity'][$bigKey]);
            $bigValue = 0;
            $bigKey = '';
            foreach ($GLOBALS['allHotCity'] as $key => $value){
                if($value > $bigValue){
                    $bigValue = $value;
                    $bigKey = $key;
                }
            }

            echo '<div class="label-medium city">' .
                '<a href="Browser.php?city=' . $bigKey . '"><p class="label-p">' . transCity($bigKey) . '</p></a>' .
                '</div>';
            unset($GLOBALS['allHotCity'][$bigKey]);
            if(count($GLOBALS['allHotCity']) > 0){
                unset($GLOBALS['allHotCity'][$bigKey]);
                $bigValue = 0;
                $bigKey = '';
                foreach ($GLOBALS['allHotCity'] as $key => $value){
                    if($value > $bigValue){
                        $bigValue = $value;
                        $bigKey = $key;
                    }
                }

                echo '<div class="label-bottom city">' .
                    '<a href="Browser.php?city=' . $bigKey . '"><p class="label-p">' . transCity($bigKey) . '</p></a>' .
                    '</div>';
                unset($GLOBALS['allHotCity'][$bigKey]);
            } else {
                echo '<script>let city = document.getElementsByClassName("city")[2];city.className = "label-bottom city";</script>';
            }
        } else {
            echo '<script>let city = document.getElementsByClassName("city")[1];city.className = "label-bottom city";</script>';
        }

    } else {
        echo '<script>let city = document.getElementsByClassName("city")[0];city.className = "label-bottom city";</script>';
    }
}
//ISO转为国家名
function transCountry($ISO){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select * from geocountries where ISO=:ISO";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':ISO',$ISO);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
    return $row['CountryName'];
}
//citycode转为城市名
function transCity($CityCode){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select * from geocities where GeoNameID=:citycode";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':citycode',$CityCode);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
    return $row['AsciiName'];
}
//在列表处生成所有国家
function generateAllCountry(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select * from geocountries order by CountryName";
    $statement = $pdo->query($sql);

    $GLOBALS['cities'] = array();
    while ($rowCountry = $statement->fetch()){
        $GLOBALS['cities'][] = $rowCountry['ISO'];
        echo '<option>' . $rowCountry['CountryName'] . '</option>';
    }
    $pdo = null;
}

?>

<div class="subject">
    <div class="column-one">
        <div class="label-one">
            <div class="label-top">
                <p class="title">Search by Title</p>
            </div>
            <div id="label-one-bottom">
                <form>
                    <input type="text" name='title' id="title">
                    <button type="button" name="search" id="search">
                        <img src="../../img/images/Browser/搜索.jpg" width="40px" height="38px" >
                    </button>
                </form>
            </div>
        </div>
        <div class="label-two">
            <div class="label-top">
                <p class="title">Hot Content</p>
            </div>
            <?php generateHotContent();?>
        </div>
        <div class="label-three">
            <div class="label-top">
                <p class="title">Hot Country</p>
            </div>
            <?php generateHotCountry();?>
        </div>
        <div class="label-four">
            <div class="label-top">
                <p class="title">Hot City</p>
            </div>
            <?php generateHotCity(); ?>
        </div>
    </div>
    <div class="column-two">
        <div class="label-top">
            <p class="title">Filter</p>
        </div>
        <div class="label-filter">
            <form name="selects">
                <select class="select" id="content">
                    <option disabled selected hidden>Select by Content</option>
                    <option>scenery</option>
                    <option>city</option>
                    <option>people</option>
                    <option>animal</option>
                    <option>building</option>
                    <option>wonder</option>
                    <option>other</option>
                </select>
                <select class="select" name="country" id="country" onclick="postCountry()">
                    <option disabled selected hidden>Select by Country</option>
                    <?php generateAllCountry(); ?>
                </select>
                <select class="select" name="city" id="city">
                    <option disabled selected hidden>Select by City</option>
                </select>
            </form>
            <script src="../js/Browser.js"></script>
            <input type="button" name="filter" value="filter" onclick="filter()" id="filter">
        </div>
        <?php outputPaintings() ;?>
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