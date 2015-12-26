<?php
include_once ("classes/Message.class.php");
include_once ("classes/MessageSeenFinder.class.php");
include_once ("classes/DBConnector.class.php");
class Conversation
{

var $conversationInfos = array();

public function Conversation($ary)
{
	global $conversationInfos;
	$conversationInfos["User1"] = $ary[0];
	$conversationInfos["User2"] = $ary[1];
	$conversationInfos["WhoIsMonitoring"]  = $ary[2];
	if ($conversationInfos["WhoIsMonitoring"]==$conversationInfos["User1"])
		$conversationInfos["other"] = $conversationInfos["User2"];
	else
		$conversationInfos["other"] = $conversationInfos["User1"];
}

public function GetLastMessage()
{
	global $conversationInfos;
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		echo "Database bağlantı hatası";
	else
	{
		mysqli_set_charset($connection,"utf8");
		$query = "SELECT * FROM messages WHERE ((From_msg='".$conversationInfos["User1"]."' AND To_msg='".$conversationInfos["User2"]."') OR (From_msg='".$conversationInfos["User2"]."' AND To_msg='".$conversationInfos["User1"]."')) ORDER BY MessageDate DESC LIMIT 1";
		$results = $connection->query($query);
		$myRes = $results->fetch_assoc();
		echo "<p style=\"color:#ec583a;\">";
			echo $conversationInfos["other"]."  ";
		echo "</p>";
		echo "<p style=\"color:#6e6e6e;\">";
			echo htmlspecialchars($myRes["Message"]);
		echo "</p>";
		echo "<p style=\"color:#6e6e6e;font-size:12px;font-style:italic;\">";
			echo "(".$myRes["MessageDate"].")";
		echo "</p>";

		
		$connection->close();	
	}		
}

public function LoadMessages()
{
	global $conversationInfos;
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();	
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection->connect_error)
		echo "Database bağlantı hatası";
	else
	{
		mysqli_set_charset($connection,"utf8");
		$query = "SELECT * FROM messages WHERE ((From_msg='".$conversationInfos["User1"]."' AND To_msg='".$conversationInfos["User2"]."') OR (From_msg='".$conversationInfos["User2"]."' AND To_msg='".$conversationInfos["User1"]."'))";
		$results = $connection->query($query);
		$num = $results -> num_rows;
		echo "<form style=\"display:none;\" id=\"offsetForm_".$conversationInfos["other"]."\" method=\"post\" action=\"instantmessage.php?usr1=".$conversationInfos["User1"]."&usr2=".$conversationInfos["User2"]."&monitor=".$conversationInfos["WhoIsMonitoring"]."\">";
		echo "<input name=\"offset\" id=\"offset_".$conversationInfos["other"]."\" style=\"display:none;\" type=\"text\" value=\"".$num."\"/>";
		echo "</form>";
		while ($curResult = $results->fetch_assoc())
		{
			if ($conversationInfos["WhoIsMonitoring"]==$curResult["From_msg"])
				$mode = "EvSahibi";
			else
				$mode = "Deplasman";
			$myMessage = new Message(array($curResult["MessageDate"],$curResult["From_msg"],$curResult["To_msg"],$curResult["Message"],$mode,$curResult["Read_msg"]));
			$myMessage->MessageToHTML();
		}
		$connection->close();
	}
}

