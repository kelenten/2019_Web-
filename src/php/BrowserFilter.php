<?php
//将城市名和国家名转换为CODE
$country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';
$city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
$result;

require_once("config.php");

$pdo1 = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "select * from geocountries where CountryName=:name";
$statement1 = $pdo1->prepare($sql1);
$statement1->bindValue(':name',$country);
$statement1->execute();
$row1 = $statement1->fetch();
$result[] = $row1['ISO'];
$pdo1 = null;

$pdo2 = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql2 = "select * from geocities where AsciiName=:name";
$statement2 = $pdo2->prepare($sql2);
$statement2->bindValue(':name',$city);
$statement2->execute();
$row2 = $statement2->fetch();
$result[] = $row2['GeoNameID'];

$pdo2 = null;

echo json_encode($result);
?>
