<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
include_once("classes/Board.class.php");
class IndexGuncel
{

public function IndexGuncel()
{

}

public function IndexGuncelToHTML()
{

	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	$connection->set_charset("utf8");

echo "<div style=\"margin:2%;background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";

	echo "<p style=\"font-size:20px;word-wrap:break-word;color:#cb7c7a;font-family: 'Josefin Sans', sans-serif;\">";
		echo "Güncel panolar";
	echo "</p>";

echo "</div>";

echo "<div style=\"\">";
	$results = $connection->query("SELECT * FROM boards ORDER BY boardID DESC LIMIT 6 OFFSET 0");
	while ($boardInfos = $results->fetch_assoc())
	{
		$myBoard = new Board(array($boardInfos['boardID'],$boardInfos['boardName'],$boardInfos['boardCategory'],$boardInfos['boardCreator'],$boardInfos['boardImage'],$boardInfos['boardDate']));	
		$myBoard->BoardToPetitHTML();
		
	}
echo "</div>";

echo "<div id=\"x\" style=\"margin:2%;background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";

	echo "<p style=\"font-size:20px;word-wrap:break-word;color:#cb7c7a;font-family: 'Josefin Sans', sans-serif;\">";
		echo "Güncel içerikler";
	echo "</p>";

echo "</div>";

echo "<div style=\"\">";

	
	if (!$connection->connect_error)
	{
		
		$results = $connection->query("SELECT * FROM threads ORDER BY threadID DESC LIMIT 12 OFFSET 0 ");
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
		echo "<div style=\"\">";
			echo "<form id=\"loadMoreBestForm\" method=\"post\" action=\"loadMoreRecentIndex.php\">";
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

echo "</div>";
            

	echo "<script type=\"text/javascript\">";
		echo "
			$(window).scroll(function(){
				var p = $('#x');
				var pos = p.position();
				var windowpos = $(window).scrollTop();
				if (windowpos >= pos.top) {
					$('#indexStickyFooter').fadeIn(500);
				}
				else
					$('#indexStickyFooter').fadeOut(500);
			});
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
