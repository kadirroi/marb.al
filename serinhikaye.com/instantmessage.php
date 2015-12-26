<?php
include_once ("classes/Message.class.php");
include_once ("classes/DBConnector.class.php");

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();	

$offset = $_POST["offset"];
$user1=$_GET["usr1"];
$user2=$_GET["usr2"];
$monitor = $_GET["monitor"];

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection->connect_error)
	echo "CONNECT_ERR";
else
{
	mysqli_set_charset($connection,"utf8");
	$query = "UPDATE messages SET Read_msg='OK' WHERE To_msg = '$monitor'";
	$connection->query($query);
	$query = "SELECT * FROM messages WHERE ((From_msg='".$user1."' AND To_msg='".$user2."') OR (From_msg='".$user2."' AND To_msg='".$user1."')) LIMIT 100 OFFSET ".$offset;
	$results = $connection->query($query);
	if ($results->num_rows==0)
		echo "NO_NEW";
	else
	{
		while ($curResult = $results->fetch_assoc())
		{
			if ($monitor==$curResult["From_msg"])
				$mode = "EvSahibi";
			else
				$mode = "Deplasman";
			$myMessage = new Message(array($curResult["MessageDate"],$curResult["From_msg"],$curResult["To_msg"],htmlspecialchars($curResult["Message"]),$mode,$curResult["Read_msg"]));
			$myMessage->MessageToHTML();
		}
	}
}
?>
