<?php
include_once("classes/DBConnector.class.php");

$id=$_POST["thread_sil_id_input"];

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection->connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	/* database'e bağlandık */
	$query = "DELETE FROM threads WHERE threadID=\"".$id."\"";
	if ($connection->query($query) === TRUE)
	{
		$query2 = "DELETE FROM sikayetler WHERE threadID=\"".$id."\"";
		if ($connection->query($query2) === TRUE)
		{
			$query3="DELETE FROM steps WHERE threadID=\"".$id."\"";
			if ($connection->query($query3) === TRUE)
			{
				$query4="DELETE FROM comments WHERE threadID=\"".$id."\"";
				if ($connection->query($query4) === TRUE)
					echo json_encode(utf8_encode("OK"));
				else
					echo json_encode(utf8_encode("QUERY_ERR"));
			}
			else
				echo json_encode(utf8_encode("QUERY_ERR"));
		}
		else
			echo json_encode(utf8_encode("QUERY_ERR"));
	}
	else
		echo json_encode(utf8_encode("QUERY_ERR"));
}

?>
