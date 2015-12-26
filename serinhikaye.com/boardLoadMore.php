<?php
include_once("classes/DBConnector.class.php");
include_once("classes/BoardContribution.class.php");

$id = $_GET["id"];

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
$connection->set_charset("utf8");

if ($connection->connect_error)
	echo "CONNECT_ERR";

$mode = $_GET["mode"];

if ($mode == "yeniden_eskiye")
{
	$offset = $_POST["yeniden_eskiye_offset"];
	$query = "SELECT * FROM contributions WHERE boardID=\"".$id."\" AND contributionID<>\"ereased\" ORDER BY contributionDate DESC LIMIT 9 OFFSET ".$offset;
	
	
}
if ($mode == "eskiden_yeniye")
{
	$offset = $_POST["eskiden_yeniye_offset"];
	$query = "SELECT * FROM contributions WHERE boardID=\"".$id."\" AND contributionID<>\"ereased\" ORDER BY contributionDate ASC LIMIT 9 OFFSET ".$offset;
	
	
}
if ($mode == "puana_gore")
{
	$offset = $_POST["puana_gore_offset"];
	$query = "SELECT * FROM contributions WHERE boardID=\"".$id."\" AND contributionID<>\"ereased\" ORDER BY contributionPoint DESC LIMIT 9 OFFSET ".$offset;
}

$results = $connection->query($query);

echo $results->num_rows;

while($curResult = $results->fetch_assoc())
{
	if ($curResult['contributionID']!=="ereased"){
		$myBoardContribution = new BoardContribution(array($curResult['boardID'],$curResult['contributionID'],$curResult['contributor'],$curResult['contributionDate'],$curResult['contributionPoint'],$curResult['contributionExplanation'],$curResult['contributionImage']));
		$myBoardContribution->BoardContributionToHTML();
	}	
}


?>
