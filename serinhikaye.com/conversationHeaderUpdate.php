<?php

include_once("classes/DBConnector.class.php");
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	if ($connection->connect_error)
		echo "Database bağlantı hatası";
	else
	{
		mysqli_set_charset($connection,"utf8");
		$query = "SELECT * FROM messages WHERE ((From_msg='".$_GET["usr1"]."' AND To_msg='".$_GET["usr2"]."') OR (From_msg='".$_GET["usr2"]."' AND To_msg='".$_GET["usr1"]."')) ORDER BY MessageDate DESC LIMIT 1";
		$results = $connection->query($query);
		$myRes = $results->fetch_assoc();
		$str="";
		$str=$str. "<p style=\"color:#ec583a;\">";
			$str=$str. $_GET["usr2"]."  ";
		$str=$str. "</p>";
		$str=$str. "<p style=\"color:#6e6e6e;\">";
			$str=$str. $myRes["Message"];
		$str=$str. "</p>";
		$str=$str. "<p style=\"color:#6e6e6e;font-size:12px;font-style:italic;\">";
			$str=$str. "(".$myRes["MessageDate"].")";
		$str=$str. "</p>";
		
			
		$connection->close();
		echo $str;	
	}		

?>
