<?php

include_once("classes/DBConnector.class.php");

class YazarBasliklari
{
	var $yazarAdi;

	public function YazarBasliklari($writer)
	{
		global $yazarAdi;
		$yazarAdi = $writer;
	}

	public function YazarBasliklariToHTML()
	{
		global $yazarAdi;

		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();

		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
		if ($connection -> connect_error)
			echo "Database'e bağlantı sorunu";
		else
		{
			$connection->set_charset("utf8");
			echo "<div style=\"overflow:auto;border:1px solid #c7d0d5;border-radius:15px;background-color:#e6e6e6;width:100%;margin-top:4%;font-size:19px;font-family: 'Josefin Sans', sans-serif;color:#cb7c7a;max-width:100%;\">";
				echo "<div style=\"margin-top:5%;text-align:left;margin-right:5%;margin-left:5%;font-size:19px;font-family: 'Josefin Sans', sans-serif;color:#cb7c7a;\">";
					echo "<p style=\"word-wrap:break-word;text-align:left;width:80%;max-width:80%;\">";
						echo "Aynı yazardan bazı süper başlıklar";
					echo "</p>";				
					echo "<hr style=\"border:1px solid #c7d0d5;\"/>";
				echo "</div>";
			$res = $connection -> query ("SELECT * from threads where threadWriter='$yazarAdi' ORDER BY threadPoint LIMIT 10");
			while ($curres = $res -> fetch_assoc())
			{
				$threadID5 = $curres ["threadID"];
				$threadDate5 = $curres["threadDate"];
				$threadWriter5 = $curres["threadWriter"];
				$threadCategory5 = $curres["threadCategory"];
				$threadPicture5 = $curres["threadPicture"];
				$stepCount5 = $curres["stepCount"];
				$threadName5 = $curres["threadName"];
				$threadPoint5 = $curres["threadPoint"];
				
				$myThread5 = new Thread(array($threadID5,$threadDate5,$threadWriter5,$threadCategory5,$threadPicture5,$stepCount5,$threadName5,$threadPoint5));  
						$myThread5-> ThreadToPetitHTML();
			}
			echo "</div>";
			$connection->close();
		}
	}
}

?>