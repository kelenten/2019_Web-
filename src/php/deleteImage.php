<?php
//删除特定id的图片
$ImageID = isset($_POST['ImageID']) ? htmlspecialchars($_POST['ImageID']) : '';

require_once("config.php");
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "delete from travelimage where ImageID=:ImageID";
$statement = $pdo->prepare($sql);
$statement->bindValue(':ImageID',$ImageID);
$statement->execute();

$pdo = null;
?>
