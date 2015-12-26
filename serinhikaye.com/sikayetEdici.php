<?php
include_once("classes/DBConnector.class.php");

	$threadID = $_GET["id"];
	$sikayet = $_POST["sikayetholder"];
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		echo json_encode(utf8_encode("CONNECT_ERR"));
	else
	{	
		$sqlReq = " INSERT INTO sikayetler(threadID,sikayet) VALUES ('$threadID','$sikayet')";
		if ($connection->query($sqlReq)===TRUE)
			echo json_encode(utf8_encode("OK"));
		else
			echo json_encode(utf8_encode("QUERY_ERR"));
		$connection->close();
	}
?>
