<?php

class Step
{ /* class başlangıcı */

var $stepInfos = array();  


public function Step($ary) /* Constructor */
{
	global $stepInfos;
	$stepInfos['Step Numarasi'] = $ary[0]; /* integer */
	$stepInfos['Step Adi'] = $ary[1]; /* string */
	$stepInfos['Step Resmi'] = $ary[2]; /* resim linkini belirten string */
	$stepInfos['Step Aciklamasi'] = $ary [3]; /* string */
}

public function twitterTextGenerator($str)
{		
	return str_replace(" ","%20",$str);
}

public function StepToHTML () /* Bir step'i HTML formunda ekranda gösteren fonksyon */
{
	global $stepInfos;
	$twttxt = $this->twitterTextGenerator("Adım ".$stepInfos["Step Numarasi"].": ".$stepInfos["Step Adi"]);

	echo "<div id=\"wrapper_step\" style=\"margin-top:2%;border:1px solid #c7d0d5;border-radius:15px;background-color:#e6e6e6;width: 100%; max-width:100%;\">";
		echo "<div id=\"sayi_ve_baslik_div\"style=\"color:#6e6e6e;padding-top:1%;font-size:28px;font-family: 'Josefin Sans', sans-serif;margin-left:8%;\">";
			echo "<p style=\"word-wrap:break-word;text-align:left;width:80%;max-width:80%;\">";
			echo "Adım ".$stepInfos['Step Numarasi'].": ";
			echo $stepInfos['Step Adi'];
			echo "</p>";
		echo "</div>";
		$resimlink = $stepInfos['Step Resmi'];
		$ary1 = explode(":",$resimlink);
		if ($ary1[0]=="https" or $ary1[0]=="http")
		{
			$ary2 = explode("/",$ary1[1]);
			if ($ary2[2]=="vine.co")
			{
				if ($ary2[3]=="v")
				{
					echo "<iframe style=\"margin-left:6%;max-width:80%;\" class=\"vine-embed\" src=\"".$resimlink."/embed/simple\" width=\"600\" height=\"600\" frameborder=\"0\"></iframe><script async src=\"https://platform.vine.co/static/scripts/embed.js\" ></script>";
				}
				else{
					echo "<div id=\"pic_div\" style=\"margin-left:2%;\">";
						echo "<img src=\"".$stepInfos['Step Resmi']."\" style=\"margin-left:6%;max-width:85%;\">";
					echo "</div>";
				}
			}
			else{
				echo "<div id=\"pic_div\" style=\"margin-left:2%;\">";
					echo "<img src=\"".$stepInfos['Step Resmi']."\" style=\"margin-left:6%;max-width:85%;\">";
				echo "</div>";
			}
		}
		else{
		echo "<div id=\"pic_div\" style=\"margin-left:2%;\">";
			echo "<img src=\"http://serinhikaye.com/".$stepInfos['Step Resmi']."\" style=\"margin-left:6%;max-width:80%;\">";
		echo "</div>";
		}
		echo "<div style=\"margin-left:8%;margin-top:0.5%;\">";
			echo "<button id=\"fbShareButtonStep".$stepInfos["Step Numarasi"]."\" title=\"Facebook\" class=\"btn btn-facebook\"><i class=\"fa fa-facebook\"></i></button>";
			echo "<a href=\"http://twitter.com/share?text=".$twttxt."&hashtags=SerinHikaye\" id=\"twtShareButtonStep".$stepInfos["Step Numarasi"]."\" title=\"Twitter\" style=\"\" class=\"btn btn-twitter\"><i class=\"fa fa-twitter\"></i></a>";

		echo "</div>";
		echo "<div id=\"icerik_ve_sosyal_butonlar_div\" style=\"margin-left:2%;border-left:3px solid #c7d0d5;color:#6e6e6e;padding-bottom:2%;overflow:auto;\" onmouseover=\"this.style.borderColor='#cb7c7a';\" onmouseout=\"this.style.borderColor='#c7d0d5';\">";
			echo "<div id=\"icerik\" style=\"margin-top:2%;font-size:20px;font-family: 'Josefin Sans', sans-serif;overflow:auto;width:100%;\">";
				echo "<p id=\";aciklama\" style=\"word-wrap:break-word;text-align:left;width:80%;max-width:80%;padding-left:6%;\">";	
					echo nl2br($stepInfos['Step Aciklamasi']);
				echo "</p>";
			echo "</div>";
		echo "</div>";
		echo "<br/>";
	echo "</div>";

	echo "<script type=\"text/javascript\">";
		echo "
				$('#twtShareButtonStep".$stepInfos["Step Numarasi"]."').click(function(e){
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
			$('#fbShareButtonStep".$stepInfos["Step Numarasi"]."').click(function(){
					var x = $(document).find(\"title\").text();
					var y = window.location.href;
					FB.ui({
  					method: 'feed',
  					link: ''+y,
  					caption: 'Adım ".$stepInfos["Step Numarasi"]." : ".$stepInfos["Step Adi"]."',
					picture: 'http://serinhikaye.com/".$stepInfos["Step Resmi"]."',
					name: ''+x
					}, function(response){});
			});
		";
	echo "</script>";
}

} /* class bitişi */

?>
