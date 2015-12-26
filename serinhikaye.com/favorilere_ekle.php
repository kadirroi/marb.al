<?php
session_start();

include_once("classes/DBConnector.class.php");

$id = $_GET["id"];
if (isset ($_SESSION["user_name"]))
{
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	if ($connection->connect_error)
		echo "CONNECT_ERR";
	else
	{
		$query = "SELECT * FROM favoriler WHERE (userName='".$_SESSION["user_name"]."' AND threadID='$id')";
		$results = $connection -> query($query);
		if ($results->num_rows==0)		
		{
			$query = "INSERT INTO `favoriler`(`threadID`, `userName`) VALUES ('$id','".$_SESSION["user_name"]."')";
			if ($connection->query($query)===TRUE)
				echo "OK";
			else
				echo "QUERY_ERR";
		}
		else
			echo "USR_ALREADY_LIKED";
	}

}
else
	echo "NOT_LOGGED_IN";

?>
