<?php

include_once ("classes/StepCreator.class.php");

class ThreadCreator
{

var $threadInfos = array();

public function ThreadCreator($ary)
{
	global $threadInfos;
	$threadInfos['username']=$ary[0];	/* bu thread'i hangi kullanıcı oluşturuyor? */
	$threadInfos['threadID']=$ary[1];	/* bu thread'i database'e hangi id ile kaydedicez */
	$threadInfos['Form Linki']="threadRegisterer.php?username=".$threadInfos['username']."&threadID=".$threadInfos['threadID'];
	$threadInfos['Delete Linki']="threadEreaser.php?username=".$threadInfos['username']."&threadID=".$threadInfos['threadID'];
	$threadInfos['Thread Linki']="thread.php?id=".$ary[1]."&olay=success";
}

public function ThreadCreatorToHTML()
{
	global $threadInfos;
	
	echo "<input id=\"threadLinkiInput\" type=\"text\" style=\"display:none\" value =\"".$threadInfos['Thread Linki']."\">";
	for ($i=1;$i<=10;$i++)
	{
		$myStepCreator = new StepCreator(array($i,$threadInfos['threadID']));
		echo "<div style=\"display:none;\" id=\"stepCreatorID_".$i."\">";
			$myStepCreator->StepCreatorToHTML();
		echo "</div>";
	}
	echo "<br/>";
	/* resim yükleme şeysinin wrapper div'i */
	echo "<div id=\"wrapper_upload2\" style=\"background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
		echo "<form class=\"uploadform2\" method=\"post\" enctype=\"multipart/form-data\" action='imageUploader.php'>";
			echo "<div id=\"derinnefes2\" style=\"margin-top:3%;margin-left:5%;font-size:20px;font-family: Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
				echo "Başlığınız için temsili bir resim yükleyin.";
			echo "</div>";
			echo "<div id=\"uploadbuts2\" style=\"margin-bottom:3%;margin-top:3%; margin-left:5%; margin-right:5%;\">";			 
				echo "<input type=\"file\" class=\"btn btn-primary btn-block\" title=\"Resim Seç\" name=\"imagefile\"data-filename-placement=\"inside\"/>";			
				echo "<button type=\"button\"class=\"btn btn-success btn-block\" value=\"Yükle\" id=\"submitbtn2\">Yükle</button>";
			echo "</div>";	
		echo "</form>";
		echo "<div id=\"yukleme_sorunu2\" style=\"font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;margin-top:3%;margin-left:5%;margin-bottom:3%;\"> </div>";
	echo "</div>";
	/****************************************/
	
	/* creator divi*/
	echo "<div id=\"wrapper_kreator2\" style=\"display:none;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
		echo "<div id=\"kretor_form\" style=\"overflow:hidden;\">";
			echo "<form class=\"stepCreatorForm\" method=\"post\" action=\"".$threadInfos['Form Linki']."\">";
				echo "<input name=\"resim_linki2\" id=\"resim_linki2\" type=\"hidden\"/>";
				echo "<div id=\"category_div\" style=\"margin-top:1%;margin-left:5%;\">";
					echo "<span style=\"color:#6e6e6e;font-family: Verdana,Geneva,sans-serif 20px; font-size:23px;\">";
						echo "Kategori:";
					echo "</span>";
					echo "<select name=\"thread_cat_select\" style=\"margin-top:0.5%;font-family: Verdana,Geneva,sans-serif;width:39%;\" class=\"form-control\" id=\"sel1\">";
						echo "<option value=\"Sanat/Eğlence\"> Sanat/Eğlence </option>";
						echo "<option value=\"Bilgisayar/Elektronik\"> Bilgisayar/Elektronik </option>";
						echo "<option value=\"Yemek/İçmek\"> Yemek/İçmek </option>";
						echo "<option value=\"Sağlık/Spor\"> Sağlık/Spor </option>";
						echo "<option value=\"Sosyal ilişkiler\"> Sosyal ilişkiler </option>";
						echo "<option value=\"Bilim/Kültür\"> Bilim/Kültür </option>";
						echo "<option value=\"Alakasız\"> Alakasız </option>";
					echo "</select>";
				echo "</div>";
				echo "<div id=\"div_img2\" style=\"max-width:80%;margin-left:1%; margin-top:1%;\">";
					echo "<img id=\"yuklenenResimThread\" class=\"preview\" alt=\"yuklenen_resim\" src=\"\" style=\"margin-left:5%;margin-top:3%;max-width:80%;\"/>";
				echo "</div>";	
				echo "<div id=\"baslik_div\" style=\"margin-top:2%;margin-left:5%;\">";
					echo "<span style=\"color:#6e6e6e;font-family: Verdana,Geneva,sans-serif 20px; font-size:23px;\">";
						echo "Başlık ";
						echo "<a href=\"javascript:void(0)\" id=\"baslik_help\" title=\"Başlık formatı nedir?\"> (?) </a>";	
						echo " : ";					
					echo "</span>";
					echo "<div id=\"baslik_help_div\" style=\"display:none;font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;margin-top:1%;\">";
					echo "</div>";
					echo "<br/>";
					echo "<div style=\"display:inline-block;\">";
						echo "<input name=\"baslik_part_1\" type=\"text\" class=\"form-control\"style=\"padding-top:1%;font-size:17px;font-family: Verdana,Geneva,sans-serif;max-width:100%;margin-top:1%;\" maxlength=\"80\" size=\"20\">";
					echo "</div>";
					echo "<div style=\"margin-left:0.5%;display:inline-block;\">";
						echo "<input type=\"text\" value=\"nasıl\" class=\"form-control\"style=\"padding-top:1%;font-size:17px;font-family: Verdana,Geneva,sans-serif;max-width:100%;margin-top:1%;\" maxlength=\"40\" size=\"3\" disabled>";
					echo "</div>";
					echo "<div style=\"margin-left:0.5%;display:inline-block;\">";
						echo "<input name=\"baslik_part_2\" type=\"text\" class=\"form-control\"style=\"font-size:17px;font-family: Verdana,Geneva,sans-serif;max-width:100%;margin-top:1%;\" maxlength=\"80\" size=\"20\">";
					echo "</div>";	
				echo "</div>";
				echo "<input id=\"how_many_steps_there_are2\" name=\"how_many_steps_there_are2\" type=\"hidden\" value=\"0\"/>";
				echo "</form>";
				echo "<div id=\"show_steps_div\" style=\"margin-top:1%;font-family: Verdana,Geneva,sans-serif;font-size:20px;margin-left:5%;\">";
					for ($i=1;$i<=10;$i++)
					{
						echo "<div id=\"show_step_".$i."\" style=\"display:none;\">";
							echo "<a id=\"link_step_".$i."\" href=\"javascript:void(0)\" title=\"Bu adımı düzenlemek için tıklayın.\"> Adım ".$i."</a>";
						echo "</div>";					
					}
				echo "</div>";
				echo "<div id=\"daha_fazla_adim_ekleyemezsin\" style=\"display:none;font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;margin-top:1%;margin-left:5%;\">";
						echo "<span>";
							echo "Bir site politikası olarak 10 adımdan fazlasını beğenmiyoruz.";
						echo "</span>";
				echo "</div>";
				
				echo "<div id=\"focus\"></div>";
				echo "<div id=\"threadRegErrDIV\" style=\"display:none;font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;margin-top:1%;margin-left:5%;\">";
				echo "</div>";	

				echo "<div id=\"step_switch_div\" style=\"margin-bottom:3%;margin-top:2%;margin-right:28%;margin-left:5%;\">";
					echo "<form class=\"find_next_step_form\" method=\"post\" action=\"nextStepFinder.php\">";
						echo "<input id=\"how_many_steps_there_are\" name=\"how_many_steps_there_are\" type=\"hidden\" value=\"0\"/>";
						echo "<button id=\"yeni_adim_ekle_button\" type=\"button\" class=\"btn btn-primary btn-block\">Yeni adım ekle</button>";
						echo "<button id=\"basligi_yayinla_plz\" type=\"button\" class=\"btn btn-success btn-block\">Yayınla </button>";
					echo "</form>";	
				echo "</div>";
		
		echo "</div>";
	echo "</div>";

	/***************/
	
	
	echo "<script type=\"text/javascript\" >
			$(document).ready(function() {
			
				$('input[type=file]').bootstrapFileInput();
				$('.file-inputs').bootstrapFileInput();
				
				$('#basligi_yayinla_plz').click(function() {
					$('#threadRegErrDIV').hide();
					$(\".stepCreatorForm\").ajaxForm({
						success: function(msg){
							msg = $.parseJSON(msg);
							if (msg =='CONNECT_ERR')
							{
								
								$('#threadRegErrDIV').html('Veritabanımıza bağlanamıyoruz. Bu sorunu en kısa sürede gidericez');
								$('#threadRegErrDIV').show(100);
							}
							if (msg== 'QUERY_ERR')
							{
								
								$('#threadRegErrDIV').html('Veritabanımızla ilgili sıkıntılar yaşıyoruz. Bu sorunu en kısa sürede gidericez');
								$('#threadRegErrDIV').show(100);
							}
							if (msg == 'STEP_COUNT_NO_MATCH')
							{
								
								$('#threadRegErrDIV').html('Tamamlamadığınız adımlar mevcut.');
								$('#threadRegErrDIV').show(100);
							}
							if (msg =='BASLIK_YANLIS')
							{
								
								$('#threadRegErrDIV').html('Başlığınız formata uygun değil. Örnek başlıkları görmek için yukarıdaki soru işaretine tıklayabilirsiniz');
								$('#threadRegErrDIV').show(100);
							}
							if (msg == 'STEP_COUNT_ERR')
							{
								
								$('#threadRegErrDIV').html('Bir site politikası olarak bu başlıkla ilgili en az 2 adım yazmanızı umuyoruz.');
								$('#threadRegErrDIV').show(100);
							}
							if (msg=='OK')
								window.location.href=$('#threadLinkiInput').val();
							
						},
						error : function(){
																 
							$('#threadRegErrDIV').html('Başlık Creator Ltd Şti çok fena sıçtı. Bu sorunu en kısa sürede düzelticez.');
							$('#threadRegErrDIV').show(100);
						}
					}).submit();
				});		
							
				$('#yeni_adim_ekle_button').click(function(){
					$(\".find_next_step_form\").ajaxForm({
						success : function(msg){
							msg= $.parseJSON(msg);
							if (msg==='MAX_SIZE_REACHED'){
								$('#daha_fazla_adim_ekleyemezsin').show(50);	
							}
							else {
								$('#show_step_'+msg).show(100);
								$('#how_many_steps_there_are').val(msg);
								$('#how_many_steps_there_are2').val(msg);
								for (i=1;i<=10;i++)
								{
									strVal = i.toString();
									if (strVal===msg)
										$('#stepCreatorID_'+strVal).show();
									else
										$('#stepCreatorID_'+strVal).hide();
								}
								$('#upmenu_yeni_baslik_modal').scrollTop(0);
							}
						},
						error : function(){
							alert(\"Site sıçtı.\");
						}
					}).submit();
				});
			});

