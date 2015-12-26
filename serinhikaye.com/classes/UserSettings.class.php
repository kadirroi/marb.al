<?php
include_once ("classes/ActivationFinder.class.php");
class UserSettings
{
	var $userName;
	
	public function UserSettings($whichUser)
	{
		global $userName;
		$userName = $whichUser;
	}

	public function UserSettingsToHTML()
	{
		global $userName;
		echo "<ul class=\"nav nav-tabs\" style=\"font-family:Verdana,Geneva,sans-serif;font-size:13px;\">";
			echo "<li class=\"active\"><a href=\"#set_sifre_link\" id=\"set_sifre_a\" data-toggle=\"tab\">Şifre değiştirme</a></li>";
			echo "<li class=\"\"><a href=\"#set_del_link\" id=\"set_del_a\" data-toggle=\"tab\">Hesap silme</a></li>";
			echo "<li class=\"\"><a href=\"#set_activation_link\" id=\"set_activation_a\" data-toggle=\"tab\">Üyelik aktivasyonu</a></li>";
		echo "</ul>";
		
		echo "<div class=\"tab-content\">";
			echo"<div class=\"tab-pane-active\" id=\"set_sifre_link\">";
				echo "<div style=\"margin-top:2%;border:1px solid #c7d0d5;border-radius:15px;padding:2%;width:60%;font-family: Verdana,Geneva,sans-serif; color:#6e6e6e;font-size:15px;\">";
					echo "<form id=\"SifreDegistiriciForm\" method=\"post\" action=\"SifreDegistirici.php\">";
						echo "Eski şifre : ";
						echo "<input id=\"passChangeEskiSifre\" name=\"passChangeEskiSifre\" type=\"password\" class=\"form-control\"/>";
						echo "<br/>";
						echo "Yeni şifre : ";
						echo "<input id=\"passChangeYeniSifre\" name=\"passChangeYeniSifre\" type=\"password\" class=\"form-control\"/>";
					echo "</form>";
						echo "<br/>";
						echo "<button id=\"sifreDegistirButton\" class=\"btn btn-primary\">Değiştir</button>";	
						echo "<div id=\"sifreDegistirErrDIV\" style=\"font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;margin-top:5%;margin-bottom:3%;\">";
						echo "</div>";
				echo "</div>";
			echo "</div>";
			echo"<div class=\"tab-pane\" id=\"set_del_link\">";
				echo "<div style=\"margin-top:2%;border:1px solid #c7d0d5;border-radius:15px;padding:2%;width:60%;font-family: Verdana,Geneva,sans-serif; color:#6e6e6e;font-size:15px;\">";
					echo "<form id=\"deleteuserform\" method=\"post\" action=\"deleteuser.php\">";
						echo "Şifre : ";
						echo "<input name=\"deleteuserpassword\" type=\"password\" class=\"form-control\"/>";
						echo "<br/>";
						echo "Son söz:";
						echo "<input type=\"text\" class=\"form-control\"/>";
					echo "</form>";
						echo "<br/>";
						echo "<button id=\"deleteuserbtn\" class=\"btn btn-danger\">Elveda</button>";
				echo "</div>";
			echo"</div>";
			echo "<div class=\"tab-pane\" id=\"set_activation_link\">";
				echo "<div style=\"margin-top:2%;border:1px solid #c7d0d5;border-radius:15px;padding:2%;width:60%;font-family: Verdana,Geneva,sans-serif; color:#6e6e6e;font-size:15px;\">";
				if (isset($_SESSION["user_name"]))
				{
					$myActivationFinder = new ActivationFinder($_SESSION["user_name"]);
					if (!$myActivationFinder->Find())
					{
						echo "Hesabınız aktif değil";
						echo "<br/><br/>";
						echo "<button id=\"activationResendButton\" class=\"btn btn-success\">";
							echo "Tekrar kod gönder";
						echo "</button>";
						echo "<div style=\"display:none;margin-top:2%;\" id=\"activationResendSpinner\">";
							echo "  <i class=\"fa fa-2x fa-spinner fa-spin\"></i>";
						echo "</div>";
						echo "<form id=\"activationResendForm\" style=\"display:none;\" method=\"post\" action=\"activationResend.php?userName=".$_SESSION["user_name"]."\"></form>";
					}
					else
					{
						echo "Hesabınız aktif durumda";
					}
				}
				echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<script type=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					$('#deleteuserbtn').click(function(e){
						e.preventDefault();
						$('#deleteuserform').ajaxForm({
							success : function(msg){
								if(msg==\"usr_not_signed_in\")
									alert(\"Devam etmek için kullanıcı girişi yapın.\");
								if (msg==\"password_not_match\")
									alert(\"Hatalı şifre.\");
								if (msg==\"connect_error\")
									alert(\"Bağlantı hatası.\");
								if (msg==\"OK\")
								{
									alert(\"Hesabınız başarıyla silindi :(\");
									window.location = \"http://www.serinhikaye.com/\"
								}
							},
							error : function(){
								alert(\"Bir hata oldu.\");
							}
						}).submit();
					});
					$('#activationResendButton').click(function(){
						$('#activationResendButton').hide(100);
						$('#activationResendSpinner').show(100);
						$('#activationResendForm').ajaxForm({
							success : function (msg){
								if (msg=='OK'){
									$('#activationResendSpinner').hide();
									alert(\"Aktivasyon kodunuz yollandı. Her ihtimale karşı spam kutunuzu da konrol etmenizde fayda var.\");
								}
									else{
										$('#activationResendButton').show(100);
										$('#activationResendSpinner').hide(100);
										alert(\"Bir hata oldu ve kodunuzu yollayamadık.\");

									}
							},
							error : function()
							{
								alert(\"İstenmeyen şeyler oldu ve kodunuzu yollayamadık.\");
							}
						}).submit();	
					});
					$('#set_sifre_a').click(function(){
						$('#set_sifre_link').attr('class','tab-pane');
					});	
					$('#set_del_a').click(function(){
						$('#set_sifre_link').attr('class','tab-pane');
					});
					$('#set_activation_a').click(function(){
						$('#set_sifre_link').attr('class','tab-pane');
					});
					$('#sifreDegistirButton').click(function(){
						$('#sifreDegistirErrDIV').hide();
						if ($('#passChangeEskiSifre').val()=='' || $('#passChangeYeniSifre').val()=='')
						{
							$('#sifreDegistirErrDIV').html('Bilgileriniz eksik');
							$('#sifreDegistirErrDIV').show(100);
						}
						else		
							$('#SifreDegistiriciForm').ajaxForm({
								success: function(msg){
									msg = $.parseJSON(msg);
									if (msg =='SIFRE_HATALI')
									{
										$('#sifreDegistirErrDIV').html('Şifre bilginiz hatalı');
										$('#sifreDegistirErrDIV').show(100);
									}
									if (msg =='CONNECT_ERR')
									{
										$('#sifreDegistirErrDIV').html('Veritabanımıza bağlanamıyoruz. Bu sorunu en kısa sürede gidericez.');
										$('#sifreDegistirErrDIV').show(100);
									}
									if (msg=='QUERY_ERR')
									{
										$('#sifreDegistirErrDIV').html('Bir sebepten ötürü şifrenizi değiştiremedik. Bu sorunu en kısa sürede gidericez.');
										$('#sifreDegistirErrDIV').show(100);
									}
									if (msg=='OK')
									{
										alert(\"Şifreniz başarıyla değiştirildi.\");
										location.reload();
									}
									if (msg=='SIFRE_TURKCE')
									{
										$('#sifreDegistirErrDIV').html('Şifrenizde türkçe karakterler kullanmamaya gayret edin.');
										$('#sifreDegistirErrDIV').show(100);
									}	
								},
								error : function(){
									$('#sifreDegistirErrDIV').html('Şifre Değiştirici LTD ŞTİ sıçtı. Bu sorunu en kısa sürede gidericez.');
									$('#sifreDegistirErrDIV').show(100);	
								}

							}).submit();
					});	
				});
			";
		echo "</script>";
	}

}

?>
