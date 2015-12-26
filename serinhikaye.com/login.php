<?php
session_start();

include_once("classes/DBConnector.class.php");
$password = htmlspecialchars($_POST["password"]);
$email = htmlspecialchars($_POST["email"]);

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection -> connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	/* database 'e bağlandık */
	$query = "SELECT * FROM users WHERE userEmail=\"".$email."\"";
	$result = $connection->query($query);
	if ($result->num_rows==0)
		echo json_encode(utf8_encode("KULLANICI_YOK"));
	else
	{
		$curResult = $result->fetch_assoc();
		if ($curResult["userPass"] == $password)
		{
			$_SESSION["user_name"]=$curResult["userName"];
			echo json_encode(utf8_encode("OK"));
		}
		else
			echo json_encode(utf8_encode("SIFRE_HATALI"));
	}
	$connection->close();
}
?>