			$('#link_step_1').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").show();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});

			$('#link_step_2').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").show();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});

			$('#link_step_3').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").show();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});

			
			$('#link_step_4').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").show();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});
			
			$('#link_step_5').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").show();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});

			
			$('#link_step_6').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").show();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});
			
			$('#link_step_7').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").show();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});
			
			$('#link_step_8').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").show();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});
			
			$('#link_step_9').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").show();
				$(\"#stepCreatorID_10\").hide();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});
			
			$('#link_step_10').click(function(event){
				event.preventDefault();
				$(\"#stepCreatorID_1\").hide();
				$(\"#stepCreatorID_2\").hide();
				$(\"#stepCreatorID_3\").hide();
				$(\"#stepCreatorID_4\").hide();
				$(\"#stepCreatorID_5\").hide();
				$(\"#stepCreatorID_6\").hide();
				$(\"#stepCreatorID_7\").hide();
				$(\"#stepCreatorID_8\").hide();
				$(\"#stepCreatorID_9\").hide();
				$(\"#stepCreatorID_10\").show();
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});

			$('#baslik_help').click(function() {
				$(\"#baslik_help_div\").html(\"Örnek başlıklar: <br>' Duvara nasıl uçan kafa atılır ? ' <br> ' Aya nasıl gidilir ? ' <br> ' Makarna sosu nasıl hazırlanır ? '\");
				if ($(\"#baslik_help_div\").is(\":visible\"))
				{
					$(\"#baslik_help_div\").hide(500);
					$(\"#baslik_help\").html(\"(?)\");
				}				
				else
				{
					$(\"#baslik_help_div\").show(500);
					$(\"#baslik_help\").html(\"(¿)\");

				}
			});
			$('#submitbtn2').click(function() {
				$('#yukleme_sorunu2').hide(500);
				$('#yukleme_sorunu2').html('');
				$(\".uploadform2\").ajaxForm({
					success : function(msg){
						status = msg.substring(0,1);
						mesaj = msg.substring(1);
						if (status==1)
						{
							$('#yuklenenResimThread').attr(\"src\",mesaj);
							$('#wrapper_kreator2').show(500);
							$('#wrapper_upload2').hide(500);
							$('#resim_linki2').val(mesaj);	

						}
						else
						{
							$('#yukleme_sorunu2').html(mesaj);
							$('#yukleme_sorunu2').show(500);
						}
					},
					error : function(){
						$('#yukleme_sorunu2').html('Resim yukleme servisi ltd sti cok fena sicti. Bu sebeple resminizi yukleyemiyoruz.');
					}
				}).submit();
			});			
		</script>";
}



}

?>
