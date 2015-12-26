<?php

include_once("classes/DBConnector.class.php");

class ToplamPuanHesaplayici
{

var $whichUsr;

public function ToplamPuanHesaplayici($which)
{
	global $whichUsr;

	$whichUsr = $which;
}

public function PuanHesapla()
{
	global $whichUsr;

	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	if ($connection->connect_error)
		return "?";

	else
	{
		$query = "SELECT sum(threadPoint) FROM threads WHERE threadWriter = '$whichUsr'";
		$results = $connection->query($query);
		$resultAssoc = $results->fetch_assoc();
		if (isset($resultAssoc["sum(threadPoint)"]))
			return $resultAssoc["sum(threadPoint)"];
		return 0;
	}
}

public function FavoriHesapla()
{
	global $whichUsr;
	$query = "SELECT count(threadWriter) FROM favoriler NATURAL JOIN threads WHERE threadWriter='$whichUsr'";

	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);


	if ($connection->connect_error)
		return "?";
	else
	{
		$results = $connection->query($query);
		$resultAssoc = $results->fetch_assoc();
		if (isset($resultAssoc["count(threadWriter)"]))
			return $resultAssoc["count(threadWriter)"];
		return 0;
	}
}

public function YorumHesapla()
{

	global $whichUsr;
	$query = "SELECT count(writerName) FROM comments WHERE writerName='$whichUsr'";

	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	if ($connection->connect_error)
		return "?";
	else
	{
		$results = $connection->query($query);
		$resultAssoc = $results->fetch_assoc();
		if (isset($resultAssoc["count(writerName)"]))
			return $resultAssoc["count(writerName)"];
		return 0;
	}

}

}

?>
