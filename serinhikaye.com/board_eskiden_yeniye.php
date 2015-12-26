<?php	
include_once("classes/DBConnector.class.php");
include_once("classes/BoardContribution.class.php");
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	$connection->set_charset("utf8");
	
	$query = "SELECT * FROM contributions WHERE boardID=\"".$_GET["id"]."\" AND contributionID<>\"ereased\" ORDER BY contributionDate ASC LIMIT 10";
	
	$results = $connection->query($query);
	echo "<div style=\"\" id=\"eskiden_yeniye\">";
	while($curResult = $results->fetch_assoc())
	{
		if ($curResult['contributionID']!=="ereased"){
		$myBoardContribution = new BoardContribution(array($curResult['boardID'],$curResult['contributionID'],$curResult['contributor'],$curResult['contributionDate'],$curResult['contributionPoint'],$curResult['contributionExplanation'],$curResult['contributionImage']));
		$myBoardContribution->BoardContributionToHTML();
		}	
	}	
	echo "<div id=\"eskiden_yeniye_append\"></div>";
	echo "<div style=\"margin-top:2%;\">";
		echo "<button id=\"eskiden_yeniye_button\" class=\"btn btn-block btn-success\">Daha fazla göster</button>";
	echo "</div>";
	echo "<form id=\"eskiden_yeniye_form\" method=\"post\" action=\"boardLoadMore.php?id=".$_GET["id"]."&mode=eskiden_yeniye\">";
		echo "<input id=\"eskiden_yeniye_offset\" style=\"display:none;\" type=\"text\" name=\"eskiden_yeniye_offset\" value=\"".$results->num_rows."\" />";
	echo "</form>";
	echo "</div>";

	echo "<script>";
		echo "
			$('#eskiden_yeniye_button').click(function(e){
				e.preventDefault();
				$('#eskiden_yeniye_button').attr(\"disabled\",true);
				$('#eskiden_yeniye_form').ajaxForm({
					success : function(msg){		
						$('#eskiden_yeniye_button').attr(\"disabled\",false);
						newoffset = msg.charAt(0);
						oldoffset = $('#eskiden_yeniye_offset').val();
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#eskiden_yeniye_button').html(\"Hepsi yüklendi\");
							$('#eskiden_yeniye_button').attr(\"disabled\",true);
						}
						$('#eskiden_yeniye_offset').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#eskiden_yeniye_append').append(msg2);
					},
					error : function(){
						alert(\"Bir hata oldu.\");
					}
				}).submit();
			});
		";
	echo "</script>";

?>
