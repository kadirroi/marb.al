<?php
include_once ("classes/Step.class.php");
include_once ("classes/SosyalButton.class.php");
include_once ("classes/Comments.class.php");
include_once ("classes/FavoriFinder.class.php");
include_once ("classes/CommentFinder.class.php");
include_once ("classes/DBConnector.class.php");
class Thread
{ /* class başlangıcı */

var $threadInfos = array ();

public function Thread($ary)
{
	global $threadInfos;
	$threadInfos['Thread ID'] = $ary [0];
	$threadInfos['Thread Date'] = $ary[1];
	$threadInfos['Thread Writer']= $ary[2];
	$threadInfos['Thread Category']  = $ary[3];
	$threadInfos['Thread Picture'] = $ary[4];
	$threadInfos['Step Count']=$ary[5];
	$strx1 = str_replace('\"','"',$ary[6]);
	$strx2 = str_replace("\'","'",$strx1);
	$threadInfos['Thread Name'] = htmlspecialchars($strx2);
	$threadInfos['Thread Point'] = $ary[7];
}

public function loadStep($stepNo)
{	
	global $threadInfos;
	$threadID = $threadInfos['Thread ID'];
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection ->connect_error)
	{
		return "CONNECT_ERR";		
	}
	else
	{
		/* database'e girdik */
		$sqlRequest = "SELECT * FROM steps WHERE (threadID='$threadID' AND stepNo='$stepNo')";
		if ($result=$connection->query($sqlRequest))
		{
			$ary = array ();
			$row= $result->fetch_assoc();
			$ary[0] = $row["stepNo"];
			$strx1 = str_replace('\"','"',$row["baslik"]);
			$strx2 = str_replace("\'","'",$strx1);
			$ary[1] = $strx2;
			$ary[2] = $row["resimLink"];
			$str1 = str_replace('\"','"',$row["icerik"]);
			$str2 = str_replace("\'","'",$str1);
			$ary[3] = $str2;
			$myStep = new Step ($ary);
			return $myStep;		
		}
		else
		{
			return "QUERY_ERR";
		}

		$connection->close();
		
	}
	
}

public function twitterTextGenerator($str)
{		
	return str_replace(" ","%20",$str);
}


