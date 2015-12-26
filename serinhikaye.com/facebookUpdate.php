<?php
session_start();
include_once("classes/DBConnector.class.php");

$id = htmlspecialchars($_POST["facebookUpdateIDTXT"]);
$name = htmlspecialchars($_POST["facebookUpdateNameTXT"]);

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);


if ($connection->connect_error)
	echo "CONNECT_ERR";
else
{
	$connection->set_charset("utf8");
	$query = "SELECT * FROM facebookusers WHERE id=\"".$id."\"";
	$results = $connection->query($query);
	if ($results->num_rows==0)
	{
		//$query = "INSERT INTO facebookusers(id,name) VALUES (\"".$id."\",\"".$name."\")";
		//$connection->query($query);
		echo $id;
	}
	else
	{
		$query = "SELECT * FROM users WHERE activationCode = \"".$id."\"";
		$res = $connection->query($query);
		$curres = $res->fetch_assoc();
		$_SESSION["user_name"] = $curres["userName"];
		echo "YES";
	}

}



?>
