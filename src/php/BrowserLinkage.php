<?php
//将某国家中所有城市存在数组中，转为json传回js文件中
$n = isset($_POST['num']) ? htmlspecialchars($_POST['num']) : '';
require_once("config.php");

$pdo1 = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "select * from geocountries where CountryName=:name";
$statement1 = $pdo1->prepare($sql1);
$statement1->bindValue(':name',$n);
$statement1->execute();

$result = '0';
if($statement1->rowCount() > 0){
    $ISO = $statement1->fetch()['ISO'];

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select * from geocities where CountryCodeISO=:ISO order by AsciiName limit 0,5000";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':ISO',$ISO);
    $statement->execute();

    $allCities = array();
    while ($row = $statement->fetch()){
        $allCities[] = $row['AsciiName'];
    }
    $result = json_encode($allCities);
    $pdo = null;
}
$pdo1 = null;

echo $result;
?>