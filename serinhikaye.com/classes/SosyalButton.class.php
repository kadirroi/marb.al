<?php

class SosyalButton
{

	var $link = array();

	public function SosyalButton($ary)
	{
		global $link;
		$link["resim"] = $ary[0];
		$link["caption"] = $ary[1];
		$link["threadID"]= $ary[2];
		$link["aciklama"] = $ary[3];
		$link["php"] = "threadLiker.php?id=".$link["threadID"];
		$link["sikayet"] = "sikayetEdici.php?id=".$link["threadID"];
		$link["fav"]="favla.php?id=".$link["threadID"];
	}

	public function twitterTextGenerator($str)
	{
		return str_replace(" ","%20",$str);
	}

	public function SosyalButtonToHTML()
	{
		global $link;

	$name2 = str_replace(" ","-",$link["caption"]);
	$name3 = str_replace("?","",$name2);
	$name4 = str_replace("ç","c",$name3);
	$name4 = str_replace("ğ","g",$name4);
	$name4 = str_replace("ı","i",$name4);
	$name4 = str_replace("ö","o",$name4);
	$name4 = str_replace("ş","s",$name4);
	$name4 = str_replace("ü","u",$name4);
	$name4 = str_replace("İ","i",$name4);
						$name4 = str_replace("Ç","C",$name4);
					$name4 = str_replace("Ğ","G",$name4);
					$name4 = str_replace("Ö","O",$name4);
					$name4 = str_replace("Ş","S",$name4);
					$name4 = str_replace("Ü","U",$name4);
					$name4 = str_replace("'","-",$name4);
					$name4 = str_replace("\"","-",$name4);

		$twitterText = $this->twitterTextGenerator($link["caption"]);
		echo "<div style=\"margin-top:1%;overflow:hidden;height:100%;width:100%;max-width:100%;\">";
			echo "<div id=\"sosyal_falan_div\" style=\"margin-top:5%;\">";
			echo "<a id=\"fbShareButton1\" title=\"Facebook\" class=\"btn btn-facebook btn-block\" href=\"javascript:void(0)\">";
				echo "<i class=\"fa fa-facebook\"></i>";
			echo "</a>";
			echo "</div>";
			echo "<div style=\"margin-top:3%;\">";
			echo "<a id=\"twtShareButton1\" title=\"Twitter\" class=\"btn btn-twitter btn-block\" href=\"http://twitter.com/share?text=".$twitterText."&hashtags=SerinHikaye\">";
				echo "<i class=\"fa fa-twitter\"></i>";
			echo "</a>";
			echo "</div>";
			echo "<form id=\"fav_ekle_form\" method=\"post\" action=\"favorilere_ekle.php?id=".$link["threadID"]."\">";
			echo "<div style=\"margin-top:3%;\">";
			echo "<a title=\"Favorilere ekle\" id=\"favla_img\" class=\"btn btn-success btn-block\" href=\"javascript:void(0)\">";
				echo "<i class=\"fa fa-bookmark\"></i>";	
			echo "</a>";
			echo "</div>";
			echo "</form>";
			echo "<form class=\"sosyal_ve_begeni_form\" method=\"post\" action=\"".$link["php"]."\">"; 
			echo "<div style=\"margin-top:3%;\">";
			echo "<a title=\"Beğen\" id=\"begen_img\"class=\"btn btn-danger btn-block\" href=\"javascript:void(0)\">";
				echo "<i class=\"fa fa-heart\"></i>";
			echo "</a>";
			echo "</div>";
			echo "</form>";
			echo "<div style=\"margin-bottom:5%;margin-top:3%;\">";
			echo "<a title=\"Şikayet et\"  class=\"btn btn-warning btn-block\" id=\"sikayet_resmi\" href=\"javascript:void(0)\" data-target=\"#basicModal\">";
				echo "<i class=\"fa fa-warning\"></i>";
			echo "</a>";
			echo "</div>";
		echo "</div>";
			echo "<div class=\"modal fade\" id=\"SikayetModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\">";
				echo "<div class=\"modal-dialog\">";
					echo  "<div class=\"modal-content\">";
						echo "<div class=\"modal-header\" style=\"\">";
							echo  "<h4 class=\"modal-title\" id=\"myModalLabel\" style=\"font-family:Verdana,Geneva,sans-serif;margin-left:3%;\">Şikayetinizi kısaca açıklayın lütfen</h4>";
						echo "</div>";
						echo  "<div class=\"modal-body\">";
							echo "<form id=\"sikayet_gonderici_form\" action=\"".$link["sikayet"]."\" method=\"post\">";
								echo "<textarea name=\"sikayetholder\" id=\"sikayetholder\" class=\"form-control\"  spellcheck=\"false\" style=\"font-size:17px;font-family: Verdana,Geneva,sans-serif;margin-left:3%;margin-top:1%;resize:none;max-width:94%;\" maxlength=\"500\" rows=\"10\" cols=\"10\"> </textarea>";
							echo "</form>";
						echo "</div>";
						echo "<div class=\"modal-footer\">";
							echo "<button style=\"\" type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Vazgeçtim</button>";
							echo "<button id=\"sikayeti_yolla_button\" style=\"margin-right:3%;\" type=\"button\" class=\"btn btn-primary\">Yolla</button>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		
		echo "<script type=\"text/javascript\">";
			echo "
				$('#twtShareButton1').click(function(e){
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
				$('#fbShareButton1').click(function(e){
					e.preventDefault();
					FB.ui({
  					method: 'feed',
  					link: 'http://serinhikaye.com/thread/".$link["threadID"]."/".$name4."',
  					caption: '".$link["aciklama"]."',
					picture: 'http://serinhikaye.com/".$link["resim"]."',
					name: '".$link["caption"]." - SerinHikaye.com'
					}, function(response){});
				});
				$(document).ready(function() {

					$('#favla_img').click(function(){
						$('#fav_ekle_form').ajaxForm({
							success : function (msg){
								if (msg=='NOT_LOGGED_IN')
									$('#signup_modal_div').modal(\"toggle\");
								if (msg=='USR_ALREADY_LIKED')
									alert('Bu içerik, favorilerinizde zaten mevcut.');
								if (msg =='QUERY_ERR')
									alert('Bir sorun meydana geldi.');
								if (msg=='OK')
									alert('Bu içerik başarıyla favorilerinize eklendi.');
							
							},
							error : function () {
								alert(\"Favorilere ekleyici ltd şti sıçtı.\");
							}
						}).submit();
					});
					$('#sikayet_resmi').click(function(){
						$('#SikayetModal').modal(\"toggle\");
					});
					$('#sikayeti_yolla_button').click(function(){
						$('#sikayet_gonderici_form').ajaxForm({
							success : function(msg){
								msg = $.parseJSON(msg);
								$('#SikayetModal').modal(\"hide\");
								if (msg == 'OK'){
									alert(\"Şikayetiniz bize iletildi ve bu içeriği incelemeye aldık.\");
									$('#sikayet_resmi').hide();
								}								
								if (msg == 'QUERY_ERR')
									alert (\"Bir sorun oluştu.\");
								if (msg == 'CONNECT_ERR')
									alert (\"Bağlantı hatası.\");
							},
							error : function() {
								$('#SikayetModal').modal(\"hide\");
								alert(\"Şikayet Edici Ltd Şti sıçtı, bu sorunu en kısa sürede gidericez.\");	 
							}
						}).submit();
					});
					$('#begen_img').click(function(){
						$(\".sosyal_ve_begeni_form\").ajaxForm({
							success : function(msg){
								msg= $.parseJSON(msg);
								if (msg.msg=='OK')
								{
									$('#begen_img').fadeOut(500);	
									$('#puan_p').html(msg.msg2);
								}
							},
							error: function (){
								alert(\"Bir sorun oldu ve oyunuz kaydedilemedi.\");
							}
						}).submit();	
					});
				});
			";
		echo "</script>";

	}

}

?>
