<?php
//删除特定favorId的图片
$FavorID = isset($_POST['favorID']) ? htmlspecialchars($_POST['favorID']) : '';

require_once("config.php");
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "delete from travelimagefavor where FavorID=:favorID";
$statement = $pdo->prepare($sql);
$statement->bindValue(':favorID',$FavorID);
$statement->execute();

$pdo = null;
?>
