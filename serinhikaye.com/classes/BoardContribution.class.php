<?php

session_start();

class BoardContribution
{

var $boardContributionInfos = array();

public function BoardContribution($ary)
{
	global $boardContributionInfos;
	
	$boardContributionInfos['boardID'] = $ary[0];
	$boardContributionInfos['contributionID'] = $ary[1];
	$boardContributionInfos['contributor'] = $ary[2];
	$boardContributionInfos['contributionDate'] = $ary[3];
	$boardContributionInfos['contributionPoint']  = $ary[4];
	$boardContributionInfos['contributionExplanation'] = $ary[5];
	$boardContributionInfos['contributionImage'] = $ary[6];
	
}

public function BoardContributionToHTML()
{
	global $boardContributionInfos;

	echo "<div style=\"padding-top:2%;padding-bottom:2%;margin-top:2%;border:1px solid #c7d0d5;border-radius:15px;background-color:#e6e6e6;width: 100%; max-width:100%;\">";
		echo "<div style=\"margin-left:8%;\">";
			echo "<p style=\"margin-left:1%;color:#cb7c7a;word-wrap:break-word;text-align:left;font-size:45px;font-family: 'Amatic SC', cursive;\">";
				echo "# ".$boardContributionInfos['contributionID'];
			echo "</p>";
		echo "</div>";
		echo "<div id=\"pic_div\" style=\"border:1px solid #c7d0d5;margin-left:8%;max-width:85%;\" class=\"thumbnailx\">";
			echo "<div style=\"padding-top:1%;padding-bottom:1%;\" class=\"caption-btmx\">";	
			echo "<p style=\"margin-left:1%;color:#cb7c7a;word-wrap:break-word;text-align:left;font-size:30px;font-family: 'Josefin Sans', sans-serif;\">";
				echo "<span id=\"contributionPoint_".$boardContributionInfos['contributionID']."\">".$boardContributionInfos['contributionPoint']."</span> ";
				echo "<i class=\"fa fa-heart\"></i>";
			echo "</p>";
			echo "</div>";
			echo "<a class=\"fancybox\" href=\"".$boardContributionInfos['contributionImage']."\">";
			echo "<img src=\"".$boardContributionInfos['contributionImage']."\" style=\"max-width:100%;\">";
			echo "</a>";
		echo "</div>";
		echo "<div style=\"margin-left:8%;padding-top:1%;\">";
			echo "<p style=\"max-width:85%;color:#6e6e6e;text-align:left;font-size:23px;font-family: 'Josefin Sans', sans-serif;word-wrap:break-word;\">";
				echo nl2br(htmlspecialchars($boardContributionInfos['contributionExplanation']));
			echo "</p>";
		echo "</div>";
		echo "<div style=\"color:#6e6e6e;margin-left:8%;\">";
			echo "<i><p style=\”max-width:85%;word-wrap:break-word;text-align:left;font-size:18px;font-family: 'Josefin Sans', sans-serif;\">";
				echo "<a href=\"http://serinhikaye.com/user.php?name=".$boardContributionInfos['contributor']."\">".$boardContributionInfos['contributor']."</a> paylaştı.";
			echo "</p></i>";
		echo "</div>";
		echo "<div style=\"padding-top:1%;margin-left:8%;\">";
				echo "<button id=\"fbdb_".$boardContributionInfos['contributionID']."\" title=\"Facebook'da paylaş\" style=\"\" class=\"btn btn-facebook\"><i class=\"fa fa-facebook\"></i></button>";
				echo "<button id=\"twttwt_".$boardContributionInfos['contributionID']."\" title=\"Twitter'da paylaş\" style=\"margin-left:1%;\" class=\"btn btn-twitter\"><i class=\"fa fa-twitter\"></i></button>";
				echo "<a href=\"".$boardContributionInfos['contributionImage']."\" title=\"Resmi geniş görüntüle\" style=\"margin-left:1%;\" class=\"fancybox btn btn-success\"><i class=\"fa fa-expand\"></i></a>";
				echo "<button id=\"contributionLikerButton_".$boardContributionInfos['contributionID']."\" title=\"Beğen\" style=\"margin-left:1%;\" class=\"btn btn-danger\"><i class=\"fa fa-heart\"></i></button>";
				if (isset($_SESSION["user_name"]))
					if ($_SESSION["user_name"]==$boardContributionInfos['contributor'])
					{
						echo "<button id=\"contributionEreaserButton_".$boardContributionInfos['contributionID']."\" style=\"margin-left:1%;\" title=\"Bu gönderini sil\" class=\"btn btn-warning\">";
							echo "<i class=\"fa fa-trash\"></i>";
						echo "</button>";
					}
		echo "</div>";
		echo "<form id=\"contributionLikerForm_".$boardContributionInfos['contributionID']."\" method=\"post\" action=\"contributionLiker.php?cID=".$boardContributionInfos['contributionID']."&bID=".$boardContributionInfos['boardID']."\"></form>";
		echo "<form id=\"contributionEreaserForm_".$boardContributionInfos['contributionID']."\" method=\"post\" action=\"contributionEreaser.php?cID=".$boardContributionInfos['contributionID']."&bID=".$boardContributionInfos['boardID']."\"></form>";
	echo "</div>";

	echo "<script>";

		echo "



			$('#contributionLikerButton_".$boardContributionInfos['contributionID']."').click(function(e){
				e.preventDefault();
				$('#contributionLikerForm_".$boardContributionInfos['contributionID']."').ajaxForm({
					success : function(msg){
						$('#contributionPoint_".$boardContributionInfos['contributionID']."').html(msg);
						$('#contributionLikerButton_".$boardContributionInfos['contributionID']."').attr('disabled',true);
					},	
					error : function(){
						alert(\"Bir hata oldu ve oyunuzu kaydedemedik.\");
					}			
				}).submit();
			});
			$('#contributionEreaserButton_".$boardContributionInfos['contributionID']."').click(function(e){
				e.preventDefault();
				 $('#contributionEreaserForm_".$boardContributionInfos['contributionID']."').ajaxForm({
					success : function(msg){
						location.reload();
					},
					error : function(){
						alert(\"Bir hata oldu.\");
					}
				}).submit();
			});
			$('#fbdb_".$boardContributionInfos['contributionID']."').click(function(){
					var x=$(document).find(\"title\").text();
					FB.ui({
  					method: 'feed',
  					link: 'http://serinhikaye.com/board.php?id=".$boardContributionInfos['boardID']."',
  					caption: '',
					picture: 'http://serinhikaye.com/".$boardContributionInfos['contributionImage']."',
					name: ''+x
					}, function(response){});
			});
		";
	echo "</script>";
	
}

}

?>