public function ThreadToPetitHTML()
{
	global $threadInfos;
	$myFavoriFinder = new FavoriFinder($threadInfos['Thread ID']);
	$myCommentFinder = new CommentFinder ($threadInfos['Thread ID']);
	$fav = $myFavoriFinder->Find();
	$comCount = $myCommentFinder->Find();
	if ($comCount == FALSE)
		$comCount = 0;
	$name2 = str_replace(" ","-",$threadInfos['Thread Name']);
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
	<a href=\"http://serinhikaye.com/thread/".$threadInfos['Thread ID']."/".$name4."\">
 	<div style=\"display:inline-block;margin-left:2.5%;background-color:#e6e6e6;width:250px;height:200px;\" class=\"thumbnail\">
                <div style=\"font-family: 'Josefin Sans', sans-serif;font-size:18px;\" class=\"caption\">
			<p style=\"text-align:left;margin-left:2%;\">
				<span style=\"font-size:18px;\">
				".$threadInfos['Thread Name']."
				</span>
				
				<br/><br/>
				<span style=\"color:#e6e6e6;font-style:italic;font-size:18px;\">
					Bir ".$threadInfos['Thread Writer']." eseri.
				</span>
			</p>
			<p style=\"font-size:23px;font-style:bold;text-align:left;margin-left:2%;color:#d66f69;\">
				".$threadInfos['Thread Point']." <i class=\"fa fa-heart\"></i>
				<span style=\"margin-left:1%;color:#ffb92a\">
				".$fav." <i class=\"fa fa-bookmark\"></i> </span> 
				<span style=\"margin-left:1%;color:#aaf200\">
				".$comCount." <i class=\"fa fa-comment\"></i>
				</span>
			</p>
                </div>
		</a>
		<div style=\"font-family: 'Josefin Sans', sans-serif;font-size:18px;\" class=\"caption-btm\">
			<p style=\"text-align:left;margin-left:2%;\">
				<span style=\"font-size:18px;\">
				".$threadInfos['Thread Name']."
				</span>
				<br/>
			</p>
		</div>
                <img style=\"width:100%;background-color:#e6e6e6;\" src=\"".$threadInfos['Thread Picture']."\" alt=\"...\">
		<img style=\"width:100%;background-color:#e6e6e6;\" src=\"".$threadInfos['Thread Picture']."\" alt=\"...\">
        </div>
	";
	echo "<style media=\"screen\" type=\"text/css\">";
	echo"	
.thumbnail {
    position:relative;
    overflow:hidden;
}
.caption-btm{
	padding-right:3%;
	padding-left:3%;
	position:absolute;
	bottom:0px;
	width:100%;
	background:rgba(50,50,50,0.5);
	color :#e6e6e6;
	z-index:2;
	display:table;
}
.caption {
    position:absolute;
    top:0px;
    right:0;
    background:rgba(50, 50,50, 0.5);
    width:100%;
    height:100%;
    display: none;
    text-align:center;
    color:#fff !important;
    z-index:2;
}";
	echo "</style>";

	echo "<script type=\"text/javascript\">";
	echo "	
	$( document ).ready(function() {
    $(\"[rel='tooltip']\").tooltip();    
 
    $('.thumbnail').hover(
        function(){
		$(this).find('.caption-btm').fadeOut(260);
        	$(this).find('.caption').fadeIn(260);
        },
        function(){
            $(this).find('.caption-btm').fadeIn(260);
	    $(this).find('.caption').fadeOut(260);
        }
    ); 
});";
	echo "</script>";
}

public function ThreadToHTML()
{
	global $threadInfos;
	$name2 = str_replace(" ","-",$threadInfos['Thread Name']);
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
	$threadID = $threadInfos['Thread ID'];
	if ($threadInfos['Thread Category']=="Alakasız")
		$catLink = "category.php?cat=a";
	if ($threadInfos['Thread Category']=="Bilim/Kültür")
		$catLink = "category.php?cat=bk";
	if ($threadInfos['Thread Category']=="Sosyal ilişkiler")
		$catLink = "category.php?cat=s";
	if ($threadInfos['Thread Category']=="Sağlık/Spor")
		$catLink = "category.php?cat=ss";
	if ($threadInfos['Thread Category']=="Yemek/İçmek")
		$catLink = "category.php?cat=yi";
	if ($threadInfos['Thread Category']=="Bilgisayar/Elektronik")
		$catLink = "category.php?cat=be";
	if ($threadInfos['Thread Category']=="Sanat/Eğlence")
		$catLink = "category.php?cat=se";
	$twitterText = $this->twitterTextGenerator($threadInfos['Step Count']." adımda ".$threadInfos["Thread Name"]);
	echo " <style media=\"screen\" type=\"text/css\">";
		echo ".affix {
			position : fixed;
			top : 70px;
		
		}";
	echo " </style>";
	echo "<div id=\"wrapper_thread\" style=\"background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;\">";
		echo "<div id=\"hastag\" style=\"margin-top:1%;\">";
			echo "<a style=\" font-family: 'Josefin Sans', sans-serif; font-size:25px; margin-left:5%\" href=".$catLink.">";
				echo "#".$threadInfos['Thread Category'];
			echo "</a>";
		echo "</div>";	
		echo "<div id=\"div_img\" style=\"margin-left:5%; margin-top:1%;\">";
			echo "<img src=\"".$threadInfos['Thread Picture']."\" style=\"max-width:80%;\"/>";
		echo "</div>";	
		echo "<div id=\"thread_adi_ve_yazar_adi_div\" style=\"margin-top:1%\">";
			echo "<p style=\"color:#cb7c7a;margin-left:5%;font-size:28px;font-family: 'Josefin Sans', sans-serif;\">";
				echo $threadInfos['Thread Name']."<br/> [".$threadInfos['Step Count']." adım]";
			echo "</p>";
			echo "<p style=\"color:#6e6e6e;margin-left:5%;font-size:20px;font-family: 'Josefin Sans', sans-serif;\" >";
				echo "Bir "."<a href=\"user.php?name=".$threadInfos['Thread Writer']."\">".$threadInfos['Thread Writer']."</a>"." eseri."." (".$threadInfos['Thread Date'].")";
			echo "</p>";
		echo "</div>";
		echo "<div id=\"sosyal buttonlar ve puan\" style=\"margin-bottom:2%;margin-left:5%;margin-top:1%;\">";
			echo "<button id=\"fbShareButton2\" title=\"Facebook\" class=\"btn btn-facebook\"><i class=\"fa fa-facebook\"></i></button>";
			echo "<a id=\"twtShareButton2\" href=\"http://twitter.com/share?text=".$twitterText."&hashtags=SerinHikaye\" title=\"Twitter\" style=\"\" class=\"btn btn-twitter\"><i class=\"fa fa-twitter\"></i></a>";
			/*echo "<a title=\"Yorum yap\" href=\"javascript:void(0)\" class=\"btn btn-warning\"><i class=\"fa fa-comment-o\"></i></a>";*/
			if (isset($_SESSION["user_name"]))
				if ($_SESSION["user_name"] == $threadInfos['Thread Writer'])
				{
					echo "<form style=\"display:inline-block;\" id=\"thread_sil_formu\" method=\"post\" action=\"threadEreaser.php\">";
						echo "<input type=\"text\" name=\"thread_sil_id_input\" id=\"thread_sil_id_input\" style=\"display:none;\"/>";
					echo "</form>";
					echo "<a  title=\"Bu gönderini sil\"class=\"btn btn-danger\" id=\"sil_resmi\" href=\"javascript:void(0)\">";
						echo "<i class=\"fa fa-times\"></i>";
					echo "</a>";
				}
				else
				{	
					echo "<a title=\"Yazara mesaj yolla\"class=\"btn btn-primary\" id=\"mesaj_yolla_resmi\" href=\"javascript:void(0)\">";
						echo "<i class=\"fa fa-envelope\"></i>";
					echo "</a>";
				}		
		echo "</div>";
	echo "</div>";
		echo "<div id=\"top\"></div>";
		for ($i=1;$i<=$threadInfos['Step Count'];$i++)
		{
			$myStep = $this->loadStep($i);
			echo "<div id=\"div_".$i."\">";
				echo $myStep->StepToHTML();
			echo "</div>";
		}
	
		echo "<div class=\"container\" style=\"margin-top:2%;\">";
			echo "<div class=\"row\" id=\"before_sticker\"></div>";
			echo "<div class=\"row\" id=\"sticker\" >";
				echo "<div class=\"col-md-12 col-lg-1 \">";
					$fblink = "http://www.facebook.com/sharer.php?u=http://www.serinhikaye.com/thread.php?id=".$threadInfos["Thread ID"];
					$caption = $threadInfos["Step Count"]." adımda ".$threadInfos["Thread Name"];  
					$petitcaption = "Bir ".$threadInfos["Thread Writer"]." eseri.";
					$mySosyalButton = new SosyalButton(array($threadInfos["Thread Picture"],$caption,$threadInfos["Thread ID"],$petitcaption));
					$mySosyalButton->SosyalButtonToHTML();
					echo "<div title=\"Puan\" id=\"puan_div\" style=\"margin-bottom:5%;margin-top:5%;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;\">";
						echo "<p style=\"text-align:center;padding-top:5%;word-wrap:break-word;font-size:23px;color:#5bc236;font-family: 'Josefin Sans', sans-serif;width:100%\">";
							echo "<span id=\"puan_p\" style=\"display:block;\">";
								echo $threadInfos['Thread Point'];
							echo "</span>";
							echo "<img src=\"images/begeni.gif\" alt=\"puan\"style=\"width:50px;max-width:50px;\"/>";
						echo "</p>";
					echo "</div>";
					echo "<div title=\"Bunu favorileyenler\" id=\"favori_div\" style=\"margin-bottom:5%;margin-top:5%;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;\">";
						echo "<a href=\"javascript:void(0)\" id=\"bunu_favlayanlar_a\" style=\"text-decoration:none;\">";
						echo "<p style=\"text-align:center;padding-top:5%;word-wrap:break-word;font-size:23px;color:#ffb92a;font-family: 'Josefin Sans', sans-serif;width:100%\">";
							echo "<span id=\"puan_p\" style=\"display:block;\">";
								$myFavoriFinder = new FavoriFinder($threadID);
								echo $myFavoriFinder->Find();
							echo "</span>";	
							echo "<img src=\"images/fav.gif\" alt=\"fav\"style=\"width:50px;max-width:50px;\"/>";
						echo "</p>";	
						echo "</a>";
					echo "</div>";
				echo "</div>";
				echo "<div class=\"col-md-12 col-lg-8 col-sm-12 \" style=\"padding-right:2%;\">";
					$myComments = new Comments (intval($threadID));
					$myComments->CommentsToHTML();
				echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<div id=\"mesajyollayicidiv\"></div>";
		echo "<div id=\"bunu_favlayanlar_div\"></div>";





		echo "<script type=\"text/javascript\">
				$('#twtShareButton2').click(function(e){
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
			$('#fbShareButton2').click(function(){
					FB.ui({
  					method: 'feed',
  					link: 'http://serinhikaye.com/thread/".$threadInfos["Thread ID"]."/".$name4."',
  					caption: 'Bir ".$threadInfos['Thread Writer']." eseri.',
					picture: 'http://www.serinhikaye.com/".$threadInfos["Thread Picture"]."',
					name: '".$threadInfos['Step Count']." adımda ".$threadInfos['Thread Name']." - SerinHikaye.com'
					}, function(response){});
			});

			$(document).ready(function() {
				var currWidth = $('#sticker').width();
				
				var s = $('#sticker');
				var p = $('#before_sticker');

				$(window).scroll(function(){
					var pos = p.position();
					var windowpos = $(window).scrollTop();
					if (windowpos >= pos.top) {
						if ($(window).width()>1028){
							s.addClass(\"affix\");
							s.css(\"max-width\",currWidth);
							s.css(\"min-width\",currWidth);
							if ($('#sticky_footer_div').is(':hidden'));
								
						}
							$('#sticky_footer_div').fadeIn(500);
					}
					else {
						if ($('#sticky_footer_div').is(':visible'))
							$('#sticky_footer_div').fadeOut(500);
						s.removeClass(\"affix\");
						
					}
				});
				$('#mesaj_yolla_resmi').click(function(){
					$('#mesajyollayicidiv').load('messagesender.php?kime=".$threadInfos["Thread Writer"]."',function(){
						$('#mesaj_yollayici_modal').modal(\"toggle\");
					});
				});
				$('#bunu_favlayanlar_a').click(function(){
					$('#bunu_favlayanlar_div').load('favlayanlar.php?id=".$threadInfos["Thread ID"]."',function(){
						$('#bunu_favlayanlar_modal').modal(\"toggle\");
					});
				});

				
				$('#sil_resmi').click(function(){
					$('#thread_sil_id_input').val(\"".$threadInfos['Thread ID']."\");
					$('#thread_sil_formu').ajaxForm({
						success: function(msg){
							msg = $.parseJSON(msg);
							if (msg=='OK')
							{
								alert(\"İçeriğiniz başarıyla silindi.\");
								window.location.href='http://www.serinhikaye.com';
							}
							if (msg == 'CONNECT_ERR')
							{
								alert(\"Şu an veritabanımıza bağlanamıyoruz. Bu sorunu en kısa sürede gidericez.\");
							}
							if (msg =='QUERY_ERR')
							{
								alert(\"Veritabanımızla ilgili birtakım sıkıntılar yaşıyoruz. Bu sorunu en kısa sürede gidericez.\");
							}
						},
						error : function(){
							alert(\"Form silici ltd şti sıçtı.\");
						}
					}).submit();
				});

			});			
			</script>";	
	
}

} /* class bitişi */	
?>
