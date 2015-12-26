<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
class Recent
{

public function Recent()
{

}

public function Top10 ()
{
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		return false;
	else{
	$connection->set_charset("utf8");
	echo "<div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\" style=\"height:450px;\">";
		echo "<ol class=\"carousel-indicators\" style=\"bottom:0;\">";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"0\" class=\"active\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"1\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"2\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"3\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"4\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"5\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"6\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"7\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"8\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"9\"></li>";
		echo "</ol>";
		echo "<div class=\"carousel-inner\" role=\"listbox\">";
			$res = $connection->query ("SELECT * FROM threads ORDER BY threadID DESC LIMIT 10 ") ;
			for ($i=0;$i<$res->num_rows;$i++)
			{
				$curres = $res->fetch_assoc();
				if ($i==0)
				{
					echo "<div class=\"item active\" >";
						echo "<img src=\"".$curres["threadPicture"]."\" alt=\"resim\" style=\"margin:0 auto;max-height:450px;\"/>";
						echo "<div class=\"carousel-caption\" style=\"left:0;right:0;bottom:0;background:rgba(50,50,50,0.5);\">";
							echo "<a style=\"\" href=\"thread.php?id=".$curres["threadID"]."\" class=\"btn btn-success\" title=\"Başlığı görüntüle\">";
								echo "<i class=\"fa fa-eye\"></i>";
							echo "</a>";
							echo "<h3 style=\"font-family: 'Josefin Sans', sans-serif;font-size:20px;\">".$curres["threadName"]."</h3>";
						echo "</div>";
					echo "</div>";
				}
				else
				{
					echo "<div class=\"item\" >";
						echo "<img src=\"".$curres["threadPicture"]."\" alt=\"resim\" style=\"margin:0 auto;max-height:450px;\"/>";
						echo "<div class=\"carousel-caption\" style=\"left:0;right:0;bottom:0;background:rgba(50,50,50,0.5);\">";
							echo "<a style=\"\" href=\"thread.php?id=".$curres["threadID"]."\" class=\"btn btn-success\" title=\"Başlığı görüntüle\">";
								echo "<i class=\"fa fa-eye\"></i>";
							echo "</a>";
							echo "<h3 style=\"font-family: 'Josefin Sans', sans-serif;font-size:20px;\">".$curres["threadName"]."</h3>";
						echo "</div>";
					echo "</div>";
				}
			}	
		echo "</div>";
		echo "<a class=\"left carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"prev\">";
			echo "<span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>";
			echo "<span class=\"sr-only\">Previous</span>";
		echo "</a>";
		echo "<a class=\"right carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"next\">";
			echo "<span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>";
			echo "<span class=\"sr-only\">Next</span>";
		echo "</a>";
	echo "</div>";
	$connection->close();
	}
}

public function DigerSahane()
{
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	if (!$connection->connect_error)
	{
		$connection->set_charset("utf8");
		$results = $connection->query("SELECT * FROM threads ORDER BY threadID DESC LIMIT 8 OFFSET 10 ");
		while ($curres = $results -> fetch_assoc())
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
		echo "<div id=\"moreBestDiv\"></div>";
		echo "<div style=\"margin:2%;\">";
			echo "<form id=\"loadMoreBestForm\" method=\"post\" action=\"loadMoreRecent.php\">";
				echo "<input id=\"loadMoreBestOffset\" name=\"loadMoreBestOffset\" style=\"display:none;\" value=\"".$results->num_rows."\"/>";
				echo "<button id=\"loadMoreBestButton\" class=\"btn btn-block btn-success\">";
					echo "<i id=\"loadMoreBestSpinner\" style=\"display:none;\" class=\"fa fa-refresh fa-spin\"></i>";
					echo "<span id=\"loadMoreBestTXT\">";
						echo "Daha fazla göster";
					echo "</span>";
				echo "</button>";
			echo "</form>";
		echo "</div>";
	}
}

public function RecentToHTML()
{	
	echo "<div style=\"border:1px solid #c7d0d5;border-radius:15px;background-color:#e6e6e6;\">";
		echo "<div style=\"margin:2%;border-bottom:1px solid #c7d0d5;\">";
			echo "<p style=\"color:#ec583a;word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:20px;\">";
				echo "En yeni 10 içerik";
			echo "</p>";
		echo "</div>";
		echo "<div style=\"margin:2%;\">";
			$this->Top10();
		echo "</div>";	
		echo "<div style=\"margin:2%;border-bottom:1px solid #c7d0d5;\">";
			echo "<p style=\"color:#ec583a;word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:20px;\">";
				echo "Diğer yeni içerikler";
			echo "</p>";	
		echo "</div>";
		echo "<div style=\"margin-top:2%;width:100%;\">";
			$this->DigerSahane();
		echo "</div>";
	echo "</div>";

	echo "<script type=\"text/javascript\">";
		echo "
			$('#loadMoreBestButton').click(function(e){
				e.preventDefault();
				$('#loadMoreBestTXT').hide();
				$('#loadMoreBestSpinner').show();
				$('#loadMoreBestForm').ajaxForm({
					success : function(msg){
						$('#loadMoreBestTXT').show();
						$('#loadMoreBestSpinner').hide();
						newoffset = msg.charAt(0);
						oldoffset = $('#loadMoreBestOffset').val();
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#loadMoreBestTXT').html(\"Hepsi yüklendi\");
							$('#loadMoreBestButton').attr(\"disabled\",true);
						}
						$('#loadMoreBestOffset').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#moreBestDiv').append(msg2);
					},
					error : function(){

					}
				}).submit();
			});	
		";
	echo "</script>";
}

}

?>
