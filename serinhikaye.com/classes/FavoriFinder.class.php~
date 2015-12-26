<?php

include_once("classes/DBConnector.class.php");

class FavoriFinder
{

	var $whichThread;

	public function FavoriFinder($id)
	{
		global $whichThread;

		$whichThread = $id;
	}

	public function Find()
	{
		global $whichThread;

		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();		
		
		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

		if ($connection->connect_error)
			return "?";
		else
		{
			$query = "SELECT * FROM favoriler WHERE threadID='$whichThread'";
			$result = $connection->query($query);
			$connection->close();
			return $result->num_rows;
		}
	}

}

?>
