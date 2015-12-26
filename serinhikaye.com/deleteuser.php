<?php
include_once("classes/DBConnector.class.php");
session_start();

if(!isset($_SESSION["user_name"]))
	echo "usr_not_signed_in";
else
{
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	if (!$connection->connect_error)
	{
		/* password control */

		$queryPassCTRL = "SELECT userPass FROM users WHERE userName=\"".$_SESSION["user_name"]."\"";
		$pass = $connection->query($queryPassCTRL);
		$passAssoc = $pass->fetch_assoc();
		if ($passAssoc["userPass"] === $_POST["deleteuserpassword"])
		{
		$query1 = "DELETE FROM comments WHERE writerName=\"".$_SESSION["user_name"]."\"";
		$query2 = "DELETE FROM conversations WHERE (user1=\"".$_SESSION["user_name"]."\" OR user2=\"".$_SESSION["user_name"]."\")";
		$query3 = "DELETE FROM favoriler WHERE userName=\"".$_SESSION["user_name"]."\"";
		$query4 = "DELETE FROM messages WHERE (From_msg=\"".$_SESSION["user_name"]."\" OR To_msg=\"".$_SESSION["user_name"]."\")";
		$query5 = "DELETE FROM threads WHERE threadWriter=\"".$_SESSION["user_name"]."\"";
		$query6 = "DELETE FROM users WHERE userName=\"".$_SESSION["user_name"]."\"";
		
		$connection->query($query1);
		$connection->query($query2);
		$connection->query($query3);
		$connection->query($query4);
		$connection->query($query5);
		$connection->query($query6);

		session_destroy();
		echo "OK";
		}
		else
			echo "password_not_match";
	}
	else
		echo "connect_error";
		
}

?>
