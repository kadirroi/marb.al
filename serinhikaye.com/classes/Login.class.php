<?php

class Login
{

	public function Login()
	{

	}
	
	public function LoginToHTML()
	{
		echo "<link rel=\"stylesheet\" href=\"bootstrap-social-gh-pages/bootstrap-social.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"font-awesome-4.3.0/css/font-awesome.min.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"font-awesome-4.3.0/css/font-awesome.css\"/>";
		echo "<div style=\"background-color:#e6e6e6;\" id=\"login_wrapper_divvo\">";
			echo "<form id=\"sifre_gg_form\" method=\"post\" action=\"SifremiUnuttum.php\">";
				echo "<input type=\"text\" style=\"display:none;\" name=\"email_forgot\" id=\"email_forgot\"/>";
			echo "</form>";
			echo "<div style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\" id=\"facebook_twitter_ile_baglan\">";
				echo "<p style=\"font-size:20px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
					echo "Facebook veya Twitter ile bağlan";
				echo "</p>";
				echo "<div>";
					echo "<a href=\"javascript:void(0)\" id=\"LoginWithFacebookButtonLgn\" style=\"width:200px;\" class=\"btn btn-social btn-facebook\">";
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
			echo "<div style=\"margin-left:1%;margin-top:2%;background-color:#e6e6e6;\" id=\"normal_sekiller_ile_baglan\">";
				echo "<p style=\"font-size:20px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
					echo "SerinHikaye hesabı ile bağlan";
				echo "</p>";
				echo "<p style=\"margin-left:0.5%;font-size:13px;font-family:Verdana,Geneva,sans-serif;\">";
					echo "<a id=\"uye_degil_misin_link\" href=\"javascript:void(0)\">";
						echo "Henüz üye değil misin ? SerinHikaye üyesi ol.";
					echo "</a>";
				echo "</p>";							
			echo "</div>";	
			echo "<div style=\"border:1px solid #c7d0d5;padding:2%;border-radius:15px;padding-top:2%;max-width:70%;\">";
				echo "<form class=\"\" id=\"login_formu\" method=\"post\" action=\"login.php\">";
					echo "<div style=\"font-size:15px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
						echo "<p style=\"\">";
						echo "<span style=\"margin-left:0.8%;\">";
						echo " Email adresi : ";
						echo "</span>";
echo "<input style=\"\" name=\"email\" type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Email \"/>";				
						echo "</p>";
					echo "</div>";
					echo "<div style=\"font-size:15px;font-family:Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
						echo "<p style=\"\">";
						echo "<span style=\"margin-left:0.8%;\">";
						echo "  Şifre : ";
						echo "</span>";
						echo "<input name=\"password\" style=\"\" type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Şifre\"/>";
						echo "</p>";				
					echo "</div>";
					echo "</form>";
					echo "<div style=\"margin-bottom:2%;margin-top:4%;\">";
					echo "<div style=\"margin-bottom:3%;margin-top:1%;font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;\" id=\"giris_hatasi_var\">";
					echo "</div>";
					echo "<i id=\"loginSpinner\" style=\"display:none;\" class=\"fa fa-refresh fa-spin\"></i>";
					echo "<button id=\"login_yolla_button\"  class=\"btn btn-success\"> Bağlan </button>";
					echo "</div>";
					echo "<a id=\"sifremi_unuttum_a\" style=\"\" href=\"javascript:void(0)\"> Şifremi unuttum </a>";
			echo "</div>";
		echo "</div>";

		echo "<script type=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					$('#LoginWithFacebookButtonLgn').click(function(){
						Login();
					});
					$('#uye_degil_misin_link').click(function(){
						$('#login_modal_div').modal(\"toggle\");
						$('#signup_modal_div').modal(\"toggle\");
					});
					$('#sifremi_unuttum_a').click(function(){
						$('#giris_hatasi_var').hide();
						$('#email_forgot').val($('#email').val());
						if($('#email').val()!='')
						$('#sifre_gg_form').ajaxForm({
							success : function (msg){
								msg = $.parseJSON(msg);
								if (msg == 'OK')
								{
									alert(\"Belirttiğiniz adrese şifre bilgilerinizi yolladık. Her ihtimale karşı spam kutunuzu da kontrol etmenizde fayda var.\");
								}
								else{
									if (msg == 'CONNECT_ERR')
									{
										$('#giris_hatasi_var').html('Veritabanımıza bağlanamıyoruz, bu sorunu en kısa sürede gidericez.');
										$('#giris_hatasi_var').show(250);
									}
									else
										if (msg == 'KULLANICI_YOK')
										{
											$('#giris_hatasi_var').html('Girdiğiniz adrese kayıtlı bir kullanıcı yok.');
											$('#giris_hatasi_var').show(250);
										}
										else
										{
											$('#giris_hatasi_var').html(msg);
											$('#giris_hatasi_var').show(250);	
										}
								}
							},
							error : function (){
								alert(\"Şifre hatırlatıcı ltd şti sıçtı\");
							}
						}).submit();
						else
						{
							$('#giris_hatasi_var').html(\"Şifre bilgilerinizi yollayabilmemiz için geçerli bir email adresi girmeniz gerekiyor.\");
							$('#giris_hatasi_var').show(250);
						}
					});
					$(document).keypress(function(e) {
						if($('#email').val()!='')
							if($('#password').val()!='')
						if(e.which == 13)
						{
						$('#giris_hatasi_var').hide();
						if($('#email').val()!='')
						$('#login_formu').ajaxForm({
							success : function (msg)
							{
								msg = $.parseJSON(msg);
								if (msg == 'OK')
								{
									location.reload();
								}
								if (msg == 'SIFRE_HATALI')
								{
									$('#giris_hatasi_var').html('Hatalı şifre.');
									$('#giris_hatasi_var').show(250);
								}
								if (msg =='KULLANICI_YOK')
								{
									$('#giris_hatasi_var').html('Böyle bir kullanıcı yok gibi gözüküyor.');
									$('#giris_hatasi_var').show(250);
								}
								if (msg =='CONNECT_ERR')
								{
									$('#giris_hatasi_var').html('Veritabanımıza bağlanamıyoruz, bu sorunu en kısa sürede düzelticez.');
									$('#giris_hatasi_var').show(250);
								}
							},
							error : function()
							{
								alert(\"Login sıçtı\");
							}
						}).submit();
						else{
							$('#giris_hatasi_var').html('Email kısmını boş bırakmışsınız');
							$('#giris_hatasi_var').show(250); }						
						}
					});
					$('#login_yolla_button').click(function(){
						$('#login_yolla_button').hide();
						$('#loginSpinner').show();
						$('#giris_hatasi_var').hide();
						if($('#email').val()!='')
						$('#login_formu').ajaxForm({
							success : function (msg)
							{
								$('#loginSpinner').hide();
								$('#login_yolla_button').show();
								msg = $.parseJSON(msg);
								if (msg == 'OK')
								{
									location.reload();
								}
								if (msg == 'SIFRE_HATALI')
								{
									$('#giris_hatasi_var').html('Hatalı şifre.');
									$('#giris_hatasi_var').show(250);
								}
								if (msg =='KULLANICI_YOK')
								{
									$('#giris_hatasi_var').html('Böyle bir kullanıcı yok gibi gözüküyor.');
									$('#giris_hatasi_var').show(250);
								}
								if (msg =='CONNECT_ERR')
								{
									$('#giris_hatasi_var').html('Veritabanımıza bağlanamıyoruz, bu sorunu en kısa sürede düzelticez.');
									$('#giris_hatasi_var').show(250);
								}
							},
							error : function()
							{
								alert(\"Login sıçtı\");
							}
						}).submit();
						else{
							$('#giris_hatasi_var').html('Email kısmını boş bırakmışsınız');
							$('#giris_hatasi_var').show(250); }
					});
				});
			";
		echo "</script>";
	}

}

?>
