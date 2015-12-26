<?php

$link = $_POST["vine_link_input"];

$ary1 = explode(":",$link);

if ($ary1[0]=="https" or $ary1[0]=="http")
{
	$ary2 = explode("/",$ary1[1]);
	if ($ary2[2]=="vine.co")
	{
		if ($ary2[3]=="v")
		{
			$embed = "<iframe class=\"vine-embed\" src=\"".$link."/embed/simple\" width=\"600\" height=\"600\" style=\"margin-left:6%;margin-top:2%;\" frameborder=\"0\"></iframe><script async src=\"https://platform.vine.co/static/scripts/embed.js\" charset=\"utf-8\" ></script>";
			echo $embed;
		}
		else
			echo "GECERSIZ_LINK";
	}
	else 
		echo "GECERSIZ_LINK";
}
else
	echo "GECERSIZ_LINK";

?>
