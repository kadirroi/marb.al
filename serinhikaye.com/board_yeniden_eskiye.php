<?php	
include_once("classes/DBConnector.class.php");
include_once("classes/BoardContribution.class.php");
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	$connection->set_charset("utf8");
	
	$query = "SELECT * FROM contributions WHERE boardID=\"".$_GET["id"]."\" AND contributionID<>\"ereased\" ORDER BY contributionDate DESC LIMIT 10";
	
	$results = $connection->query($query);
	echo "<div style=\"\" id=\"yeniden_eskiye\">";
	while($curResult = $results->fetch_assoc())
	{
		if ($curResult['contributionID']!=="ereased"){
		$myBoardContribution = new BoardContribution(array($curResult['boardID'],$curResult['contributionID'],$curResult['contributor'],$curResult['contributionDate'],$curResult['contributionPoint'],$curResult['contributionExplanation'],$curResult['contributionImage']));
		$myBoardContribution->BoardContributionToHTML();
		}	
	}	
	echo "<div id=\"yeniden_eskiye_append\"></div>";
	echo "<div style=\"margin-top:2%;\">";
		echo "<button id=\"yeniden_eskiye_button\" class=\"btn btn-block btn-success\">Daha fazla göster</button>";
	echo "</div>";
	echo "<form id=\"yeniden_eskiye_form\" method=\"post\" action=\"boardLoadMore.php?id=".$_GET["id"]."&mode=yeniden_eskiye\">";
		echo "<input id=\"yeniden_eskiye_offset\" style=\"display:none;\" type=\"text\" name=\"yeniden_eskiye_offset\" value=\"".$results->num_rows."\" />";
	echo "</form>";
	echo "</div>";
	
	echo "<script>";
		echo "
			$('#yeniden_eskiye_button').click(function(e){
				e.preventDefault();
				$('#yeniden_eskiye_button').attr(\"disabled\",true);
				$('#yeniden_eskiye_form').ajaxForm({
					success : function(msg){
						$('#yeniden_eskiye_button').attr(\"disabled\",false);
						newoffset = msg.charAt(0);
						oldoffset = $('#yeniden_eskiye_offset').val();
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#yeniden_eskiye_button').html(\"Hepsi yüklendi\");
							$('#yeniden_eskiye_button').attr(\"disabled\",true);
						}
						$('#yeniden_eskiye_offset').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#yeniden_eskiye_append').append(msg2);
					},
					error : function(){
						alert(\"Bir hata oldu.\");
					}
				}).submit();
			});
		";
	echo "</script>";

?>
