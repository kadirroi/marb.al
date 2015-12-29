<?php

class Category
{

var $category;

public function Category($which)
{
	global $category;
	$category = $which;
}

public function CategoryToHTML()
{
	
	include_once("classes/CategoryThreads.class.php");

	echo "<style media=\"screen\" type=\"text/css\">";
		echo "
			.thumbnail2 {
    				position:relative;
    				overflow:hidden;
			}
			.caption2 {
				padding-right:3%;
				padding-left:3%;
				position:absolute;
				top:2%;
				padding:2%;
				background:rgba(50,50,50,0.8);
				color :#e6e6e6;
				z-index:2;
				display:table;		
			}
		";
	echo "</style>";
	global $category;
	$i =0;
	echo "<div style=\"background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;\">";
	if ($category=="a")
	{
			$i++;
			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Alakasız";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"Uçan midilliler, gökkuşakları ve daha fazlası.\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/alaka.jpg\" alt=\"alakasiz\" style=\"margin-bottom:10%;max-width:100%;\"/>";
			
			echo "</div>";
		
	}
	if ($category=="bk")
	{
			$i++;
			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Bilim / Kültür";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"İsviçreli bilim adamları, Norveçli balıkçılar.\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/rdinth.jpg\" alt=\"bilim/kültür\" style=\"max-width:100%;\"/>";
			
			echo "</div>";
	
	}
	if ($category=="s")
	{
			$i++;
			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Sosyal ilişkiler";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"Eski sevgilinin yeni sevgilisi ve asansör sessizlikleri.\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/fd.jpg\" alt=\"sosyal ilişkiler\" style=\"max-width:100%;\"/>";
			
			echo "</div>";

	}
	if ($category=="ss")
	{	
		
			$i++;
			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Sağlık / Spor";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"Bench press ve karatay diyeti.\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/yoga.jpg\" alt=\"sağlık spor\" style=\"max-width:100%;\"/>";
			
			echo "</div>";
	
	}
	if ($category=="yi")
	{
			$i++;

			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Yemek / İçmek";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"Biraz kilo mu aldım ?\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/food2.jpg\" alt=\"yemek içmek\" style=\"max-width:100%;\"/>";
			
			echo "</div>";
	
	}
	if ($category=="be")
	{
			$i++;
			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Bilgisayar / Elektronik";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"Gamerlar, Freakler ve dahiler.\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/pc.gif\" alt=\"bilgisayar elektronik\" style=\"max-width:100%;\"/>";
			
			echo "</div>";
	
	}
	if ($category=="se")
	{
			$i++;
			echo "<div class=\"thumbnail2\" style=\"margin:2%;max-height:350px;\">";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption2\">";
					echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:28px;\">";
						echo "#Sanat / Eğlence";
					echo "</p>";
					echo "<p style=\"color:#ffffff;text-align:left;margin-left:2%;font-size:18px;\">";
						echo "<i>\"O tabloyu ben de çok seviyorum Selinsu.\"</i>";
					echo "</p>";	
				echo "</div>";
				echo "<img src=\"images/stary.jpg\" alt=\"sanat eğlence\" style=\"max-width:100%;\"/>";
			
			echo "</div>";
	}

	if ($i==0)
	{
		echo "<script type=\"text/javascript\">";
			echo "
				location.href=\"oops.php\";
			";
		echo "</script>";
	}
	$myCategoryThreads = new CategoryThreads($category);
	
	$myCategoryThreads->CategoryThreadsToHTML();

	echo "</div>";
}

}

?>