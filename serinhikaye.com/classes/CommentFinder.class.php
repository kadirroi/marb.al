<?php
include_once("classes/DBConnector.class.php");
class CommentFinder
{

var $threadID;

public function CommentFinder($id)
{
	global $threadID;

	$threadID = $id;
}

public function Find()
{
	global $threadID;

	$myDBConnector = new DBConnector();

	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
	{
		return false;
	}
	else
	{
		$query = "SELECT count(comment) FROM `comments` WHERE threadID =  ".$threadID;
		$results = $connection->query ($query);
		$resassoc = $results->fetch_assoc();
		$connection->close();
		return $resassoc["count(comment)"];
	}
}

}

?>
