<?php
session_start();
include_once("classes/DBConnector.class.php");

if (isset($_SESSION["user_name"])){

$contributionID = $_GET["cID"];
$boardID = $_GET["bID"];


$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

		
$connection= new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	$connection->query ("UPDATE contributions SET contributionID=\"ereased\" where contributionID=\"".$contributionID."\" AND boardID=\"".$boardID."\"");
	echo "OK";	
}

}

?>
