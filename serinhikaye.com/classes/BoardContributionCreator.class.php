<?php
session_start();

include_once("classes/DBConnector.class.php");
class BoardContributionCreator
{

var $boardContributionCreatorInfos = array ();

public function BoardContributionCreator($ary)
{
	global $boardContributionCreatorInfos;
	
	$boardContributionCreatorInfos['boardID'] = $ary[0];
}

public function findAvailableBoardContributionID()
{
	global $boardContributionCreatorInfos;
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		return "CONNECT_ERR";
	else
	{
		$query = "SELECT * FROM contributions WHERE boardID=\"".$boardContributionCreatorInfos['boardID']."\" ";
		$results = $connection->query($query);
		return 1+$results->num_rows;
	}
}

public function BoardContributionCreatorToHTML()
{

	global $boardContributionCreatorInfos;
	
	if ($availableID!=="CONNECT_ERR")
	{
		echo "<div style=\"padding-top:2%;padding-bottom:2%;margin-top:2%;background-color:#fafae1;width: 100%; max-width:100%;\">";
			echo "<div style=\"margin-left:8%;\">";
				echo "<p style=\"color:#cb7c7a;word-wrap:break-word;text-align:left;font-size:22px;font-family: 'Josefin Sans', sans-serif;\">";
					echo "Bu panoya katkı yap";
				echo "</p>";
			echo "</div>";
			echo "<div style=\"margin-left:8%;margin-top:2%;\">";
			echo "<form id=\"contributionForm\" method=\"post\" action=\"contribute.php?contributor=".$_SESSION["user_name"]."&boardID=".$boardContributionCreatorInfos['boardID']."\" enctype=\"multipart/form-data\">";
			echo "<div style=\"overflow:hidden;max-width:80%;\">";
			echo "<input type=\"file\" class=\"file btn-info\" title=\"Resim Seç\" name=\"imagefile\" data-filename-placement=\"inside\" />";
			echo "</div>";
			echo "<div style=\"margin-top:2%;max-width:80%;\">";
				echo "<textarea name=\"contributionText\" id=\"contributionText\" style=\"font-family:'Josefin Sans',sans-serif;font-size:18px;\" placeholder=\"Resimle ilgili bir açıklama yapın\" class=\"form-control\"  spellcheck=\"false\" style=\"\" maxlength=\"1000\" rows=\"3\" cols=\"10\" ></textarea>";
			echo "</div>";
			echo "<div style=\"margin-top:2%;max-width:80%;\">";
				if (isset($_SESSION["user_name"])){
				
				echo "<input type=\"text\" style=\"display:none;\" name=\"contributionID\" value=\"".$this->findAvailableBoardContributionID()."\" />";
				echo "<button id=\"contributionWithSession\" class=\"btn btn-success\">";
				}				
				else
				echo "<button id=\"contributionWithoutSession\" class=\"btn btn-success\">";
					echo "Gönder";
				echo "</button>";
			echo "</div>";
			echo "</form>";
			echo "</div>";
		echo "</div>";
	}
	echo "<script>";
		echo "
			$('input[type=file]').bootstrapFileInput();
			$('.file-inputs').bootstrapFileInput();
			$('#contributionWithoutSession').click(function(e){
				e.preventDefault();
				$('#signup_modal_div').modal(\"toggle\");
			});
			$('#contributionWithSession').click(function(e){
				e.preventDefault();
				$('#contributionWithSession').attr(\"disabled\", true);
				if ($('#contributionText').val()=='')
					alert(\"Resminiz için bir açıklama girmeniz gerekiyor.\");
				else
					$('#contributionForm').ajaxForm({
						success : function(msg){
							status = msg.substring(0,1);
							mesaj = msg.substring(1);
							if (status==1)
							{
								location.reload();
							}
							else{
								$('#contributionWithSession').attr(\"disabled\", false);
								alert(mesaj);
							}
						},
						error : function(){
							alert(\"Bir sorun oldu ve resminizi yükleyemedik.\");
						}
					}).submit();
			});
		";
	echo "</script>";
}

}

?>
