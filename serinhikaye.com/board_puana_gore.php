<?php
include_once("classes/DBConnector.class.php");
include_once("classes/BoardContribution.class.php");
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	$connection->set_charset("utf8");
	
	$query = "SELECT * FROM contributions WHERE boardID=\"".$_GET["id"]."\" AND contributionID<>\"ereased\" ORDER BY contributionPoint DESC LIMIT 10";
	
	$results = $connection->query($query);
	echo "<div id=\"puana_gore\">";
	while($curResult = $results->fetch_assoc())
	{
		if ($curResult['contributionID']!=="ereased"){
		$myBoardContribution = new BoardContribution(array($curResult['boardID'],$curResult['contributionID'],$curResult['contributor'],$curResult['contributionDate'],$curResult['contributionPoint'],$curResult['contributionExplanation'],$curResult['contributionImage']));
		$myBoardContribution->BoardContributionToHTML();
		}	
	}
	echo "<div id=\"puana_gore_append\"></div>";
	echo "<div style=\"margin-top:2%;\">";
		echo "<button id=\"puana_gore_button\" class=\"btn btn-block btn-success\">Daha fazla göster</button>";
	echo "</div>";	
	echo "<form id=\"puana_gore_form\" method=\"post\" action=\"boardLoadMore.php?id=".$_GET["id"]."&mode=puana_gore\">";
		echo "<input id=\"puana_gore_offset\" style=\"display:none;\" type=\"text\" name=\"puana_gore_offset\" value=\"".$results->num_rows."\" />";
	echo "</form>";
	echo "</div>";

	echo "<script>";
		echo "
			$('#puana_gore_button').click(function(e){
				e.preventDefault();
				$('#puana_gore_button').attr(\"disabled\",true);
				$('#puana_gore_form').ajaxForm({
					success : function(msg){
						$('#puana_gore_button').attr(\"disabled\",false);
						newoffset = msg.charAt(0);
						oldoffset = $('#puana_gore_offset').val();
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#puana_gore_button').html(\"Hepsi yüklendi\");
							$('#puana_gore_button').attr(\"disabled\",true);
						}
						$('#puana_gore_offset').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#puana_gore_append').append(msg2);
						
					},
					error : function(){
						alert(\"Bir hata oldu.\");
					}
				}).submit();
			});

		";
	echo "</script>";

?>
