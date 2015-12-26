<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
class UserFavs
{

var  $whichUsr;

public function UserFavs($which)
{
	global $whichUsr;
	$whichUsr = $which;
}

public function UserFavsToHTML()
{
	global $whichUsr;
	echo "<div style=\"margin-top:2%;\">";
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection -> connect_error)
		echo "Database'e bağlantı sorunu";
	else
	{
		$connection->set_charset("utf8");
		$query = "SELECT * FROM favoriler NATURAL JOIN threads WHERE userName='$whichUsr' ORDER BY `threadPoint` DESC LIMIT 6 ";
		$results = $connection->query($query);
		$totalCount = $results->num_rows;
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
		$connection->close();
		echo "<div id=\"moreFavsDiv\">";
		echo "</div>";

		echo "<div style=\"margin:2%;\">";
			if ($totalCount!=0)
			{
				echo "<form id=\"loadMoreFavsForm\" method=\"post\" action=\"loadMoreFavs.php?usr=".$whichUsr."\">";
					echo "<input style=\"display:none;\"  id=\"loadMoreFavsOffset\" name=\"loadMoreFavsOffset\" value=\"".$totalCount."\"/>";
					echo "<button id=\"loadMoreFavsButton\" class=\"btn btn-block btn-success\">";
						echo "<i id=\"loadMoreFavsSpinner\" style=\"display:none;\" class=\"fa fa-refresh fa-spin\"></i>";
						echo "<span id=\"loadMoreFavsTXT\"> Daha fazla göster </span>";
					echo "</button>";
				echo "</form>";
			}
			else
				echo "<span style=\"font-family: Verdana,Geneva,sans-serif;font-size:18px;color:#6e6e6e;\"> Bu yazar henüz bir içerik favorilememiş. </span>";	
		echo "</div>";
	}
	echo "</div>";

	echo "<script type=\"text/javascript\">";
		echo "
			$('#loadMoreFavsButton').click(function(e){
				e.preventDefault();
				$('#loadMoreFavsTXT').hide();
				$('#loadMoreFavsSpinner').show();
				$('#loadMoreFavsForm').ajaxForm({
					success : function(msg){
						$('#loadMoreFavsTXT').show();
						$('#loadMoreFavsSpinner').hide();
						newoffset = msg.charAt(0);
						oldoffset = $('#loadMoreFavsOffset').val();
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#loadMoreFavsTXT').html(\"Hepsi yüklendi\");
							$('#loadMoreFavsButton').attr(\"disabled\",true);
						}
						$('#loadMoreFavsOffset').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#moreFavsDiv').append(msg2);
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
