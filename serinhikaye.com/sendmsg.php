<?php
include_once("classes/DBConnector.class.php");

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$from = $_GET["from"];
$to = $_GET["to"];
$date = date('d/m/Y H:i:s');
$read = "NO";
$message = htmlspecialchars($_POST["messageholder"]);

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	echo "CONNECT_ERR";
else
{
	/*database'e bağlandık*/
	$connection->set_charset("utf8");
	$message = $connection->real_escape_string($message);
	$query = "INSERT INTO messages (`MessageDate`, `From_msg`, `To_msg`, `Message`, `Read_msg`) VALUES (NOW(),'$from','$to','$message','$read')";
	if ($connection->query($query))
	{
		$query2="UPDATE conversations SET lastDate=NOW() WHERE ((user1=\"".$from."\" AND user2=\"".$to."\") OR (user1=\"".$to."\" AND user2=\"".$from."\"))";
		if ($connection->query($query2))
			echo "OK";
		else
			echo $query2;
	}
	else
		echo $query;
	$connection->close();
}

?>
