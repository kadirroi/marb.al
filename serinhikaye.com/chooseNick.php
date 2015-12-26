<?php	
session_start();


		echo "<div class=\"modal fade \" id=\"nickChooserModal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog  \">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
	
					echo "<div id=\"nickChooserTop\" class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: Verdana,Geneva,sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "Yeni kullanıcı adı ";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						echo "<p style=\"color:#6e6e6e;margin-left:4%;font-size:15px;font-family: Verdana,Geneva,sans-serif;\">";
							echo "Merhaba !"."<br/>"."Sitemize bu hesap ile ilk kez bağlanıyorsun.";
							echo "<br/>"."Kullanıcı adını seçikten sonra, dilediğin zaman Facebook ile bağlan butonu ile kolayca giriş yapabilirsin.";
						echo "<br/>";
							echo "<form id=\"chooseNicknameForm\" style=\"margin-left:3%;width:50%;\" method=\"post\" action=\"registerUserFromFacebook.php?id=".$_GET["id"]."\">";
								echo "<input name=\"chooseNicknameTXTINPUT\" id=\"chooseNicknameTXTINPUT\" class=\"form-control\" maxlength=\"19\" placeholder=\"Kullanıcı adı\" type=\"text\"/>";
								echo "<div style=\"margin-top:1%;\">";
								echo "<button id=\"chooseNickSubmitButton\" class=\"btn btn-success\">Gönder</button>";
								echo "</div>";
							echo "</form>";
						echo "</p>";	
					echo "</div>";

				echo "</div>";
			echo "</div>";	
		echo" </div>";
		echo "<script type=\"text/javascript\">";
			echo "
				$('#chooseNickSubmitButton').click(function(e){
					e.preventDefault();	
					if ($('#chooseNicknameTXTINPUT').val()=='')
					{
						alert(\"Kullanıcı adınızı girmeniz gerekiyor.\");
					}
					else
					$('#chooseNicknameForm').ajaxForm({
						success : function(msg){
						
								if (msg == 'TURKCE_NO_PASS')
									alert(\"Kullanıcı adınızda türkçe karakterler bulunmamalı.\");
								if (msg == 'CONNECT_ERR')
									alert(\"Bağlantı hatası.\");
								if (msg == 'USER_EXISTS')
									alert(\"Bu isim daha önce alınmış\");
								if (msg == 'OK')
									location.reload();
							
						},
						error : function(){
							alert(\"Bir hata oldu.\");
						}		
					}).submit();
				});
			";	
		echo "</script>";
?>
