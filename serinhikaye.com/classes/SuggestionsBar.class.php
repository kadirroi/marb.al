<?php
include_once("classes/IndexSocial.class.php");
include_once("classes/DBConnector.class.php");
class SuggestionsBar
{

	var $sinf = array();

	public function SuggestionsBar($ary)
	{
		global $sinf;
		$sinf['quelleCategorie']=$ary[0];
		$sinf['quelleThread']=$ary[1];
	}

	public function SuggestionsBarToHTML()
	{
	
		$myIndexSocial = new IndexSocial();
		echo "<div style=\"border:1px solid #c7d0d5; border-radius:15px;\">";
		$myIndexSocial->IndexSocialToHTML();
		echo "</div>";
		global $sinf;

		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();
		$connection2 = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
		if ($connection2 -> connect_error)
			echo "Database'e bağlantı sorunu";
		else
		{
			$connection2->set_charset("utf8");
			echo "<div style=\"border:1px solid #c7d0d5;border-radius:15px;margin-top:3%;overflow:auto;height:100%;width:100%;max-width:100%;background-color:#e6e6e6;\">";
				echo "<div style=\"margin-top:5%;text-align:left;margin-right:5%;margin-left:5%;font-size:19px;font-family: 'Josefin Sans', sans-serif;color:#cb7c7a\">";
					echo "<p style=\"word-wrap:break-word;text-align:left;width:80%;max-width:80%;\">";
						echo "İlginizi çekebilecek başlıklar";
					echo "</p>";				
					echo "<hr style=\"border:1px solid #c7d0d5;\"/>";
				echo "</div>";
				$quelloThreddo = $connection2->real_escape_string($sinf['quelleThread']);
			$sugQuery = "SELECT * FROM threads WHERE threadCategory =\"".$sinf['quelleCategorie']."\" AND threadName<>\"".$quelloThreddo."\" ORDER BY RAND() LIMIT 30";
			$results2 = $connection2 -> query ($sugQuery);
			while ($curResult2 = $results2 -> fetch_assoc())
			{
				$threadID2 = $curResult2 ["threadID"];
				$threadDate2 = $curResult2["threadDate"];
				$threadWriter2 = $curResult2["threadWriter"];
				$threadCategory2 = $curResult2["threadCategory"];
				$threadPicture2 = $curResult2["threadPicture"];
				$stepCount2 = $curResult2["stepCount"];
				$threadName2 = $curResult2["threadName"];
				$threadPoint2 = $curResult2["threadPoint"];
				
				$myThread2 = new Thread(array($threadID2,$threadDate2,$threadWriter2,$threadCategory2,$threadPicture2,$stepCount2,$threadName2,$threadPoint2));
				$myThread2-> ThreadToPetitHTML();
			}
			$sugQuery = "SELECT * FROM threads WHERE threadCategory <>\"".$sinf['quelleCategorie']."\" AND threadName<>\"".$quelloThreddo."\" ORDER BY RAND() LIMIT 10";
			$results2 = $connection2 -> query ($sugQuery);
			while ($curResult2 = $results2 -> fetch_assoc())
			{
				$threadID2 = $curResult2 ["threadID"];
				$threadDate2 = $curResult2["threadDate"];
				$threadWriter2 = $curResult2["threadWriter"];
				$threadCategory2 = $curResult2["threadCategory"];
				$threadPicture2 = $curResult2["threadPicture"];
				$stepCount2 = $curResult2["stepCount"];
				$threadName2 = $curResult2["threadName"];
				$threadPoint2 = $curResult2["threadPoint"];
				
				$myThread2 = new Thread(array($threadID2,$threadDate2,$threadWriter2,$threadCategory2,$threadPicture2,$stepCount2,$threadName2,$threadPoint2));
				$myThread2-> ThreadToPetitHTML();
			}
			echo "</div>";
			$connection2->close();
			
		}
	}
	
}

?>
