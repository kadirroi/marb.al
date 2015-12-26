<?php
include_once("classes/DBConnector.class.php");

$girilen = htmlspecialchars($_POST["baslik_arayici_input"]);

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection -> connect_error)
	echo json_encode(utf8_encode("Baglanti hatasi"));
else
{
	
	$girilen = $connection->real_escape_string($girilen);
	$connection->set_charset("utf8");
	$searchSugQuery = "SELECT * FROM threads WHERE threadName LIKE '%$girilen%' ORDER BY threadPoint desc";

		$results = $connection -> query($searchSugQuery);
		$val ="<div style=\"border-bottom:1px solid #c7d0d5;padding:2%;background-color:#9bca3e;\"><span style=\"font-size:17px;color:#ffffff;font-family: 'Josefin Sans', sans-serif;\">Başlıklar (".$results->num_rows.")</span></div>";
		$i=0;
		if ($results->num_rows!=0){
		while(($curResult = $results->fetch_assoc()) && $i<3)
		{
	$name2 = str_replace(" ","-",$curResult['threadName']);
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
			$i++;
			$val = $val."<a style=\"text-decoration:none;\" href=\"http://serinhikaye.com/thread/".$curResult["threadID"]."/".$name4."\"><div onmouseout=\"this.style.background='#e6e6e6';\" onmouseover=\"this.style.background='#dcdcdc';\" style=\"border-bottom:1px solid #c7d0d5;padding:2%;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;font-size:19px; background-color:#e6e6e6;\">".$curResult["threadName"]."</div></a>";	
		}
		}
		else
		$val = $val."<div style=\"border-bottom:1px solid #c7d0d5;padding:2%;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;font-size:15px;\">Böyle bir başlık hiç varolmadı.</div>";

		$i=0;
		$query ="SELECT * FROM boards WHERE boardName LIKE '%$girilen%'";		
		$results3=$connection->query($query);
		$val = $val."<div style=\"border-bottom:1px solid #c7d0d5;padding:2%;background-color:#3ABBC9;\"><span style=\"font-size:17px;color:#ffffff;font-family: 'Josefin Sans', sans-serif;\">Panolar (".$results3->num_rows.")</span></div>";
		if ($results3->num_rows!=0)
		{
			while (($curResult3 = $results3->fetch_assoc()) && $i<3)
			{
				$i++;
				$val = $val."<a style=\"text-decoration:none;\" href=\"board.php?id=".$curResult3["boardID"]."\"><div onmouseout=\"this.style.background='#e6e6e6';\" onmouseover=\"this.style.background='#dcdcdc';\" style=\"border-bottom:1px solid #c7d0d5;padding:2%;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;font-size:19px; background-color:#e6e6e6;\">".$curResult3["boardName"]."</div></a>";
			}
		}
		else
		$val = $val."<div style=\"border-bottom:1px solid #c7d0d5;padding:2%;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;font-size:15px;\">Böyle bir pano hiç varolmadı.</div>";

		$i=0;
		$query= "SELECT * FROM users WHERE userName LIKE '%$girilen%'";
		$results2 = $connection->query($query);
		$val =$val."<div style=\"border-bottom:1px solid #c7d0d5;padding:2%;background-color:#ffb92a;\"><span style=\"font-size:17px;color:#ffffff;font-family: 'Josefin Sans', sans-serif;\">Yazarlar (".$results2->num_rows.")</span></div>";
		if ($results2-> num_rows!=0){
			while (($curResult2 = $results2->fetch_assoc()) && $i<3)
			{
				$i++;
				$val = $val."<a style=\"text-decoration:none;\" href=\"user.php?name=".$curResult2["userName"]."\"><div onmouseout=\"this.style.background='#e6e6e6';\" onmouseover=\"this.style.background='#dcdcdc';\" style=\"border-bottom:1px solid #c7d0d5;padding:2%;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;font-size:19px; background-color:#e6e6e6;\">".$curResult2["userName"]."</div></a>";
			}
		}
		else		
		$val = $val."<div style=\"border-bottom:1px solid #c7d0d5;padding:2%;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;font-size:15px;\">Böyle bir yazar yok.</div>";


		echo $val;
	
}

?>