public function ConversationToHTML()
{
	global $conversationInfos;
	
	if ($conversationInfos["WhoIsMonitoring"]==$conversationInfos["User1"]){
		$other = $conversationInfos["User2"];
		$fr = $conversationInfos["User1"];
	}
	else{
		$fr = $conversationInfos["User2"];
		$other = $conversationInfos["User1"];
	}

	$myMessageSeenFinder = new MessageSeenFinder(array($other,$fr));
	echo "<div id=\"genel_conv_".$other."\" style=\"border-bottom:1px solid #c7d0d5;overflow:auto;background-color:#e6e6e6;max-width:100%;width:100%;\">";
		if ($myMessageSeenFinder->Find()==="YES")
		echo "<div onmouseout=\"this.style.background='#e6e6e6';\" onmouseover=\"this.style.background='#e9e9e9';\" id=\"show_conv_div_".$other."\" style=\"box-shadow:0 0 5px 5px #9bca3e inset;white-space:nowrap;text-overflow: ellipsis;height:115px;max-height:115px;overflow:hidden;padding:1%;font-size:17px;font-family: 'Josefin Sans', sans-serif;\">";
		else
		echo "<div onmouseout=\"this.style.background='#e6e6e6';\" onmouseover=\"this.style.background='#e9e9e9';\" id=\"show_conv_div_".$other."\" style=\"white-space:nowrap;text-overflow: ellipsis;height:115px;max-height:115px;overflow:hidden;padding:1%;font-size:17px;font-family: 'Josefin Sans', sans-serif;\">";
			echo "<a title=\"Konuşmayı görüntülemek için tıklayın.\" id=\"show_conv_a_".$other."\" href=\"#conv_holder_".$other."\" style=\"text-decoration:none;\">";
				$this->GetLastMessage();
			echo "</a>";
		echo "</div>";
		echo "<div id=\"conv_holder_".$other."\" style=\"display:none;\">";
			echo "<div style=\"overflow:hidden;border-bottom:1px solid #c7d0d5;\">";
				echo "<a id=\"hide_conv_a_".$other."\" title=\"Konuşmayı küçült\" href=\"#\" style=\"decoration:none;\">";
						echo "<i style=\"float:right;\" class=\"fa fa-2x fa-minus-square \"></i>
";
				echo "</a>";
				echo "<span style=\"font-family: 'Josefin Sans', sans-serif;font-size:17px;color:#ec583a;float:left;\">";
					echo $other." ile senin aranda .";
				echo "<span>";
			echo "</div>";
			echo "<div id=\"conv_".$other."\" style=\"border-bottom:1px solid #c7d0d5;overflow:auto;max-height:450px;\">";
				$this->LoadMessages();
			echo "</div>";
			echo "<form class=\"\" id=\"sendmsgForm_".$other."\" action=\"sendmsg.php?from=".$fr."&to=".$other."\" method=\"post\">";
			echo "<div id=\"SendMSGErrDIV_".$other."\" style=\"font-family: 'Josefin Sans', sans-serif;font-size:14px;color:#d1334e;display:none;margin-left:2%;margin-top:1%;\">";
			echo "</div>";
			echo "<div style=\"padding:2%;font-size:20px;font-family: 'Josefin Sans', sans-serif;\" class=\"input-group\">";
			
					echo "<textarea id=\"messageholder_".$other."\" name=\"messageholder\" class=\"form-control\" rows=\"3\" style=\"resize:none;\" maxlength=\"500\" placeholder=\"".$other." kullanıcısına mesaj yaz\"></textarea>";
					echo "<span  id=\"sendMsgBut_".$other."\" title=\"Gönder\" class=\"input-group-addon btn btn-success\"><i class=\"fa fa-2x fa-paper-plane\"></i></span>";
			echo "</div>";
			echo "</form>";
		echo "</div>";
		echo "<form id=\"conversationHeaderUpdateForm_".$other."\" style=\"display:none;\" method=\"post\" action=\"conversationHeaderUpdate.php?usr1=".$fr."&usr2=".$other."\"></form>";
		echo "<form id=\"conversationHeaderSeenUpdateForm_".$other."\" style=\"display:none;\" method=\"post\" action=\"MessageSeenHeaderUpdate.php?from=".$fr."&to=".$other."\"></form>";
	echo "</div>";
	echo "<script type=\"text/javascript\">";
		echo "
			$(document).keypress(function(e) {
				$('#SendMSGErrDIV_".$other."').hide();
    				if(e.which == 13 && !e.shiftKey) {
					$('#sendMsgBut_".$other."').blur();
					if ($('#conv_holder_".$other."').is(':visible')){
					e.preventDefault();
					if ($('#messageholder_".$other."').val()!='')
        				$('#sendmsgForm_".$other."').ajaxForm({
					success : function(msg){
						$('#messageholder_".$other."').val('');	
					},
					error : function(){
						alert(\"Mesaj gönderici ltd şti sıçtı.\");
					}
				}).submit();	
					else
					{
						$('#SendMSGErrDIV_".$other."').html('Boş mesaj yollamak hiç hoş bir hareket değil.');
						$('#SendMSGErrDIV_".$other."').show(500);
					}
				return false;
    				}
				}
			});
			$('#hide_conv_a_".$other."').click(function(){
				$('#conv_holder_".$other."').hide();
				$('#show_conv_div_".$other."').show();
				$('#conversationHeaderSeenUpdateForm_".$other."').ajaxForm({
					success : function(msg){
						if (msg=='NO')
							$('#show_conv_div_".$other."').css(\"box-shadow\",\"none\");
					},
					error: function(){
					}
				}).submit();
				$('#genel_conv_".$other."').css('margin-top','');
				$('#genel_conv_".$other."').css('margin-bottom','');
			});
			$('#show_conv_a_".$other."').click(function(){
				$('#show_conv_div_".$other."').hide();
				$('#conv_holder_".$other."').show();
				var element = document.getElementById('conv_".$other."');
				element.scrollTop = element.scrollHeight;
				$('#genel_conv_".$other."').css('margin-top','2%');
				$('#genel_conv_".$other."').css('margin-bottom','2%');
			});
			$('#sendMsgBut_".$other."').click(function(){
				$('#SendMSGErrDIV_".$other."').hide();
				if ($('#messageholder_".$other."').val()!='')
				$('#sendmsgForm_".$other."').ajaxForm({
					success : function(msg){
						$('#messageholder_".$other."').val('');	
					},
					error : function(){
						alert(\"Mesaj gönderici ltd şti sıçtı.\");
					}
				}).submit();
				else
				{
					$('#SendMSGErrDIV_".$other."').html('Boş mesaj yollamak hiç hoş bir hareket değil.');
					$('#SendMSGErrDIV_".$other."').show(500);
				}
			});
			setInterval(function() {
				if ($('#conv_holder_".$other."').is(':visible'))
				$('#offsetForm_".$conversationInfos["other"]."').ajaxForm({
					success : function(msg){
						if (msg!='NO_NEW')
							if(msg!='CONNECT_ERR'){
								var count = (msg.match(/messageWrapperDIV/g) || []).length;
								var oldcount = parseInt($('#offset_".$other."').val());
								$('#offset_".$other."').val(count+oldcount);
								$('#conv_".$other."').append(msg);
								var element = document.getElementById('conv_".$other."');
								element.scrollTop = element.scrollHeight;
							}
					},
					error : function(){
						
					}
				}).submit();	
				$('#conversationHeaderUpdateForm_".$other."').ajaxForm({
					success : function(msg){
						$('#show_conv_a_".$other."').html(msg);	
					},
					error : function(){
					
					}
				}).submit();
				if ($('#show_conv_div_".$other."').is(':visible'))
				$('#conversationHeaderSeenUpdateForm_".$other."').ajaxForm({
					success : function(msg){
						if (msg=='YES')
							$('#show_conv_div_".$other."').css(\"box-shadow\",\"0 0 5px 5px #9bca3e inset\");
					},
					error: function(){
					}
				}).submit();		
			}, 1000)
		";
	echo "</script>";
}

}

?>
