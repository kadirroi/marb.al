<?php
include_once("classes/DBConnector.class.php");

$threadID = $_POST["threadID"];
$commentDate = $_GET["commentDate"];
$writerName = $_GET["writerName"];
$threadIDINT = intval($threadID);

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$sqlRequest = "DELETE FROM comments WHERE (threadID='$threadIDINT' AND commentDate='$commentDate' AND writerName='$writerName')";
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection->connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	if ($connection->query($sqlRequest)===TRUE)
		echo json_encode(utf8_encode("OK"));
	else
		echo json_encode(utf8_encode("QUERY_ERR"));
	$connection->close();
}


?>
