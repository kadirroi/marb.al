<?php
include_once("classes/DBConnector.class.php");

$contributionID = $_GET["cID"];
$boardID = $_GET["bID"];


$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$myQuery = "SELECT contributionPoint from contributions where boardID=\"".$boardID."\" AND contributionID=\"".$contributionID."\"";
		
$connection= new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	$result = $connection -> query ($myQuery);
	$curResult = $result ->fetch_assoc();		
	$curP = intval($curResult["contributionPoint"]);
	$curP++;
	$connection->query ("UPDATE contributions SET contributionPoint=\"".$curP."\" where contributionID=\"".$contributionID."\" AND boardID=\"".$boardID."\"");
	echo $curP;	
}

?>
