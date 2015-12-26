<?php
include_once("classes/DBConnector.class.php");
	$stepNo = $_GET["stepNo"];
	$baslikID = $_GET["threadID"];
	$resimLinki = $_POST["resim_linki"];
	$baslik = htmlspecialchars($_POST["basliktxt_".$stepNo]);
	$icerik = str_replace("script"," ",$_POST["icerikholder_".$stepNo]);
	
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($baslik!=="" && $baslik!=="Başlık")
	{
		if ($icerik!=="" && $icerik!=="Bu adımla ilgili, bilgilendirici bir metin yazın. ")
		{
			if ($connection->connect_error)
			{
				echo "CONNECT_ERR";
			}
			else
			{
				/*database'e giriş yapabildik */
				$baslik = $connection->real_escape_string($baslik);
				$icerik = $connection->real_escape_string($icerik);
				$sqlRequest = "INSERT INTO steps (threadID,stepNo,resimLink,baslik,icerik) VALUES ('".$baslikID."',".$stepNo.",'".$resimLinki."','".$baslik."','".$icerik."')";	
				if ($connection->query($sqlRequest)===TRUE)
					echo "OK";
				else
					echo "QUERY_ERR";
				$connection->close();
			}
		}
		else
			echo "ICERIK_BOS";
	}	
	else
		echo "BASLIK_BOS";
?>
