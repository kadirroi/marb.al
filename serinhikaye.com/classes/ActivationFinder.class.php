<?php
include_once("classes/DBConnector.class.php");
class ActivationFinder
{
	var $userName;

	public function ActivationFinder($whichUsr)
	{
		global $userName;
		$userName = $whichUsr;
	}

	public function Find()
	{
		global $userName;
		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();

		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
		if ($connection->connect_error)
		{
			return false;
		}
		else
		{
			$query = "SELECT * FROM users WHERE userName=\"".$userName."\"";
			$result = $connection->query($query);
			$activation = $result->fetch_assoc();
			$i = $activation["activation"];
			if ($i=="OK")
				return true;
			else 
				return false;

		}
		return false;
	}
}
?>