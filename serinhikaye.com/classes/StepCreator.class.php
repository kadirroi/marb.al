<?php
include_once ("Step.class.php");
class StepCreator
{ /* class baslangici */

var $stepInfos = array ();

public function StepCreator($ary)
{
	global $stepInfos;
	$stepInfos ['Step Numarasi']  = $ary[0]; /* integer: su an kac numarali stepi olusturuyoruz ? */
	$stepInfos['Baslik ID'] = $ary[1]; /* integer : su an olusturdugumuz step hangi basliga ait ?*/
	$stepInfos['Form Linki'] = "stepRegisterer.php?stepNo=".$stepInfos['Step Numarasi']."&threadID=".$stepInfos['Baslik ID'];
	$stepInfos['Delete Linki'] = "stepEreaser.php?stepNo=".$stepInfos['Step Numarasi']."&threadID=".$stepInfos['Baslik ID'];
}

public function StepCreatorToHTML () /* StepCreator'ı ekranda HTML formunda gösterir */
{
	global $stepInfos;
	/* resim yükleme şeysinin wrapper div'i */
	echo "<div id=\"wrapper_upload_".$stepInfos['Step Numarasi']."\" style=\"background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
		echo "<div style=\"margin-top:1%;margin-left:5%;color:#6e6e6e;font-size:24px;font-family:Verdana,Geneva,sans-serif;\">";
			echo "<span>";
				echo "Adım ".$stepInfos['Step Numarasi'].": ";
			echo "</span>";
		echo "</div>";
		echo "<form class=\"uploadform_".$stepInfos['Step Numarasi']."\" method=\"post\" enctype=\"multipart/form-data\" action='imageUploader.php'>";
			echo "<div id=\"derinnefes\" style=\"margin-top:2%;margin-left:5%;font-size:20px;font-family: Verdana,Geneva,sans-serif;color:#6e6e6e;\">";
				echo "Derin bir nefes alın ve birazdan yazacaklarınızı açıklayan harika bir resim seçin";
			echo "</div>";
			echo "<div id=\"uploadbuts\" style=\"margin-bottom:3%;margin-top:3%; margin-left:5%; margin-right:5%;\">";			 
				echo "<input type=\"file\" class=\"btn btn-primary btn-block\" title=\"Resim Seç\" name=\"imagefile\"data-filename-placement=\"inside\"/>";			
				echo "<button type=\"button\"class=\"btn btn-success btn-block\" value=\"Yükle\" id=\"submitbtn_".$stepInfos['Step Numarasi']."\">Yükle</button>";
			echo "</div>";	
		echo "</form>";
		echo "<div id=\"yukleme_sorunu_".$stepInfos['Step Numarasi']."\" style=\"font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;margin-top:3%;margin-left:5%;margin-bottom:3%;\"> </div>";
		// vine
		echo "<div style=\"margin-top:1%;margin-left:5%;color:#6e6e6e;font-size:20px;font-family:Verdana,Geneva,sans-serif;\">";
			echo "<div style=\"margin-bottom:2%;\">";			
			echo "<span style=\"color:#00a478;\">";
				echo "Veya "."<i style=\"color:#00a478;\" class=\"fa fa-vine\"></i>"."ine videosu yükleyin :";
			echo "</span>";
			echo "</div>";
			echo "<div class=\"input-group\" style=\"margin-bottom:2%;padding-right:10%;\">";
				echo "<form id=\"vine_form_step_".$stepInfos['Step Numarasi']."\" method=\"post\" action=\"vineFrameHazirlayici.php\">";
				echo "<input name=\"vine_link_input\" id=\"vine_link_input_step_".$stepInfos['Step Numarasi']."\" autocomplete=\"off\" type=\"text\" class=\"form-control\" placeholder=\"Vine linki , örnek : https://vine.co/v/bjHh0zHdgZT\"/>";
				echo "</form>";
				echo "<div class=\"input-group-btn\" style=\"\">";
					echo "<button id=\"vine_yukle_button_step_".$stepInfos['Step Numarasi']."\" title=\"Yükle\" class=\"btn btn-success\"><i class=\"fa fa-check\"></i></button>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
	/****************************************/

	/* başlık oluşturma şeysinin wrapper div'i*/
	echo "<div id=\"wrapper_kreator_".$stepInfos['Step Numarasi']."\" style=\"display:none;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
		echo "<div id=\"kretor_form\" style=\"overflow:hidden;\">";
			echo "<form class=\"stepCreatorForm_".$stepInfos['Step Numarasi']."\" method=\"post\" action=\"".$stepInfos['Form Linki']."\" onkeydown=\"return ignoreEnter(event);\">";
				echo "<div id=\"sayi_ve_baslik_div\"style=\"color:#6e6e6e;padding-top:1%;font-size:24px;font-family:Verdana,Geneva,sans-serif;margin-left:6%;width:50%;max-width:50%;\">";
					echo "Adım ".$stepInfos['Step Numarasi'].": ";
					echo "<input type=\"text\" class=\"form-control\" style=\"font-size:17px;font-family: Verdana,Geneva,sans-serif;max-width:100%;margin-top:1%;\" name=\"basliktxt_".$stepInfos['Step Numarasi']."\" id=\"basliktxt_".$stepInfos['Step Numarasi']."\" maxlength=\"80\" size=\"25\"value=\"Başlık\" title=\"Bu adımın başlığını buraya yazın.\"/>";
				echo "</div>";
				echo "<div id=\"vine_vid_div_".$stepInfos['Step Numarasi']."\" style=\"display:none;width:600;height:600;\"></div>";
				echo "<img id=\"yuklenenResimStep_".$stepInfos["Step Numarasi"]."\" class=\"preview\" alt=\"yuklenen_resim\" src=\"\" style=\"display:none;margin-left:6%;margin-top:2%;max-width:80%;\"/>";
			 	echo "<input style=\"display:none;\" type=\"text\" name=\"resim_linki\" id=\"resim_linki_".$stepInfos['Step Numarasi']."\" value=\"\"/>";
				echo "<div id=\"icerik_ve_post_butonu\" style=\"padding-bottom:2%;overflow:auto;\">";
					echo "<div id=\"icerik\" style=\"color:#6e6e6e;font-size:17px;font-family: Verdana,Geneva,sans-serif;overflow:auto;\">";
						echo "<textarea name=\"icerikholder_".$stepInfos['Step Numarasi']."\" id=\"icerikholder_".$stepInfos['Step Numarasi']."\" class=\"form-control\"  spellcheck=\"false\" style=\"font-size:17px;font-family: Verdana,Geneva,sans-serif;margin-left:6%;margin-top:1%;resize:none;max-width:75%;\" maxlength=\"1000\" rows=\"10\" cols=\"10\">Bu adımla ilgili, bilgilendirici bir metin yazın. </textarea>";
						
					echo "</div>";
					echo "<div id=\"baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."\" style=\"font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;margin-top:3%;margin-left:6%;margin-bottom:3%;\">";
					echo"</div>";
					echo "<div id=\"yeniden_yukle_ve_yayinla_butonu\" style=\"margin-bottom:3%;margin-top:2%;margin-right:18%;margin-left:6%;\">";
						echo "<button type=\"button\" class=\"btn btn-success btn-block\" id=\"publish_".$stepInfos['Step Numarasi']."\">Kaydet</button>";
						echo "<button type=\"button\" class=\"btn btn-primary btn-block\" id=\"reupload_".$stepInfos['Step Numarasi']."\">";
							echo "Resmi değiştir";
						echo "</button>";
					echo "</div>";
				echo "</div>";
			echo "</form>";
		echo "</div>";
	echo "</div>";
	/*****************************************/

	
	/* eğer başlık başarılı bir şekilde kaydolursa ekranda gözüken div*/
	
		echo "<div id=\"wrapper_success_".$stepInfos['Step Numarasi']."\" style=\"display:none;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
			echo "<div id =\"successimgdiv\">";
				echo "<img src =\"images/success.gif\" style=\"display:block;max-width:30%;margin-top:5%;margin-left:auto;margin-right:auto;\" alt=\"image\">";
			echo "</div>";
			echo "<div id=\"success_textdiv\" style=\"font-size:17px;font-family: Verdana,Geneva,sans-serif;overflow:auto;width:100%;\">";
				echo "<p id=\";aciklama\" style=\"color:#ec583a;text-align:center;width:70%;padding-top:5%;padding-left:30%;\">";
					echo "\"Adım ".$stepInfos['Step Numarasi']."\" başarıyla kaydedildi!";
				echo "</p>";
			echo "</div>";
			echo "<div id=\"duzenle_button_div\" style=\"margin-top:3%; margin-bottom:3%; margin-left:20%; margin-right:20%;\">";
				echo "<div id=\"duzenlesorunu_".$stepInfos['Step Numarasi']."\" style=\"font-family: Verdana,Geneva,sans-serif;font-size:14px;color:#d1334e;display:none;margin-top:3%\"></div>";
				echo "<form class=\"yapilanlariduzenle_".$stepInfos['Step Numarasi']."\" method=\"post\" action=\"".$stepInfos['Delete Linki']."\" >";					
					echo "<button type=\"button\" class=\"btn btn-primary btn-block\" id=\"duzenlebutton_".$stepInfos['Step Numarasi']."\"> Yaptıklarımı değiştiricem </button>";
				echo "</form>";
			echo "</div>";	
		echo "</div>";

	/*****************************************************************/

	echo "<script type=\"text/javascript\" >
		$(document).ready(function() {
			$('#vine_yukle_button_step_".$stepInfos['Step Numarasi']."').click(function(){
				if ($('#vine_link_input_step_".$stepInfos['Step Numarasi']."').val()=='')
					alert(\"Bir adet Vine linki girmeniz gerekmekte.\");
				else
				$(\"#vine_form_step_".$stepInfos['Step Numarasi']."\").ajaxForm({
					success : function(msg){
						if (msg=='GECERSIZ_LINK')
							alert(\"Girdiğiniz vine linki şu formatta olmalı : https://vine.co/v/bjHh0zHdgZT\");
						else
						{
							$('#vine_vid_div_".$stepInfos['Step Numarasi']."').html(msg);
							$('#wrapper_kreator_".$stepInfos['Step Numarasi']."').show(500);
							$('#wrapper_upload_".$stepInfos['Step Numarasi']."').hide(500);
							$('#resim_linki_".$stepInfos['Step Numarasi']."').val($('#vine_link_input_step_".$stepInfos['Step Numarasi']."').val());
							$('#vine_vid_div_".$stepInfos['Step Numarasi']."').show();
						}
					},
					error : function(){
						alert(\"Bir hata oldu :(\");
					}
				}).submit();		
			});
			$('#submitbtn_".$stepInfos['Step Numarasi']."').click(function() {
				$(\"#viewimage_".$stepInfos['Step Numarasi']."\").html('');
				$('#yukleme_sorunu_".$stepInfos['Step Numarasi']."').hide(500);
				$('#yukleme_sorunu_".$stepInfos['Step Numarasi']."').html('');

				$(\".uploadform_".$stepInfos['Step Numarasi']."\").ajaxForm({
					success : function(msg){
						status = msg.substring(0,1);
						mesaj = msg.substring(1);
						if (status==1)
						{
							$('#yuklenenResimStep_".$stepInfos['Step Numarasi']."').attr(\"src\",mesaj);
							$('#yuklenenResimStep_".$stepInfos['Step Numarasi']."').show();
							$('#wrapper_kreator_".$stepInfos['Step Numarasi']."').show(500);
							$('#wrapper_upload_".$stepInfos['Step Numarasi']."').hide(500);
							$('#resim_linki_".$stepInfos['Step Numarasi']."').val(mesaj);	
							
						}
						else
						{
							$('#yukleme_sorunu_".$stepInfos['Step Numarasi']."').html(mesaj);
							$('#yukleme_sorunu_".$stepInfos['Step Numarasi']."').show(500);
						}	
					},
					error : function(){
						$('#yukleme_sorunu_".$stepInfos['Step Numarasi']."').html('Resim yukleme servisi ltd sti cok fena sicti. Bu sebeple resminizi yukleyemiyoruz.');
					}
				}).submit();
			});			
			
			$('#duzenlebutton_".$stepInfos['Step Numarasi']."').click(function(){
				$(\".yapilanlariduzenle_".$stepInfos['Step Numarasi']."\").ajaxForm({
					success : function(msg){
						if (msg=='OK')
						{
							$('#wrapper_success_".$stepInfos['Step Numarasi']."').hide(500);
							$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').hide(500);
							$('#wrapper_kreator_".$stepInfos['Step Numarasi']."').show(500);
						}
						if (msg=='CONNECT_ERR')
						{
							$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').html('Şu an veritabanına bağlanamıyoruz.Bu sorunu en kısa sürede gidermeye çalışıcaz.');
							$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').show(500);
						}
						if (msg=='QUERY_ERR')
						{
							$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').html('Şu an veritabanımızla ilgili bazı sıkıntılar yaşadık.Bu sorunu en kısa sürede gidermeye çalışıcaz.');
							$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').show(500);
						}
					},
					error : function(){
						$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').html('Gönderi düzeltme ltd şti çok fena sıçtı.Bu sorunu düzeltmek üzere bir ekip gönderdik.');			
						$('#duzenlesorunu_".$stepInfos['Step Numarasi']."').show(500);
					}
				}).submit();
			});
			
			$('#publish_".$stepInfos['Step Numarasi']."').click(function(){
				$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').hide(500);
				$('.stepCreatorForm_".$stepInfos['Step Numarasi']."').ajaxForm({
					success : function(msg)
					{
						if (msg=='OK')
						{
							$('#wrapper_success_".$stepInfos['Step Numarasi']."').show(500);
							$('#wrapper_kreator_".$stepInfos['Step Numarasi']."').hide(500);
							$('#upmenu_yeni_baslik_modal').scrollTop(0);
						}
						if (msg=='ICERIK_BOS')
						{
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').html('İçerik kısmını boş bırakmışsınız.');
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').show(500);
						
						}
						if (msg=='BASLIK_BOS')
						{
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').html('Başlık kısmını boş bırakmışsınız');
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').show(500);
						
						}
						if (msg=='CONNECT_ERR')
						{
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').html('Şu an veritabanımıza bağlanamıyoruz.Bu sorunu en kıs sürede gidermeye çalışıcaz.');
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').show(500);
						
						}
						if (msg=='QUERY_ERR')
						{
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').html('Şu an veritabanımızla ilgili sıkıntılar yaşıyoruz.Bu sorunu en kısa sürede gidermeye çalışıcaz');
							$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').show(500);
				
						}
						
					},
					error : function()
					{
						$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').html('Başlık oluşturma ltd şti sıçtı, bu sorunu en kısa sürede gidermeye çalışıcaz');
						$('#baslikKreatorErrDIV_".$stepInfos['Step Numarasi']."').show(500);
					}
				}).submit();
			});

			$('#reupload_".$stepInfos['Step Numarasi']."').click(function(){
				$('#vine_vid_div_".$stepInfos['Step Numarasi']."').hide();
				$('#yuklenenResimStep_".$stepInfos['Step Numarasi']."').hide();
				$('#wrapper_upload_".$stepInfos['Step Numarasi']."').show(500);
				$('#wrapper_kreator_".$stepInfos['Step Numarasi']."').hide(500);
				$('#upmenu_yeni_baslik_modal').scrollTop(0);
			});
			
			$('#icerikholder_".$stepInfos['Step Numarasi']."').focus(function(event){
				$(this).text(\"\");
				$(this).unbind(event);
			});

			$('#basliktxt_".$stepInfos['Step Numarasi']."').focus(function(event){
				$(this).val(\"\");
				$(this).unbind(event);
			});
			function ignoreEnter(event)
			{
  				if (event.keyCode == 13) {
				event.preventDefault();
    				return false;
  			}
}

		});
	</script>";
}

} /* Class bitişi */
?>
