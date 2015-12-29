<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
class Search
{

var $query;

public function Search($querro)
{

global $query;
$query = $querro;

}

public function SearchToHTML()
{

global $query;
$query = htmlspecialchars($query);
$myDBConnector = new DBConnector();

$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

echo "<div style=\"background-color:#e6e6e6;border:1px solid #c7d0d5; border-radius:15px;\">";
	echo "<div style=\"margin:2%;\">";
		echo "<p style=\"color:#ec583a;word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:20px;\">";
			echo "\"".$query."\" için arama sonuçları";
		echo "</p>";
	echo "</div>";
	echo "<ul class=\"nav nav-tabs\" style=\"margin:2%;font-family: 'Josefin Sans', sans-serif;font-size:17px;\">";
		echo "<li class=\"active\"><a href=\"#\" id=\"searchThreadsLink\" data-toggle=\"tab\">Başlıklar</a></li>";
		echo "<li class=\"\"><a href=\"#\" id=\"searchWritersLink\" data-toggle=\"tab\">Yazarlar</a></li>";
	echo "</ul>";
	echo "<div class=\"tab-content\">";
		echo"<div class=\"tab-pane-active\" id=\"searchThreadsDIV\">";
		echo "<div style=\"\">";
		if ($connection -> connect_error)
			echo "Database'e bağlantı sorunu";
		else
		{
			$connection->set_charset("utf8");
			$searchQuery = "SELECT * FROM threads WHERE threadName LIKE '%$query%' ORDER BY threadPoint desc LIMIT 8";
			$results = $connection->query($searchQuery);
			$offsetCount = $results->num_rows;
			if ($offsetCount==0)
				echo "<div style=\"margin:2%;\"><p style=\"color:#6e6e6e;word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:17px;\"> Böyle bir başlık bulunamadı. </p></div>";
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
			echo "<div id=\"searchMoreThreadMoreDataDiv\"></div>";
			if ($offsetCount<>0){
			echo "<div style=\"margin:2%;\">";
				echo "<form id=\"searchMoreThreadForm\" action=\"searchMoreThread.php?query=".$query."\" method=\"post\">";
					echo "<input style=\"display:none;\" name=\"showMoreSuggestionOffset\" id=\"showMoreSuggestionOffset\" value=\"".$offsetCount."\"/>";
					echo "<button id=\"showMoreSuggestionButton\" class=\"btn btn-block btn-success\"><i id=\"searchMoreThreadSpinner\" style=\"display:none;\" class=\"fa fa-refresh fa-spin\"></i><span id=\"searchMoreThreadTXT\"> Daha fazla göster </span> </button>";
				echo "</form>";
			echo "</div>";
			}
		}
	echo "</div>";
		echo "</div>";
		echo"<div class=\"tab-pane\" id=\"searchWritersDIV\">";
			echo "<div style=\"margin:2%;\">";
				$searchWriterQuery = "SELECT * FROM users WHERE userName LIKE '%$query%'";	
				$writerresults = $connection->query($searchWriterQuery);
				while ($wcurres = $writerresults -> fetch_assoc())
				{
					echo "<p style=\";word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<a href=\"user.php?name=".$wcurres["userName"]."\">".$wcurres["userName"]."</a>";
					echo "</p>";
				}
				if ($writerresults->num_rows==0)
					echo "<p style=\"color:#6e6e6e;word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:17px;\"> Böyle bir yazar bulunamadı.</p>";
			echo "</div>";
		echo "</div>";
	echo "</div>";

echo "</div>";

echo "<script type=\"text/javascript\">";
	echo "
		$('#searchThreadsLink').click(function(){
			$('#searchWritersDIV').attr('class','tab-pane');
			$('#searchThreadsDIV').attr('class','tab-pane-active');
		});
		$('#searchWritersLink').click(function(){
			$('#searchThreadsDIV').attr('class','tab-pane');
			$('#searchWritersDIV').attr('class','tab-pane-active');
		});
		$('#showMoreSuggestionButton').click(function(e){
			e.preventDefault();
			$('#searchMoreThreadTXT').hide();
			$('#searchMoreThreadSpinner').show();
			$('#searchMoreThreadForm').ajaxForm({
				success : function(msg){
					$('#searchMoreThreadSpinner').hide();
					$('#searchMoreThreadTXT').show();
					oldoffset = $('#showMoreSuggestionOffset').val();
					newoffset = msg.charAt(0);
					oldint = parseInt(oldoffset);
					newint = parseInt(newoffset);
					if (newint==0)
					{
						$('#searchMoreThreadTXT').html('Hepsi yüklendi');
						$('#showMoreSuggestionButton').attr(\"disabled\", true);
					}
					$('#showMoreSuggestionOffset').val(oldint+newint);
					msg2 = msg.substring(1);
					$('#searchMoreThreadMoreDataDiv').append(msg2);
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