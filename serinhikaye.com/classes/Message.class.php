<?php

class Message
{

var $messageInfos = array();

public function Message($ary)
{
	global $messageInfos;
	
	$messageInfos["Message Date"] = $ary[0];
	$messageInfos["From"] = $ary[1];
	$messageInfos["To"] = $ary[2];
	$messageInfos["Message"] = $ary[3];
	$messageInfos["Mode"]= $ary[4];
	$messageInfos["Read"]=$ary[5];
}

public function MessageToHTML()
{
	global $messageInfos;
	if ($messageInfos["Mode"]=="EvSahibi"){
	echo "<div title=\"".$messageInfos["Message Date"]."\" id=\"messageWrapperDIV\" style=\"position:relative;clear:both;float:left;margin-left:2%;margin-top:2%;margin-bottom:1%;padding:1%;border:1px solid #c7d0d5;border-radius:15px;background-color:#9bca3e;width: 100%; max-width:40%;\">";
		echo "<p style=\"text-align:left;word-wrap:break-word;font-size:18px;color:#5bc236;font-family: 'Josefin Sans', sans-serif;width:100%\">";
			echo "<a href=\"user.php?name=".$messageInfos["From"]."\">";
				echo $messageInfos["From"].":";
			echo "</a>";
			echo "<br/>";
			echo "<span style=\"color:#ffffff;\">";
				echo htmlspecialchars(nl2br($messageInfos["Message"]));
			echo "</span>";
		echo "</p>";
	echo "</div>";
	}
	else
	{
	echo "<div title=\"".$messageInfos["Message Date"]."\" id=\"messageWrapperDIV\" style=\"position:relative;clear:both;float:right;margin-right:2%;margin-top:2%;margin-bottom:1%;padding:1%;border:1px solid #c7d0d5;border-radius:15px;background-color:#ffb92a;width: 100%; max-width:40%;\">";
		echo "<p style=\"text-align:left;word-wrap:break-word;font-size:18px;color:#5bc236;font-family: 'Josefin Sans', sans-serif;width:100%\">";
			echo "<a href=\"user.php?name=".$messageInfos["From"]."\">";
				echo $messageInfos["From"].":";
			echo "</a>";
			echo "<br/>";
			echo "<span style=\"color:#ffffff;\">";
				echo htmlspecialchars(nl2br($messageInfos["Message"]));
			echo "</span>";
		echo "</p>";
	echo "</div>";
	}
}

}

?>
