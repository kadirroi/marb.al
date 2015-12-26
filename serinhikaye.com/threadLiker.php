<?php
include_once("classes/DBConnector.class.php");

$threadID = $_GET["id"];


$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$myQuery = "SELECT threadPoint from threads where threadID=".$threadID;
		
$connection= new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	$result = $connection -> query ($myQuery);
	$curResult = $result ->fetch_assoc();		
	$curP = $curResult["threadPoint"];
	$curP++;
	$connection->query ("UPDATE threads SET threadPoint=".$curP." where threadID=".$threadID);
	echo json_encode(array("msg"=>utf8_encode("OK"),"msg2"=>utf8_encode($curP)));	
}

?>
