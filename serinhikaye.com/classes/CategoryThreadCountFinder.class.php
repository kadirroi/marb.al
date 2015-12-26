<?php
include_once("classes/DBConnector.class.php");
class CategoryThreadCountFinder
{

public function CategoryThreadCountFinder()
{

}

public function Find()
{

$myDBConnector = new DBConnector();

$dbARY = $myDBConnector->infos();

$connection= new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	return false;
else
{
	$connection->set_charset("utf8");
	$query1 = "SELECT count(threadID) FROM threads WHERE threadCategory = \"Alakasız\"" ;
	$query2 = "SELECT count(threadID) FROM threads WHERE threadCategory = \"Bilim/Kültür\" ";
	$query3 = "SELECT count(threadID) FROM threads WHERE threadCategory = \"Sosyal ilişkiler\"" ;
 	$query4 = "SELECT count(threadID) FROM threads WHERE threadCategory = \"Sağlık/Spor\"" ;
	$query5 =  "SELECT count(threadID) FROM threads WHERE threadCategory = \"Yemek/İçmek\"" ;
	$query6 =  "SELECT count(threadID) FROM threads WHERE threadCategory = \"Bilgisayar/Elektronik\"" ;
	$query7 =  "SELECT count(threadID) FROM threads WHERE threadCategory = \"Sanat/Eğlence\"" ;
		
	$res1 = $connection->query($query1);
	$res2 = $connection->query($query2);
	$res3 = $connection->query($query3);
	$res4 = $connection->query($query4);
	$res5 = $connection->query($query5);
	$res6 = $connection->query($query6);
	$res7 = $connection->query($query7);

	$res1_assoc = $res1->fetch_assoc();
	$res2_assoc = $res2->fetch_assoc();
	$res3_assoc = $res3->fetch_assoc();
	$res4_assoc = $res4->fetch_assoc();
	$res5_assoc = $res5->fetch_assoc();
	$res6_assoc = $res6->fetch_assoc();
	$res7_assoc = $res7->fetch_assoc();

	$connection->close();	

	return array($res1_assoc["count(threadID)"],$res2_assoc["count(threadID)"],$res3_assoc["count(threadID)"],$res4_assoc["count(threadID)"],$res5_assoc["count(threadID)"],$res6_assoc["count(threadID)"],$res7_assoc["count(threadID)"]);

	
}

}

public function Find2()
{


$myDBConnector = new DBConnector();

$dbARY = $myDBConnector->infos();

$connection= new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection->connect_error)
	return false;
else
{
	$connection->set_charset("utf8");
	$query1 = "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Alakasız\"" ;
	$query2 = "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Bilim/Kültür\" ";
	$query3 = "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Sosyal ilişkiler\"" ;
 	$query4 = "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Sağlık/Spor\"" ;
	$query5 =  "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Yemek/İçmek\"" ;
	$query6 =  "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Bilgisayar/Elektronik\"" ;
	$query7 =  "SELECT count(distinct threadWriter) FROM threads WHERE threadCategory = \"Sanat/Eğlence\"" ;
		
	$res1 = $connection->query($query1);
	$res2 = $connection->query($query2);
	$res3 = $connection->query($query3);
	$res4 = $connection->query($query4);
	$res5 = $connection->query($query5);
	$res6 = $connection->query($query6);
	$res7 = $connection->query($query7);

	$res1_assoc = $res1->fetch_assoc();
	$res2_assoc = $res2->fetch_assoc();
	$res3_assoc = $res3->fetch_assoc();
	$res4_assoc = $res4->fetch_assoc();
	$res5_assoc = $res5->fetch_assoc();
	$res6_assoc = $res6->fetch_assoc();
	$res7_assoc = $res7->fetch_assoc();

	$connection->close();	

	return array($res1_assoc["count(distinct threadWriter)"],$res2_assoc["count(distinct threadWriter)"],$res3_assoc["count(distinct threadWriter)"],$res4_assoc["count(distinct threadWriter)"],$res5_assoc["count(distinct threadWriter)"],$res6_assoc["count(distinct threadWriter)"],$res7_assoc["count(distinct threadWriter)"]);

	
}

}

}

?>
