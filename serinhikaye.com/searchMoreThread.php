<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");

	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection -> connect_error)
		echo "";
	else
	{
		$offset = $_POST["showMoreSuggestionOffset"];
		$query = $_GET["query"];

		$connection->set_charset("utf8");
		$res = $connection -> query ("SELECT * FROM threads WHERE threadName LIKE '%$query%' ORDER BY threadPoint desc LIMIT 8 OFFSET ".$offset);
		$curCount = $res->num_rows;
		echo $curCount;
			while ($curres = $res -> fetch_assoc())
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
		$connection->close();
	}

?>
