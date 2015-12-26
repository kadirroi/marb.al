<?php
include_once("classes/DBConnector.class.php");
	$stepNo = $_GET["stepNo"];
	$baslikID =$_GET["threadID"];
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
	{
		echo "CONNECT_ERR";
	}
	else
	{
		$sqlRequest = "DELETE FROM steps WHERE (threadID=".$baslikID." AND stepNo=".$stepNo.")";
		if ($connection->query($sqlRequest)===TRUE)
			echo "OK";
		else
			echo "QUERY_ERR";
		$connection->close();
	}
		
?>
