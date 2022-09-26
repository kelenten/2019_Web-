<?php
require_once("config.php");

$userName = isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : '';
$PATH = isset($_POST['PATH']) ? htmlspecialchars($_POST['PATH']) : '';
$title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
$description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
$country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';
$city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "select max(ImageID) from travelimage";
$statement1 = $pdo->prepare($sql1);
$statement1->execute();
$row1 = $statement1->fetch();

$ImageID = $row1['max(ImageID)'] + 1;

$sql2 = "select * from traveluser where UserName=:username";
$statement2 = $pdo->prepare($sql2);
$statement2->bindValue(':username',$userName);
$statement2->execute();
$row2 = $statement2->fetch();

$UID = $row2['UID'];

$Latitude = null;
$Longitude = null;

$sql3 = "select * from geocountries where CountryName=:countryname";
$statement3 = $pdo->prepare($sql3);
$statement3->bindValue(':countryname',$country);
$statement3->execute();
$row3 = $statement3->fetch();

$CountryCodeISO = $row3['ISO'];

$sql4 = "select * from geocities where AsciiName=:cityname";
$statement4 = $pdo->prepare($sql4);
$statement4->bindValue(':cityname',$city);
$statement4->execute();
$row4 = $statement4->fetch();

$CityCode = $row4['GeoNameID'];

$sql5 = "Insert into travelimage (ImageID,Title,Description,Latitude,Longitude,CityCode,CountryCodeISO,UID,PATH,Content) values (:ImageID,:Title,:Description,:Latitude,:Longitude,:CityCode,:CountryCodeISO,:UID,:PATH,:Content)";
$statement5 = $pdo->prepare($sql5);
$statement5->bindValue(':ImageID',$ImageID);
$statement5->bindValue(':Title',$title);
$statement5->bindValue(':Description',$description);
$statement5->bindValue(':Latitude',$Latitude);
$statement5->bindValue(':Longitude',$Longitude);
$statement5->bindValue(':CityCode',$CityCode);
$statement5->bindValue(':CountryCodeISO',$CountryCodeISO);
$statement5->bindValue(':UID',$UID);
$statement5->bindValue(':PATH',$PATH);
$statement5->bindValue(':Content',$content);
$statement5->execute();
?>
