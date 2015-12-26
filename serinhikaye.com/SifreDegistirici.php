<?php
session_start();

include_once("classes/DBConnector.class.php");

function validateLatin($string) {
    $result = false;
 
    if (preg_match("/^[\w\d\s.,-]*$/", $string)) {
        $result = true;
    }
 
    return $result;
}
$eskiSifre = $_POST["passChangeEskiSifre"];
$yeniSifre = $_POST["passChangeYeniSifre"];
$userName = $_SESSION["user_name"];
$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
if (validateLatin($yeniSifre)){	
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connecion->connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	$query = "SELECT * FROM users WHERE userName='$userName'";
	$results = $connection->query($query);
	$curResult = $results->fetch_assoc();
	if ($eskiSifre!==$curResult["userPass"])
		echo json_encode(utf8_encode("SIFRE_HATALI"));
	else
	{
		$query = "UPDATE users SET userPass='$yeniSifre' WHERE userName='$userName'";
		if ($connection->query($query)===TRUE)	
			echo json_encode(utf8_encode("OK"));
		else
			echo json_encode(utf8_encode("QUERY_ERR"));
	}
	 
}
}
else
	echo json_encode(utf8_encode("SIFRE_TURKCE"));
?>
