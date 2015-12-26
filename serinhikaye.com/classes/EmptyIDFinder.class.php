<?php
include_once("classes/DBConnector.class.php");
class EmptyIDFinder
{

	public function EmptyIDFinder()
	{

	}

	public function Find()
	{
		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();

		$myQuery = "SELECT MAX(usedID) FROM usedIDs";
		
		$connection= new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

		if ($connection->connect_error)
			return -1;
		
		/* database'e girdik */

		$result = $connection -> query ($myQuery);
		if ($result->num_rows!=0){
			$curResult = $result ->fetch_assoc();
		
			$newResult = $curResult ["MAX(usedID)"];
			$newResult = (int) $newResult;
			$newResult =  $newResult+1;
		}
		else
			$newResult = 1 ;
		if ($connection->query("INSERT INTO usedIDs(usedID) VALUES (".$newResult.")") === TRUE){
			$connection->close();			
			return $newResult;
		}
		$connection->close();
		return -1;
	}

}

?>
