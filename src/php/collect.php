<?php
//为用户添加新的收藏图片
$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$ImageID = isset($_POST['ImageID']) ? htmlspecialchars($_POST['ImageID']) : '';

require_once("config.php");

$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = 'select * from traveluser where UserName=:username';
$statement1 = $pdo->prepare($sql1);
$statement1->bindValue(':username',$username);
$statement1->execute();
$row1 = $statement1->fetch();
$UID = $row1['UID'];

$sql0 = 'select * from travelimagefavor where UID=' . $UID . ' and ImageID=' . $ImageID;
$statement0 = $pdo->prepare($sql0);
$statement0->execute();
if($statement0->rowCount() > 0){
    echo 1;
} else{
    $sql2 = 'select max(FavorID) from travelimagefavor';
    $statement2 = $pdo->query($sql2);
    $row2 = $statement2->fetch();
    $FavorID = $row2['max(FavorID)'] + 1;

    $sql3 = 'insert into travelimagefavor (FavorID,UID,ImageID) values (:FavorID,:UID,:ImageID)';
    $statement3 = $pdo->prepare($sql3);
    $statement3->bindValue(':FavorID',$FavorID);
    $statement3->bindValue(':UID',$UID);
    $statement3->bindValue(':ImageID',$ImageID);
    $statement3->execute();

    $pdo = null;
}
?>
