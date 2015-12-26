<?php

class CategoryThreads
{

var $which;

public function CategoryThreads($w)
{

	global $which;
	$which = $w;

}

public function CategoryThreadsToHTML()
{
	global $which;
	if ($which=="a")
		$cat = "Alakasız";
	if ($which=="bk")
		$cat = "Bilim/Kültür";
	if ($which=="s")
		$cat = "si";
	if ($which=="ss")
		$cat = "Sağlık/Spor";
	if ($which=="yi")
		$cat = "Yemek/İçmek";
	if ($which=="be")
		$cat = "Bilgisayar/Elektronik";
	if ($which=="se")
		$cat = "Sanat/Eğlence";
	echo "<div id=\"order\"></div>";
	echo "<div style=\"padding-top:0.1%;\">";
		echo "<div style=\"margin:2%;border-bottom:1px solid #c7d0d5;padding-bottom:1%;\">";
			echo "<div style=\"\">";
			echo "<span style=\"color:#ec583a;font-family: 'Josefin Sans', sans-serif; font-size:23px;\">";
				echo "Bu kategoriden başlıklar";
			echo "</span>";
			echo "</div>";
		echo "</div>";
		echo "<div  style=\"margin:2%;padding-bottom:1%;\">";
			echo "<select style=\"width:165px;;background-color:#e6e6e6;color:#6e6e6e;font-family: 'Josefin Sans', sans-serif; font-size:15px;\" name=\"catThreadOrderSelect\" class=\"form-control\" id=\"sel1\">";
				echo "<option value=\"yenideneskiye\">Yeniden eskiye</option>";
				echo "<option value=\"iyidenkotuye\">Puana göre</option>";
			echo "</select>";
		echo "</div>";
		echo "<div style=\"\" id=\"catThreads\">";
		echo "</div>";
	echo "</div>";

	echo "<script type=\"text/javascript\">";
		echo "
			$(document).ready(function(){
				$(this).attr(\"title\",\"".$cat."\"+\" - serinhikaye.com\");
				$('#catThreads').html('<i style=\"color:#6e6e6e;\" class=\"fa fa-2x fa-refresh fa-spin\"></i>');
				$('#catThreads').load('categoryTariheGoreSirala.php?cat=".$cat."');
			});
			$('#sel1').change(function() {
				window.location.hash=\"#order\";
				var x = $(this).find(\":selected\").text();
				if (x==\"Yeniden eskiye\")
				{
					$('#catThreads').html('<i style=\"color:#6e6e6e;\" class=\"fa fa-2x fa-refresh fa-spin\"></i>');
					$('#catThreads').load('categoryTariheGoreSirala.php?cat=".$cat."');					
				}
				else
				{
					$('#catThreads').html('<i style=\"color:#6e6e6e;\" class=\"fa fa-2x fa-refresh fa-spin\"></i>');
					$('#catThreads').load('categoryPuanaGoreSirala.php?cat=".$cat."');	
				}
			});
		";
	echo "</script>";
}

}

?>

