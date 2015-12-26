<?php

class MessageSender
{

	var $MessageSenderInfos = array ();

	public function MessageSender($ary)
	{
		global $MessageSenderInfos;
		$MessageSenderInfos["Kimden"] = $ary[0];
		$MessageSenderInfos["Kime"] = $ary[1];
	}

	public function MessageSenderToHTML()
	{
		global $MessageSenderInfos;
		echo "<form id=\"messagesenderform\" method=\"post\" action=\"sendMessageToUser.php?kimden=".$MessageSenderInfos["Kimden"]."&kime=".$MessageSenderInfos["Kime"]."\">";
			echo "<div style=\"font-family: Verdana,Geneva,sans-serif;font-size:19px;\" class=\"input-group\">";
				echo "<textarea id=\"messagesendertextarea\" name=\"messagesendertextarea\" class=\"form-control\" rows=\"3\" style=\"resize:none;\" maxlength=\"500\" placeholder=\"".$MessageSenderInfos["Kime"]." kullanıcısına mesaj yaz\"></textarea>";
				echo "<span  id=\"messagesenderbutton\" title=\"Gönder\" class=\"input-group-addon btn btn-success\"><i class=\"fa fa-2x fa-paper-plane\"></i></span>";
			echo "</div>";
		echo "</form>";

		echo "<script type=\"text/javascript\">";
			echo "
				
				$('#messagesenderbutton').click(function(){
					if ($('#messagesendertextarea').val()!='')
					$('#messagesenderform').ajaxForm({
						success : function(msg)
						{
							if (msg!='OK')
								alert('Bir hata oldu ve mesajınızı yollayamadık.');
							else{
								alert('Mesajınız başarıyla yollandı');
								$('#mesaj_yollayici_modal').modal('toggle');
							}
						},
						error : function()
						{
							alert('Mesaj yollayıcı LTD ŞTİ sıçtı.');
						}
					}).submit();
					else
						alert('Boş mesaj yollamak hiç hoş bir davranış değil.');
				});
				
			";
		echo "</script>";
	}

}

?>
