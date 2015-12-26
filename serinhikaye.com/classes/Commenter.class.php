<?php

session_start();
include_once("classes/Login.class.php");
include_once ("classes/SignUp.class.php");
class Commenter
{

	var $threadID;

	public function Commenter($whichID)
	{
		global $threadID;
		$threadID = $whichID;
	}

	public function CommenterToHTML()
	{
		global $threadID;


		if (isset($_SESSION["user_name"]))
		{
			echo "<div id=\"commenter_div\" style=\"padding-top:2%;padding-bottom:1%;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
				echo "<p style=\"word-wrap:break-word;text-align:left;color:#cb7c7a;margin-left:2%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";
					echo "Bu başlık hakkındaki düşüncelerini yaz ";
				echo "</p>";	
				echo "<form class=\"commenter_form\" method=\"post\" action=\"commentRegisterer.php?id=".$threadID."&username=".$_SESSION["user_name"]."\">";
					echo "<textarea name=\"commentholder\" placeholder=\"Yorum\" id=\"commentholder\" class=\"form-control\"  spellcheck=\"false\" style=\"font-size:17px;font-family: 'Josefin Sans', sans-serif;margin-left:2%;margin-top:1%;resize:none;max-width:90%;\" maxlength=\"500\" rows=\"5\" cols=\"10\" value=\"Yorum\"></textarea>";
				echo "<div style=\"margin-bottom:1%;margin-top:1%;margin-left:2%;\">";				
					echo "<button id=\"comment_sender_button\" class=\"btn btn-success\">Kaydet</button>";
				echo "</div>";
				echo "</form>";
			echo "</div>";
	
		}
		else
		{
			echo "<div id=\"commenter_div_non_active\" style=\"padding-top:2%;padding-bottom:1%;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
				echo "<p style=\"word-wrap:break-word;text-align:left;color:#ec583a;margin-left:2%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";
					echo "Bu başlık hakkındaki düşüncelerini yaz ";
				echo "</p>";	
					echo "<textarea placeholder=\"Yorum\" name=\"commentholder_non_active\" id=\"commentholder\" class=\"form-control\"  spellcheck=\"false\" style=\"font-size:17px;font-family: 'Josefin Sans', sans-serif;margin-left:2%;margin-top:1%;resize:none;max-width:90%;\" maxlength=\"500\" rows=\"5\" cols=\"10\" value=\"Yorum\"></textarea>";
				echo "<div style=\"margin-bottom:1%;margin-top:1%;margin-left:2%;\">";				
					echo "<button id=\"comment_sender_button_non_active\" class=\"btn btn-success\">Kaydet</button>";
				echo "</div>";
			echo "</div>";
			
		}

					echo "<script type=\"text/javascript\">

			$(document).ready(function() {
				$('#comment_sender_button_non_active').click(function(){
					$('#signup_modal_div').modal(\"toggle\");
				});

				$('#comment_sender_button').click(function(event){
					event.preventDefault();
					if ($('#commentholder').val()!='')
					$('.commenter_form').ajaxForm({
						success: function (msg){
	
							if (msg=='OK')
								window.location.href='thread.php?id=".$threadID."'
							if (msg=='QUERY_ERR')
								alert(\"veritabanımızla ilgili bir sıkıntı yaşıyoruz\");
							if (msg=='CONNECT_ERR')
								alert(\"veritabanına bağlanamadık. bu sorunu en kısa sürede düzelticez\");
							if (msg=='BOS')
								alert(\"Bir yorumu yapabilmek için o yorumu öncelikle yazmak durumundasınız\");
							if (msg =='USR_NON_ACTIVE')
								alert(\"Yorum yapmadan önce mail adresinize yolladığımız kod ile üyeliğinizi aktifleştirmeniz gerekiyor.Eğer aktivasyon maili size ulaşmadıysa 'Hesap ayarları' sekmesiden yeni bir mail yollayabilirsiniz.\");
						},						
						error : function (){
							alert(\"sıçış\");
						}
					}).submit();
					else
						alert(\"Bir yorumu yapabilmek için o yorumu öncelikle yazmak durumundasınız\");
				});
			});
			</script>";
	}

}

?>
