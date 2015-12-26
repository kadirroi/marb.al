<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
$offset = $_POST["loadMoreBestOffset"];

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if (!$connection->connect_error)
{
		$connection->set_charset("utf8");
		$x = intval($offset);
		$results = $connection->query("SELECT * FROM threads ORDER BY threadID DESC LIMIT 6 OFFSET ".($x));
		echo $results->num_rows;
		while ($curres = $results -> fetch_assoc())
		{
			$threadID5 = $curres ["threadID"];
			$threadDate5 = $curres["threadDate"];
			$threadWriter5 = $curres["threadWriter"];
			$threadCategory5 = $curres["threadCategory"];
			$threadPicture5 = $curres["threadPicture"];
			$stepCount5 = $curres["stepCount"];
			$threadName5 = $curres["threadName"];
			$threadPoint5 = $curres["threadPoint"];
				
			$myThread5 = new Thread(array($threadID5,$threadDate5,$threadWriter5,$threadCategory5,$threadPicture5,$stepCount5,$threadName5,$threadPoint5));  
			$myThread5-> ThreadToPetitHTML();
		}
}	

?>
