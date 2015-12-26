<?php
include_once("classes/DBConnector.class.php");

$kimden = $_GET["kimden"];
$kime = $_GET["kime"];
$date = date('d/m/Y H:i:s');
$msg = htmlspecialchars($_POST["messagesendertextarea"]);

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	echo "CONNECT_ERR";
else
{
	/* DATABASE' E BAĞLANDIK */
	$connection->set_charset("utf8");
	$msg = $connection->real_escape_string($msg);

	$query = "SELECT * FROM conversations WHERE ((user1='".$kimden."' AND user2='".$kime."') OR (user1='".$kime."' AND user2='".$kimden."'))";
	
	$results = $connection -> query($query);
	
	if ($results->num_rows==0)
	{
		$queryINS = "INSERT INTO `conversations`(`user1`, `user2`, `lastDate`) VALUES ('$kimden','$kime',NOW())";
		if($connection->query($queryINS))
		{
			$query = "INSERT INTO messages (`MessageDate`, `From_msg`, `To_msg`, `Message`, `Read_msg`) VALUES (NOW(),'$kimden','$kime','$msg','NO')";
			if ($connection->query($query))
				echo "OK";
			else
				echo "QUERY_ERR";
		}
		else
			echo "QUERY_ERR";	
	}
	else
	{
		$query = "INSERT INTO messages (`MessageDate`, `From_msg`, `To_msg`, `Message`, `Read_msg`) VALUES(NOW(),'$kimden','$kime','$msg','NO')";
			if ($connection->query($query))
			{
				$queryUPD = "UPDATE conversations SET lastDate=NOW() WHERE ((user1=\"".$kimden."\" AND user2=\"".$kime."\") OR (user1=\"".$kime."\" AND user2=\"".$kimden."\"))";
				if ($connection->query($queryUPD))
					echo "OK";
				else
					echo "QUERY_ERR";
			}
			else
				echo "QUERY_ERR";		
	}
}

?>
