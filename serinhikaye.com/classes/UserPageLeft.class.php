<?php
session_start();
include_once("ToplamPuanHesaplayici.class.php");

class UserPageLeft
{

	var $whichUser;
	
	public function UserPageLeft($which)
	{
		global $whichUser;

		$whichUser = $which;
	}

	public function twitterTextGenerator($str)
	{			
		return str_replace(" ","%20",$str);
	}
	public function UserPageLeftToHTML()
	{
		global $whichUser;
		$twttxt = $this->twitterTextGenerator($whichUser." @TheSerinHikaye");
		$myToplamPuanHesaplayici = new ToplamPuanHesaplayici($whichUser);
		$toplamPuan = $myToplamPuanHesaplayici->PuanHesapla();
		$toplamFavori = $myToplamPuanHesaplayici->FavoriHesapla();
		$toplamYorum = $myToplamPuanHesaplayici->YorumHesapla();

		echo "<div id=\"side_bitch_div\" style=\"padding:2%;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;\">";
			echo "<div style=\"margin-top:1%;padding:2%;\">";
				echo "<p style=\"color:#ec583a;margin-left:3%;word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:20px;\">";
					echo $whichUser;
				echo "</p>";
			echo "</div>";
			echo "<div style=\"padding:2%;margin:1%;\">";
				if (isset($_SESSION["user_name"]))
					if($_SESSION["user_name"]==$whichUser)
						echo "<a id=\"usr_page_msj_yolla_self\" title=\"Kullanıcıya mesaj yolla\" class=\"btn btn-success btn-block\">";
					else
						echo "<a id=\"usr_page_msj_yolla\" title=\"Kullanıcıya mesaj yolla\" class=\"btn btn-success btn-block\">";
				else
					echo "<a id=\"usr_page_msj_yolla_not_signed\" title=\"Kullanıcıya mesaj yolla\" class=\"btn btn-success btn-block\">";
					echo "<i class=\"fa fa-envelope\"></i>";
				echo "</a>";
				echo "<a id=\"fbShareUser\" title=\"Facebook'da paylaş\" class=\"btn btn-facebook btn-block\">";
					echo "<i class=\"fa fa-facebook\"></i>";
				echo "</a>";
				echo "<a id=\"twtShareUser\"  href=\"http://twitter.com/share?text=".$twttxt."&hashtags=SerinHikaye\" title=\"Twitter'da paylaş\" class=\"btn btn-twitter btn-block\">";
					echo "<i class=\"fa fa-twitter\"></i>";
				echo "</a>";
			echo "</div>";
		echo "<div id=\"\" style=\"margin-bottom:5%;margin-top:5%;background-color:#e6e6e6;border-top:1px solid #c7d0d5;\">";
			echo "<p title=\"Toplam puan\" style=\"padding-top:2%;text-align:center;word-wrap:break-word;font-size:20px;color:#5bc236;font-family: 'Josefin Sans', sans-serif;width:100%\">";
				echo "<span id=\"puan_p\" style=\"display:block;\">";
					echo $toplamPuan;
				echo "</span>";
				echo "<img src=\"images/begeni.gif\" alt=\"puan\"style=\"width:50px;max-width:50px;\"/>";
			echo "</p>";
			echo "<p title=\"Toplam favorilenme\" style=\"text-align:center;word-wrap:break-word;font-size:20px;color:#ffb92a;font-family: 'Josefin Sans', sans-serif;width:100%\">";
				echo "<span id=\"\" style=\"display:block;\">";
					echo $toplamFavori;
				echo "</span>";	
				echo "<img src=\"images/fav.gif\" alt=\"fav\"style=\"width:50px;max-width:50px;\"/>";
			echo "</p>";
			echo "<a id=\"show_all_comments_a\" href=\"#\" style=\"text-decoration:none;\">";
			echo "<p title=\"Yaptığı yorumlar\" style=\"text-align:center;word-wrap:break-word;font-size:20px;color:#069dd6;font-family: 'Josefin Sans', sans-serif;width:100%\">";
				echo "<span id=\"\" style=\"display:block;\">";
					echo $toplamYorum;
				echo "</span>";	
				echo "<img src=\"images/comments.gif\" alt=\"fav\"style=\"width:50px;max-width:50px;\"/>";
			echo "</p>";
			echo "</a>";
		echo "</div>";
		echo "</div>";	
		echo "<div id=\"usr_page_mesaj_yollayici_div\"></div>";
		echo "<script type=\"text/javascript\">";
			echo "
				$('#twtShareUser').click(function(e){
					e.preventDefault();
					var width  = 575,
        				height = 400,
        				left   = ($(window).width()  - width)  / 2,
        				top    = ($(window).height() - height) / 2,
        				url    = this.href,
        				opts   = 'status=1' +
                 			',width='  + width  +
                 			',height=' + height +
                 			',top='    + top    +
                 			',left='   + left;
    
    					window.open(url, 'twitter', opts);
				});
				$('#fbShareUser').click(function(){
					FB.ui({
  					method: 'feed',
  					link: 'http://www.serinhikaye.com/user.php?name=".$whichUser."',
  					caption: 'SerinHikaye.com - Herkesin en iyi bildiği şeyler.',
					picture: 'http://www.serinhikaye.com/images/headerfil.jpg',
					name: 'Kullanıcı : ".$whichUser." - SerinHikaye.com'
					}, function(response){});
				});
				$('#usr_page_msj_yolla_not_signed').click(function(){
					$('#signup_modal_div').modal(\"toggle\");
				});
				$('#usr_page_msj_yolla_self').click(function(){
					alert(\"Kendi kendine konuşmak toplum tarafından hoş karşılanmıyor.\");
				});
				$('#usr_page_msj_yolla').click(function(){
					$('#usr_page_mesaj_yollayici_div').load('messagesender.php?kime=".$whichUser."',function(){
						$('#mesaj_yollayici_modal').modal(\"toggle\");
					});
				});
				$('#show_all_comments_a').click(function(){
					$('#usr_page_mesaj_yollayici_div').load('showAllComments.php?usr=".$whichUser."',function(){
						$('#show_all_comments_modal').modal(\"toggle\");
					});
				});
			";
		echo "</script>";
	}


}

?>
