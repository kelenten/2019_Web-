<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/upload.css" rel="stylesheet">
    <link href="../css/basis.css" rel="stylesheet">
    <script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <title>upload</title>
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
<?php
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
if(isset($_SESSION['Username'])){
    //url若有变量id说明是修改，将图片信息直接显示
    if(isset($_GET['id'])){
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql1 = "select * from travelimage where ImageID=:ImageID and PATH is not null";
        $statement1 = $pdo->prepare($sql1);
        $statement1->bindValue(':ImageID',$_GET['id']);
        $statement1->execute();
        $row1 = $statement1->fetch();

        $sql2 = "select * from geocountries where ISO=:ISO";
        $statement2 = $pdo->prepare($sql2);
        $statement2->bindValue(':ISO',$row1['CountryCodeISO']);
        $statement2->execute();
        $row2 = $statement2->fetch();


        $sql3 = "select * from geocities where GeoNameID=:id";
        $statement3 = $pdo->prepare($sql3);
        $statement3->bindValue(':id',$row1['CityCode']);
        $statement3->execute();
        $row3 = $statement3->fetch();

        $pdo = null;
        echo '<div id="ImageID" hidden>' . $_GET['id'] . '</div>
<div id="userName" hidden>' . $_SESSION['Username'] . '</div>
<div class="subject">
      <div class="label-top">
          <p class="label-title">Upload</p>
      </div>
      <div class="label-bottom">
          <div class="upload">
              <div class="upload-mid">
                  <input type="file" hidden id="upload" accept="image/*"><br>
                  <div id="tips"><img src="../../img/travel-images/normal/medium/' . $row1['PATH'] . '"class="img"></div>
                  <p id="url">' . $row1['PATH'] . '</p>
                  <input type="button" value="modify" id="upload_button" onclick="input.click();">
              </div>
          </div>
          <p class="text">图片标题</p>
          <input type="text" name="title" id="title" value="' . $row1['Title'] . '">
          <p class="text">图片描述</p>
          <textarea class="big-text" id="description">' . $row1['Description'] . '</textarea>
          <div class="warpper">
              <div>
                  <p class="text">主题</p>
                  <select class="select" id="content">
                      <option disabled selected hidden>' . $row1["Content"] . '</option>
                      <option>scenery</option>
                      <option>city</option>
                      <option>people</option>
                      <option>animal</option>
                      <option>building</option>
                      <option>wonder</option>
                      <option>other</option>
                  </select>
              </div>
              <div>
                  <p class="text">国家</p>
                  <select class="select" name="country" id="country" onclick="postCountry()">
                      <option disabled selected hidden>' . $row2['CountryName'] . '</option>
                      ';   generateAllCountry(); echo '
                  </select>
              </div>
              <div>
                  <p class="text">城市</p>
                  <select class="select" name="city" id="city">
                      <option disabled selected hidden>' . $row3['AsciiName'] . '</option>
                  </select>

              </div>
          </div>
          <script src="../js/upload.js"></script>
          <input type="button" name="submit" value="submit" onclick="upload()">
      </div>
  </div>';
 //url没有变量id则说明是上传
    } else {
        echo '<div id="ImageID" hidden></div>
<div id="userName" hidden>' . $_SESSION['Username'] . '</div>
<div class="subject">
      <div class="label-top">
          <p class="label-title">Upload</p>
      </div>
      <div class="label-bottom">
          <div class="upload">
              <div class="upload-mid">
                  <input type="file" hidden id="upload" accept="image/*"><br>
                  <div id="tips">图片未上传</div>
                  <p id="url"></p>
                  <input type="button" value="upload" id="upload_button" onclick="input.click();">
              </div>
          </div>
          <p class="text">图片标题</p>
          <input type="text" name="title" id="title">
          <p class="text">图片描述</p>
          <textarea class="big-text" id="description"></textarea>
          <div class="warpper">
              <div>
                  <p class="text">主题</p>
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
              </div>
              <div>
                  <p class="text">国家</p>
                  <select class="select" name="country" id="country" onclick="postCountry()">
                      <option disabled selected hidden>Select by Country</option>
                      ';   generateAllCountry(); echo '
                  </select>
              </div>
              <div>
                  <p class="text">城市</p>
                  <select class="select" name="city" id="city">
                      <option disabled selected hidden>Select by City</option>
                  </select>

              </div>
          </div>
          <script src="../js/upload.js"></script>
          <input type="button" name="submit" value="submit" onclick="upload()">
      </div>
  </div>';
    }
} else {
    echo '<script>alert("请先登录！")</script>';
    echo '<div class="subject">
    <div class="label-top">
        <p class="label-title">Upload</p>
    </div>
    <div class="label-bottom"></div>
</div>';
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
</html>