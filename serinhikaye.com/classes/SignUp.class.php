<?php
class SignUp
{
	public function SignUp()
	{

	}
	
	public function SignUpToHTML()
	{
echo "<link rel=\"stylesheet\" href=\"bootstrap-social-gh-pages/bootstrap-social.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"font-awesome-4.3.0/css/font-awesome.min.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"font-awesome-4.3.0/css/font-awesome.css\"/>";
		echo "<div style=\"background-color:#e6e6e6;\" id=\"signup_wrapper_divvo\">";
			echo "<div style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\" id=\"signup_facebook_twitter_ile_baglan\">";
				echo "<p style=\"font-size:20px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
					echo "Facebook veya Twitter ile bağlan";
				echo "</p>";
				echo "<div>";
					echo "<a href=\"javascript:void(0)\" id=\"SignUpWithFacebookSgn\" style=\"width:200px;\" class=\"btn btn-social btn-facebook\">";
						echo "<i class=\"fa fa-facebook\"></i>";
						echo "Facebook ile bağlan";
					echo "</a>";
					echo "<br/><br/>";
					echo "<a href=\"twitter_send.php\" style=\"width:200px;\" class=\"btn btn-social btn-twitter\">";
  						echo "<i class=\"fa fa-twitter\"></i>";
  							echo "Twitter ile bağlan";
					echo "</a>";
					echo "<br/><br/>";
				echo "</div>";
			echo "</div>";
			echo "<div style=\"margin-left:1%;margin-top:2%;background-color:#e6e6e6;\" id=\"signup_normal_sekiller_ile_baglan\">";
				echo "<p style=\"font-size:20px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
					echo "SerinHikaye kullanıcı adı al";
				echo "</p>";
				echo "<p style=\"margin-left:0.5%;font-size:13px;font-family:Verdana,Geneva,sans-serif;\">";
					echo "<a id=\"zaten_uye_misin_link\" href=\"javascript:void(0)\">";
						echo "Zaten üye misin ? Giriş yap.";
					echo "</a>";
				echo "</p>";							
			echo "</div>";	
			echo "<div style=\"border:1px solid #c7d0d5;padding:2%;border-radius:15px;padding-top:2%;max-width:70%;\">";
				echo "<form class=\"\" id=\"signup_formu\" method=\"post\" action=\"signup.php\">";
					echo "<div style=\"font-size:15px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
						echo "<p style=\"\">";
						echo "<span style=\"margin-left:0.8%;\">";
						echo "Kullanıcı adı  : ";
						echo "</span>";
						echo "<input style=\"\" name=\"nick_signup\" type=\"text\" class=\"form-control\" id=\"nick_signup\" placeholder=\"Kullanıcı adı\" maxlength=\"19\"/>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"font-size:15px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
						echo "<p style=\"\">";
						echo "<span style=\"margin-left:0.8%;\">";
						echo " Email adresi : ";
						echo "</span>";
echo "<input style=\"\" name=\"email_signup\" type=\"email\" class=\"form-control\" id=\"email_signup\" placeholder=\"Email \" maxlength=\"150\"/>";				
						echo "</p>";
					echo "</div>";
					echo "<div style=\"font-size:15px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
						echo "<p style=\"\">";
						echo "<span style=\"margin-left:0.8%;\">";
						echo "  Şifre : ";
						echo "</span>";
						echo "<input name=\"password_signup\" style=\"\" type=\"password\" class=\"form-control\" id=\"password_signup\" placeholder=\"Şifre\" maxlength=\"50\"/>";
						echo "</p>";				
					echo "</div>";
					echo "<div class=\"form-inline\" style=\"font-size:12px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
						echo "<span style=\"display:blockpadding-left:20px;text-indent:-15px;\">";
						echo "<input style=\"padding:0;overflow:hidden;vertical-align:bottom;position:relative;top:-1px;height:13px;width:13px;\" type=\"checkbox\" name=\"kayit_onay_check\" id=\"kayit_onay_check\" class=\"form-control\"/>";
							echo "<span style=\"margin-left:1%;\">";
							echo "<a target=\"_blank\" href=\"sartlar.php\">Kullanıcı sözleşmesi</a>ni okudum ve onaylıyorum.";							echo "</span>";
						echo "</span>";
					echo "</div>";
					echo "</form>";
					echo "<div style=\"margin-bottom:2%;margin-top:4%;\">";
					echo "<div style=\"margin-bottom:3%;margin-top:1%;font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;\" id=\"signup_giris_hatasi_var\">";
					echo "</div>";
					echo "<button id=\"signup_yolla_button\" class=\"btn btn-success\"> Kayıt </button>";
					echo "</div>";
					echo "<div id=\"SignUpSpinnerDiv\" style=\"display:none;\">";
						echo "  <i class=\"fa fa-2x fa-spinner fa-spin\"></i>";
					echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<script style=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					$('#SignUpWithFacebookSgn').click(function(){
						Login();
					});
					$('#zaten_uye_misin_link').click(function(){
						$('#signup_modal_div').modal(\"toggle\");						
						$('#login_modal_div').modal(\"toggle\");
					});
					$('#signup_yolla_button').click(function(){
						$('#signup_giris_hatasi_var').html('');	
						$('#signup_giris_hatasi_var').hide();
						if ($('#kayit_onay_check').is(':checked'))
						{
							if ($('#nick_signup').val()=='')
							{
								$('#signup_giris_hatasi_var').html('Kullanıcı adı kısmını boş bırakmışsınız.');
								$('#signup_giris_hatasi_var').show(250);
							}
							else
							{
								if ($('#email_signup').val()=='')
								{
									$('#signup_giris_hatasi_var').html('Email kısmını boş bırakmışsınız.');
									$('#signup_giris_hatasi_var').show(250);
								}
								else
								{
									if ($('#password_signup').val()=='')
									{
										$('#signup_giris_hatasi_var').html('Şifre kısmını boş bırakmışsınız.');
										$('#signup_giris_hatasi_var').show(250);
									}
									else
									{
										$('#SignUpSpinnerDiv').show(100);
										$('#signup_yolla_button').hide(100);
										$('#signup_formu').ajaxForm({
											success: function(msg)
											{
											
												$('#SignUpSpinnerDiv').hide(100);
												$('#signup_yolla_button').show(100);
										
if (msg=='OK')
{
alert(\"Email adresinize üyeliğinizi aktive etmeniz için gereken bilgileri yolladık. Her ihtimale karşı spam kutunuzu da kontrol etmeyi ihmal etmeyin.\");
location.reload();
}
else
{
	if (msg=='CONNECT_ERR')
	{
		$('#signup_giris_hatasi_var').html('Şu an veritabanımıza bağlanamıyoruz, bu sorunu en kısa sürede gidericez');
		$('#signup_giris_hatasi_var').show(250);
	}
	else
	{
		if (msg=='QUERY_ERR')
		{
			$('#signup_giris_hatasi_var').html('Şu an veritabanımızla ilgili bazı sıkıntılar yaşıyoruz, bu sorunu en kısa sürede gidericez');
			$('#signup_giris_hatasi_var').show(250);
		}
		else
		{
			if (msg=='EMAIL_VAR')
			{
				$('#signup_giris_hatasi_var').html('Girdiğiniz Email zaten sistemimize kayıtlı.');
				$('#signup_giris_hatasi_var').show(250);
			}
			else
			{
				if (msg=='KULLANICI_VAR')
				{
					$('#signup_giris_hatasi_var').html('Seçtiğiniz kullanıcı adı daha önce kullanılmış. Lütfen başka bir kullanıcı adı seçin.');
					$('#signup_giris_hatasi_var').show(250);
				}
				else
				{
					if (msg=='TURKCE_KARAKTER_PASS')
					{
						$('#signup_giris_hatasi_var').html('Şifrenizde ı,ş,ç,ğ,ö,ü gibi türkçe karakterler bulunmaması gerekiyor.');
						$('#signup_giris_hatasi_var').show(250);
					}
					else
					{
						if (msg=='TURKCE_KARAKTER_NICK')
						{
							$('#signup_giris_hatasi_var').html('Kullanıcı adınızda ı,ş,ç,ğ,ö,ü gibi türkçe karakterler bulunmaması gerekiyor.');
							$('#signup_giris_hatasi_var').show(250);
						}
						else
						{
							alert(msg);
						}
					}
				}
			}
		}
	}
}
											},
											error : function ()
											{
												alert(\"Kayıt edici ltd şti sıçtı\");
											}
										}).submit();
									}
								}
							}
						}
						else
						{
							$('#signup_giris_hatasi_var').html('Kayıt olmadan önce kullanıcı sözleşmesini onaylamak durumundasınız');
							$('#signup_giris_hatasi_var').show(250);
						}
					});
				});
			";	
		echo "</script>";
	}
}
?>
