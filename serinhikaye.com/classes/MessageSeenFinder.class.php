<?php

include_once("classes/DBConnector.class.php");

class MessageSeenFinder
{

var $MessageSeenFinderInfos = array ();

public function MessageSeenFinder($ary)
{
	global $MessageSeenFinderInfos;
	
	$MessageSeenFinderInfos["From"] = $ary[0];
	$MessageSeenFinderInfos["To"] = $ary[1];

}

public function Find()
{
	global $MessageSeenFinderInfos;
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		return "CONNECT_ERR";
	else
	{
		$query = "SELECT * FROM messages WHERE (Read_msg='NO' AND From_msg='".$MessageSeenFinderInfos["From"]."' AND To_msg = '".$MessageSeenFinderInfos["To"]."')";
		$results = $connection->query($query);
		$connection->close();
		if ($results->num_rows>0)
			return "YES";
		else
			return "NO";
	}
}

public function FindForUpMenu()
{
	global $MessageSeenFinderInfos;
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		return "CONNECT_ERR";
	else
	{
		$query = "SELECT * FROM messages WHERE (Read_msg = 'NO' AND To_msg='".$MessageSeenFinderInfos["To"]."')";
		$results = $connection ->query($query);
		$connection->close();
		if ($results->num_rows>0)
			return "YES";
		else
			return "NO";
	}
	
}

}

?>
