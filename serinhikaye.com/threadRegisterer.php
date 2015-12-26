<?php
include_once("classes/DBConnector.class.php");

	$userName = $_GET["username"];
	$threadID = $_GET["threadID"];
	$stepCount = $_POST["how_many_steps_there_are2"];
	$threadCategory = $_POST["thread_cat_select"];
	$threadDate = date('d/m/Y H:i');
	$threadName1 = htmlspecialchars($_POST["baslik_part_1"]);
	$threadName2= htmlspecialchars($_POST["baslik_part_2"]);
	$threadPicture = $_POST["resim_linki2"];
	$threadPoint = 0;	
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		echo json_encode(utf8_encode("CONNECT_ERR"));
	else
	{
		/* database'e bağlandık */
		$connection->set_charset("utf8");
		if ($stepCount>=2)
		{
			if ($threadName1!=='')
				if ($threadName2!=='')
				{
					$threadName1 = $connection->real_escape_string($threadName1);
					$threadName2 = $connection->real_escape_string($threadName2);
					$threadName = $threadName1." nasıl ".$threadName2;
					$name2 = str_replace(" ","-",$threadName);
					$name3 = str_replace("?","",$name2);
					$name4 = str_replace("ç","c",$name3);
					$name4 = str_replace("ğ","g",$name4);
					$name4 = str_replace("ı","i",$name4);
					$name4 = str_replace("ö","o",$name4);
					$name4 = str_replace("ş","s",$name4);
					$name4 = str_replace("ü","u",$name4);
					$name4 = str_replace("İ","i",$name4);
					$name4 = str_replace("Ç","C",$name4);
					$name4 = str_replace("Ğ","G",$name4);
					$name4 = str_replace("Ö","O",$name4);
					$name4 = str_replace("Ş","S",$name4);
					$name4 = str_replace("Ü","U",$name4);
					$name4 = str_replace("'","-",$name4);
					$name4 = str_replace("\"","-",$name4);
					$name4 = str_replace(",","-",$name4);
					$sqlRequest1 = "INSERT INTO threads(threadID,threadDate,threadWriter,threadCategory,threadPicture,stepCount,threadName,threadPoint) VALUES ('$threadID','$threadDate','$userName','$threadCategory','$threadPicture','$stepCount','$threadName','$threadPoint')";

					$sqlRequest2 = "SELECT * FROM steps WHERE threadID='$threadID'";

					$stepCounter = 0;

					$results = $connection -> query ($sqlRequest2);
					while ($currResult = $results -> fetch_assoc())
						$stepCounter++;

					if ($stepCounter == $stepCount)
					{
						if ($connection->query($sqlRequest1) === TRUE){
							$sitemap = simplexml_load_file("sitemap.xml");
							$myNewUrl = $sitemap->addChild("url");
							$myNewUrl->addChild("loc", "http://www.serinhikaye.com/thread/".$threadID."/".$name4);
							$sitemap->asXml("sitemap.xml");
							echo json_encode(utf8_encode("OK"));

						}
						else
							echo json_encode(utf8_encode("QUERY_ERR"));
					}
					else
						echo json_encode(utf8_encode("STEP_COUNT_NO_MATCH"));
			
				}	
				else
					echo json_encode(utf8_encode("BASLIK_YANLIS"));
			else
					echo json_encode(utf8_encode("BASLIK_YANLIS"));
		}
		else
			echo json_encode(utf8_encode("STEP_COUNT_ERR"));
		$connection->close();	
	}
	
?>
