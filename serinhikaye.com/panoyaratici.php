<?php	
session_start();


		echo "<div class=\"modal fade bs-example-modal\" id=\"upmenu_yeni_pano_modal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog \">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
	
					echo "<div id=\"\" class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<a type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></a>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "Yeni pano ";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						echo "<div style=\"padding-top:2%;padding-bottom:2%;margin-top:1%;background-color:#e6e6e6;width: 100%; max-width:100%;\">";
							echo "<div style=\"margin-left:6%;\">";
									echo "<div style=\"overflow:hidden;max-width:80%;\">";
									echo "<form id=\"yeni_pano_form\" method=\"post\" enctype=\"multipart/form-data\" action=\"yenipano.php\">";
				echo "<div id=\"\" style=\"margin-bottom:5%;margin-top:1%;font-family: 'Josefin Sans',sans-serif\">";
					echo "<span style=\"color:#6e6e6e;font-family: 'Josefin Sans',sans-serif ; font-size:18px;\">";
						echo "Kategori:";
					echo "</span>";
					echo "<select name=\"pano_cat\" style=\"margin-top:0.5%;margin-bottom:2%;font-family: 'Josefin Sans',sans-serif;width:39%;\" class=\"form-control\" id=\"selector1\">";
						echo "<option value=\"Sanat/Eğlence\"> Sanat/Eğlence </option>";
						echo "<option value=\"Bilgisayar/Elektronik\"> Bilgisayar/Elektronik </option>";
						echo "<option value=\"Yemek/İçmek\"> Yemek/İçmek </option>";
						echo "<option value=\"Sağlık/Spor\"> Sağlık/Spor </option>";
						echo "<option value=\"Sosyal ilişkiler\"> Sosyal ilişkiler </option>";
						echo "<option value=\"Bilim/Kültür\"> Bilim/Kültür </option>";
						echo "<option value=\"Alakasız\"> Alakasız </option>";
					echo "</select>";
				echo "</div>";
									echo "<div style=\"margin-top:2%;max-width:80%;\">";
									echo "<div style=\"display:inline-block;\">";
						echo "<input id=\"baslik_part_1\" name=\"baslik_part_1\" type=\"text\" class=\"form-control\"style=\"font-family: 'Josefin Sans',sans-serif;\" maxlength=\"80\" size=\"10\">";
					echo "</div>";
					echo "<div style=\"margin-left:0.5%;display:inline-block;\">";
						echo "<input type=\"text\" value=\"nasıl\" class=\"form-control\"style=\"font-family: 'Josefin Sans', sans-serif;\" maxlength=\"40\" size=\"3\" disabled>";
					echo "</div>";
					echo "<div style=\"margin-left:0.5%;display:inline-block;\">";
						echo "<input id=\"baslik_part_2\" name=\"baslik_part_2\" type=\"text\" class=\"form-control\"style=\"font-family: 'Josefin Sans', sans-serif;\" maxlength=\"80\" size=\"10\">";
					echo "</div>";	
									echo "</div>";
										echo "<input type=\"file\" class=\"file btn-info\" title=\"Pano resmini seç\" name=\"imagefile\" data-filename-placement=\"inside\" style=\"margin-right:2%;\"/>";
									echo "<div style=\"display:inline-block;margin-top:2%;max-width:80%;\">";
										echo "<button id=\"yeni_pano_gonder\" class=\"btn btn-success\">";
											echo "Gönder";
										echo "</button>";
									echo "</div>";
									echo "</div>";


									echo "</form>";
							echo "</div>";
						echo "</div>";
					echo "</div>";

				echo "</div>";
			echo "</div>";	
		echo" </div>";
		
		echo "<script>";
			echo "
			$('input[type=file]').bootstrapFileInput();
			$('.file-inputs').bootstrapFileInput();
			
			$('#yeni_pano_gonder').click(function(e){
				e.preventDefault();
				if ($('#baslik_part_1').val()=='' || $('#baslik_part_2').val()==''){
					alert(\"Başlığınız formata uygun değil.\");
				}
				else
				{
					$('#yeni_pano_form').ajaxForm({
						success : function(msg){
							if (msg.charAt(0)==\"1\")
							{
								window.location.href=msg.substring(1);
							}
							else
								alert(msg);
						
						},
						error : function(){
							alert(\"Bir hata oldu.\");
						}
					}).submit();	
				}
			});			
			";
			
		echo "</script>";
?>
