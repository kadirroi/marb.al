<?php
include_once("DBConnector.class.php");
include_once("BoardContributionCreator.class.php");
include_once("BoardContribution.class.php");
class Board
{

var $boardInfos = array();

public function Board($ary)
{

	global $boardInfos;

	$boardInfos['boardID'] = $ary[0];
	$boardInfos['boardName'] = $ary[1];
	$boardInfos['boardCategory'] = $ary[2];
	$boardInfos['boardCreator'] = $ary[3];
	$boardInfos['boardImage'] = $ary[4];
	$boardInfos['boardDate'] = $ary[5];
}

public function BoardToPetitHTML()
{

	global $boardInfos;

	$name2 = str_replace(" ","-",$boardInfos['boardName']);
	$name3 = str_replace("?","",$name2);
	$name4 = str_replace("ç","c",$name3);
	$name4 = str_replace("ğ","g",$name4);
	$name4 = str_replace("ı","i",$name4);
	$name4 = str_replace("ö","o",$name4);
	$name4 = str_replace("ş","s",$name4);
	$name4 = str_replace("ü","u",$name4);
	$name4 = str_replace("İ","i",$name4);
						$name4 = str_replace("Ç","C",$name4);
					$name4 = str_replace("Ğ","G",$name4);
					$name4 = str_replace("Ö","O",$name4);
					$name4 = str_replace("Ş","S",$name4);
					$name4 = str_replace("Ü","U",$name4);
					$name4 = str_replace("'","-",$name4);
					$name4 = str_replace("\"","-",$name4);
					$name4 = str_replace(",","-",$name4);

	echo "
	<a href=\"http://serinhikaye.com/board/".$boardInfos['boardID']."/".$name4."\">
 	<div style=\"display:inline-block;margin-left:2.5%;background-color:#e6e6e6;width:250px;height:200px;\" class=\"thumbnail\">
                <div style=\"font-family: 'Josefin Sans', sans-serif;font-size:18px;\" class=\"caption\">
			<p style=\"text-align:left;margin-left:2%;\">
				<span style=\"font-size:18px;\">
				".$boardInfos['boardName']."
				</span>
				
				<br/><br/>
				<span style=\"color:#e6e6e6;font-style:italic;font-size:18px;\">".$boardInfos['boardCreator']." tarafından başlatıldı.
				</span>
			</p>
			<p style=\"font-size:23px;font-style:bold;text-align:left;margin-left:2%;color:#d66f69;\">
				<span style=\"margin-left:1%;color:#ffb92a\">
				".$this->contributorCount()." <i class=\"fa fa-user\"></i> </span> 
				<span style=\"margin-left:1%;color:#aaf200\">
				".$this->contributionCount()." <i class=\"fa fa-picture-o\"></i>
				</span>
			</p>
                </div>
		</a>
		<div style=\"font-family: 'Josefin Sans', sans-serif;font-size:18px;\" class=\"caption-btm\">
			<p style=\"text-align:left;margin-left:2%;\">
				<span style=\"font-size:18px;\">
				".$boardInfos['boardName']."
				</span>
				<br/>
			</p>
		</div>
                <img style=\"width:100%;background-color:#e6e6e6;\" src=\"".$boardInfos['boardImage']."\" alt=\"...\">
		<img style=\"width:100%;background-color:#e6e6e6;\" src=\"".$boardInfos['boardImage']."\" alt=\"...\">
        </div>
	";


}

public function Kontrol()
{
	global $boardInfos;
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	$connection->set_charset("utf8");

	$query = "SELECT * FROM contributions WHERE boardID=\"".$boardInfos['boardID']."\" AND contributionID<>\"ereased\"";
	$results = $connection->query($query);
	if ($results->num_rows==0)
	{
		echo "<div style=\"margin-top:2%;padding:2%;background-color:#e6e6e6;width: 100%; max-width:100%;\">";
			echo "<p style=\"margin-left:6%;font-size:20px;font-family: 'Josefin Sans', sans-serif;color:#6e6e6e;\">";
				echo "Bu panoda henüz bir gönderi yok. İlk gönderiyi sen paylaşmak ister misin?";
			echo "</p>";
		echo "</div>";
		
	}
	else{
		echo "<script>";
			echo "
				$('#buralar_dutluktu').load(\"board_yeniden_eskiye.php?id=".$boardInfos['boardID']."\");
			";
		echo "</script>";
	
	}
}



public function contributionCount()
{

	global $boardInfos;
	
	$myDBConnector = new DBConnector();

	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	$query = "SELECT * FROM contributions WHERE boardID =\"".$boardInfos['boardID']."\" AND contributionID<>\"ereased\"";

	$results = $connection->query($query);

	return $results->num_rows;
}

public function contributorCount()
{

	global $boardInfos;
	
	$myDBConnector = new DBConnector();

	$dbARY = $myDBConnector->infos();

	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

	$query = "SELECT distinct(contributor) FROM contributions WHERE boardID =\"".$boardInfos['boardID']."\"";

	$results = $connection->query($query);

	return $results->num_rows;
}

public function categoryLinkCreator($category)
{
	if ($category=="Alakasız")
		return "http://serinhikaye.com/category.php?cat=a";
	if ($category=="Sanat/Eğlence")
		return "http://serinhikaye.com/category.php?cat=se";
	if ($category=="Bilgisayar/Elektronik")
		return "http://serinhikaye.com/category.php?cat=be";
	if ($category=="Yemek/İçmek")
		return "http://serinhikaye.com/category.php?cat=yi";
	if ($category=="Sağlık/Spor")
		return "http://serinhikaye.com/category.php?cat=ss";
	if ($category=="Sosyal ilişkiler")
		return "http://serinhikaye.com/category.php?cat=s";
	if ($category=="Bilim/Kültür")
		return "http://serinhikaye.com/category.php?cat=bk";
}

public function BoardToHTML()
{

	global $boardInfos;
	
	echo "<div style=\"padding-top:2%;padding-bottom:2%;border:1px solid #c7d0d5;border-radius:15px;background-color:#e6e6e6;width: 100%; max-width:100%;\">";
		echo "<div style=\"margin-left:8%;\">";
			echo "<a href=\"".$this->categoryLinkCreator($boardInfos['boardCategory'])."\"><p style=\"word-wrap:break-word;text-align:left;font-size:45px;font-family: 'Amatic SC', cursive;\">";
				echo "# ".$boardInfos['boardCategory'];
			echo "</p></a>";
		echo "</div>";
		echo "<div style=\"margin-left:8%;margin-top:2%;\">";
			echo "<img src=\"".$boardInfos['boardImage']."\" style=\"width:90%;\"/>";
		echo "</div>";
		echo "<div style=\"margin-left:8%;margin-top:1%;\">";
			echo "<button id=\"fbfb\" class=\"btn btn-facebook\" title=\"Facebook'da paylaş\"><i class=\"fa fa-facebook\"></i></button>";
			echo "<button id=\"twttwt\" style=\"margin-left:1%;\" class=\"btn btn-twitter\" title=\"Twitter'da paylaş\"><i class=\"fa fa-twitter\"></i></button>";
		echo "</div>";		
		echo "<div style=\"margin-left:8%;margin-top:2%;\">";
			echo "<p style=\"color:#cb7c7a;word-wrap:break-word;text-align:left;font-size:30px;font-family: 'Josefin Sans', sans-serif;\">";
				echo $boardInfos['boardName'];
			echo "</p>";
		echo "</div>";
		echo "<div style=\"margin-left:8%;margin-top:1%;\">";
			echo "<i><p style=\";color:#6e6e6e;word-wrap:break-word;text-align:left;font-size:18px;font-family: 'Josefin Sans', sans-serif;\">";
				echo "<a href=\"http://serinhikaye.com/user.php?name=".$boardInfos['boardCreator']."\">".$boardInfos['boardCreator']."</a> tarafından, ".$boardInfos['boardDate']." tarihinde oluşturuldu.";
			echo "</p></i>";
		echo "</div>";
		
	echo "</div>";	
	
	$myBoardContributionCreator = new BoardContributionCreator($boardInfos['boardID']);
	$myBoardContributionCreator->BoardContributionCreatorToHTML();

	echo "<div style=\"margin-top:2%;padding:2%;background-color:#e6e6e6;width: 100%; max-width:100%;\">";
		echo "
		<div class=\"dropdown\" style=\"display:inline-block;margin-left:6%;\">
  		<button class=\"btn btn-info dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Sıralama
  		<span class=\"caret\"></span></button>
  		<ul class=\"dropdown-menu\">
    		<li><a id=\"yeniden_eskiye_a\" href=\"javascript:void(0);\">Yeniden eskiye</a></li>
    		<li><a id=\"eskiden_yeniye_a\" href=\"javascript:void(0);\">Eskiden yeniye</a></li>
    		<li><a id=\"puana_gore_a\" href=\"javascript:void(0);\">Puana göre</a></li>
  		</ul>
		</div>";
		echo "<div title=\"Bu panodaki içerik sayısı\"style=\"color:#cb7c7a ;float:right;margin-right:6%;font-size:32px;font-family: 'Josefin Sans', sans-serif;display:inline-block;\">";
			echo $this->contributionCount();
			echo " ";
			echo "<i class=\"fa fa-picture-o\"></i>";
		echo "</div>";
		echo "<div title=\"Bu panoya katkı yapan kullancı sayısı\" style=\"color:#cb7c7a;margin-right:2%;float:right;font-size:32px;font-family: 'Josefin Sans', sans-serif;display:inline-block;\">";
			echo $this->contributorCount();
			echo " ";
			echo "<i class=\"fa fa-user\"></i>";
		echo "</div>";
	echo "</div>";
	echo "<div  id=\"buralar_dutluktu\"></div>";
	$this->Kontrol();
	echo "<div id=\"random_for_mobile\" style=\"font-family:'Amatic SC', cursive;display:none;margin-top:5%;\">";
		echo "<a style=\"font-size:40px;\" href=\"http://serinhikaye.com/thread.php?mode=rand\"class=\"btn btn-block btn-info\">Gelişigüzel</a>";
	echo "</div>";

	$name2 = str_replace(" ","-",$boardInfos['boardName']);
	$name3 = str_replace("?","",$name2);
	$name4 = str_replace("ç","c",$name3);
	$name4 = str_replace("ğ","g",$name4);
	$name4 = str_replace("ı","i",$name4);
	$name4 = str_replace("ö","o",$name4);
	$name4 = str_replace("ş","s",$name4);
	$name4 = str_replace("ü","u",$name4);
	$name4 = str_replace("İ","i",$name4);
						$name4 = str_replace("Ç","C",$name4);
					$name4 = str_replace("Ğ","G",$name4);
					$name4 = str_replace("Ö","O",$name4);
					$name4 = str_replace("Ş","S",$name4);
					$name4 = str_replace("Ü","U",$name4);
					$name4 = str_replace("'","-",$name4);
					$name4 = str_replace("\"","-",$name4);
					$name4 = str_replace(",","-",$name4);
	echo "<script type=\"text/javascript\">";
		echo "
			$('#yeniden_eskiye_a').click(function(){
				$('#buralar_dutluktu').load(\"board_yeniden_eskiye.php?id=".$boardInfos["boardID"]."\");
			});
			$('#eskiden_yeniye_a').click(function(){
				$('#buralar_dutluktu').load(\"board_eskiden_yeniye.php?id=".$boardInfos["boardID"]."\");
			});
			$('#puana_gore_a').click(function(){
				$('#buralar_dutluktu').load(\"board_puana_gore.php?id=".$boardInfos["boardID"]."\");
			});

				$('#twttwt').click(function(e){
					e.preventDefault();
					var width  = 575,
        				height = 400,
        				left   = ($(window).width()  - width)  / 2,
        				top    = ($(window).height() - height) / 2,
        				url    = this.href,
        				opts   = 'status=1' +
                 			',width='  + width  +
                 			',height=' + height +
                 			',top='    + top    +
                 			',left='   + left;
    
    					window.open(url, 'twitter', opts);
				});
			$('#fbfb').click(function(){
					FB.ui({
  					method: 'feed',
  					link: 'http://serinhikaye.com/board/".$boardInfos['boardID']."/".$name4."',
  					caption: 'Bir ".$boardInfos["boardCreator"]." eseri.',
					picture: 'http://www.serinhikaye.com/".$boardInfos["boardImage"]."',
					name: 'Pano: ".$boardInfos['boardName']." - SerinHikaye.com'
					}, function(response){});
			});
			
			document.title='".$boardInfos['boardName']." - SerinHikaye.com';
		";
	echo "</script>";

}



}

?>
