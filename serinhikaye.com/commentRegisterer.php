<?php
	include_once ("classes/ActivationFinder.class.php");
	include_once ("classes/DBConnector.class.php");

	$threadID = $_GET["id"];
	$userName = $_GET["username"];
	$comment = htmlspecialchars($_POST["commentholder"]);
	$commentDate = date('d/m/Y H:i:s');
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$myActivationFinder = new ActivationFinder ($userName);
	$activation = $myActivationFinder->Find();
	if ($activation == TRUE)
	{
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($comment!=="")
		if ($connection->connect_error)
			echo "CONNECT_ERR";
	else
	{
		$connection->set_charset("utf8");
		$querijandro = "INSERT INTO comments(`threadID`, `comment`, `commentDate`, `writerName`) VALUES ('$threadID',\"".$comment."\",\"".$commentDate."\",\"".$userName."\")";
		if ($connection->query($querijandro)===TRUE)
			echo "OK";
		else
			echo "QUERY_ERR";
		$connection->close();
	}
	else
		echo "BOS";	
	}
	else
		echo "USR_NON_ACTIVE";

?>
