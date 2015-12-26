<?php

include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");

$cat = $_GET["cat"];

if ($cat == "si")
	$cat = "Sosyal ilişkiler";
	
$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection -> connect_error)
	echo "Bağlantı hatası.";
else
{

	$connection->set_charset("utf8");
	$query = "SELECT * from threads WHERE threadCategory=\"".$cat."\" ORDER BY threadPoint DESC LIMIT 8";
	$results = $connection->query($query);
	$offset = $results->num_rows;	

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
	echo "<div id=\"categoryPuanaGoreSiralaMoreDataDIV\"></div>";
	echo "<div style=\"margin:2%;\">";
		echo "<form id=\"categoryPuanaGoreSiralaForm\" method=\"post\" action=\"categoryPuanaGoreSiralaLoadMore.php?cat=".$cat."\">";
			echo "<input style=\"display:none;\" type=\"text\" id=\"categoryPuanaGoreSiralaOffset\" name=\"categoryPuanaGoreSiralaOffset\" value=\"".$offset."\"/>";
			echo "<button id=\"categoryPuanaGoreSiralaButton\" class=\"btn btn-block btn-success\"><i id=\"categoryPuanaGoreSiralaSpinner\" style=\"display:none;\" class=\"fa fa-refresh fa-spin\"></i><span id=\"categoryPuanaGoreSiralaTXT\">Daha fazla göster</span></button>";
		echo "</form>";	
	echo "</div>";
	
	echo "<script type=\"text/javascript\">";
		echo "
			$('#categoryPuanaGoreSiralaButton').click(function(e){
				e.preventDefault();
				$('#categoryPuanaGoreSiralaTXT').hide();
				$('#categoryPuanaGoreSiralaSpinner').show();
				$('#categoryPuanaGoreSiralaForm').ajaxForm({
					success : function(msg)
					{
						$('#categoryPuanaGoreSiralaTXT').show();
						$('#categoryPuanaGoreSiralaSpinner').hide();
						oldoffset = $('#categoryPuanaGoreSiralaOffset').val();
						newoffset = msg.charAt(0);
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#categoryPuanaGoreSiralaTXT').html('Hepsi yüklendi');
							$('#categoryPuanaGoreSiralaButton').attr(\"disabled\", true);
						}
						$('#categoryPuanaGoreSiralaOffset').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#categoryPuanaGoreSiralaMoreDataDIV').append(msg2);
					},
					error : function()
					{
						
					}
				}).submit();
			});
		";
	echo "</script>";
}

?>
