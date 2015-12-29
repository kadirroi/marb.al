<?php
include_once("classes/UserThreads.class.php");
include_once("classes/UserFavs.class.php");
include_once("classes/DBConnector.class.php");
class UserPageRight
{

	var $whichUser;

	public function UserPageRight($which)
	{
		global $whichUser;

		$whichUser = $which;
	}
	public function GetTop3()
	{
		global $whichUser;
		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();
		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

		if ($connection->connect_error)
			return false;
		else
		{
			$connection->set_charset("utf8");
			$ress0 = $connection->query("SELECT * FROM users WHERE userName = '$whichUser'");
			if ($ress0->num_rows==0)
			{
				echo "<script type=\"text/javascript\"> window.location='oops.php'; </script>";
			} 
			$query = "SELECT * FROM `threads` WHERE threadWriter='$whichUser' ORDER BY `threadPoint` DESC LIMIT 3 ";
			$results = $connection->query($query);
			if ($results->num_rows<3)
				return false;
			else
			{
				$returnAry = array();
				while ($curResult = $results->fetch_assoc())
				{
					$returnAry[] = $curResult["threadPicture"];
					$returnAry[] = $curResult["threadName"];
					$returnAry[] = $curResult["threadID"];
				}
				return $returnAry;
			}
		}
	}
	public function CarouselToHTML()
	{
		global $whichUser;
		if (($this->GetTop3())!==FALSE)
		{
		$ary = $this->GetTop3();
		echo "<div style=\"padding:2%;\">";
			echo "<p style=\"word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:20px;color:#ec583a;\">";
				echo "En iyi 3 eseri";	
			echo "</p>";
		echo "</div>";
		echo "<div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\" style=\"height:450px;\">";
			echo "<ol class=\"carousel-indicators\" style=\"bottom:0;\">";
				echo "<li data-target=\"#myCarousel\" data-slide-to=\"0\" class=\"active\"></li>";
				echo "<li data-target=\"#myCarousel\" data-slide-to=\"1\"></li>";
				echo "<li data-target=\"#myCarousel\" data-slide-to=\"2\"></li>";
			echo "</ol>";
			echo "<div class=\"carousel-inner\" role=\"listbox\">";
				echo "<div class=\"item active\" >";
					echo "<img src=\"".$ary[0]."\" alt=\"Chania\"/ style=\"margin:0 auto;max-height:450px;\">";
					echo "<div class=\"carousel-caption\" style=\"left:0;right:0;bottom:0;background:rgba(50,50,50,0.5);\">";
						echo "<a style=\"\" href=\"thread.php?id=".$ary[2]."\" class=\"btn btn-success\" title=\"Başlığı görüntüle\">";
						echo "<i class=\"fa fa-eye\"></i>";

						echo "</a>";
						echo "<h3 style=\"font-family: 'Josefin Sans', sans-serif;font-size:20px;\">".$ary[1]."</h3>";	
					
					echo "</div>";
				echo "</div>";
				echo "<div class=\"item\">";
					echo "<img src=\"".$ary[3]."\" alt=\"Flower\" style=\"margin:0 auto;max-height:450px;\"/>";
						echo "<div class=\"carousel-caption\" style=\"left:0;right:0;bottom:0;background:rgba(50,50,50,0.5);\">";
						echo "<a style=\"\" href=\"thread.php?id=".$ary[5]."\" class=\"btn btn-success\" title=\"Başlığı görüntüle\">";
						echo "<i class=\"fa fa-eye\"></i>";

						echo "</a>";
							echo "<h3 style=\"font-family: 'Josefin Sans', sans-serif;font-size:20px;\">".$ary[4]."</h3>";	
						echo "</div>";
				echo "</div>";
				echo "<div class=\"item\">";
					echo "<img src=\"".$ary[6]."\" alt=\"Flower\" style=\"margin:0 auto;max-height:450px;\"/>";
						echo "<div class=\"carousel-caption\" style=\"left:0;right:0;bottom:0;background:rgba(50,50,50,0.5);\">";
						echo "<a style=\"\" href=\"thread.php?id=".$ary[8]."\" class=\"btn btn-success\" title=\"Başlığı görüntüle\">";
						echo "<i class=\"fa fa-eye\"></i>";

						echo "</a>";
							echo "<h3 style=\"font-family: 'Josefin Sans', sans-serif;font-size:20px;\">".$ary[7]."</h3>";	
						echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<a class=\"left carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"prev\">";
				echo "<span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>";
				echo "<span class=\"sr-only\">Previous</span>";
			echo "</a>";
			echo "<a class=\"right carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"next\">";
				echo "<span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>";
				echo "<span class=\"sr-only\">Next</span>";
			echo "</a>";			
		echo "</div>";
		}
	}
	public function UserPageRightToHTML()
	{
		global $whichUser;

		echo "<div style=\"padding:2%;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;\">";
			$this->CarouselToHTML();
			echo "<br/>";
			echo "<ul class=\"nav nav-tabs\" style=\"font-family: 'Josefin Sans', sans-serif;font-size:17px;\">";
				echo "<li class=\"active\"><a href=\"#\" id=\"usr_threads_link\" data-toggle=\"tab\">Başlıkları</a></li>";
				echo "<li class=\"\"><a href=\"\" id=\"usr_fav_link\" data-toggle=\"tab\">Favorileri</a></li>";
			echo "</ul>";
			echo "<div class=\"tab-content\">";
				echo"<div class=\"tab-pane-active\" id=\"usr_threads_div\">";
					$myUserThreads = new UserThreads($whichUser);
					$myUserThreads->UserThreadsToHTML();
				echo "</div>";
				echo"<div class=\"tab-pane\" id=\"usr_fav_div\">";
					$myUserFavs = new UserFavs($whichUser);
					$myUserFavs->UserFavsToHTML();
				echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<script type=\"text/javascript\">";
			echo "
				$('#usr_threads_link').click(function(){
					$('#usr_fav_div').attr('class','tab-pane');
					$('#usr_threads_div').attr('class','tab-pane-active');
				});
				$('#usr_fav_link').click(function(){
					$('#usr_threads_div').attr('class','tab-pane');
					$('#usr_fav_div').attr('class','tab-pane-active');
				});
			";
		echo "</script>";

	}

}

?>