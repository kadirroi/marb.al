<?php
session_start();
include_once("classes/CategoryThreadCountFinder.class.php");
include_once("classes/ActivationFinder.class.php");
include_once('classes/DBConnector.class.php');
class IndexUp
{

public function IndexUp()
{

}
	public function isSocial()
	{
		if (isset($_SESSION["user_name"]))
		{
			$usrname = $_SESSION["user_name"];
			$myDBConnector = new DBConnector();
			$dbARY = $myDBConnector->infos();
			$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
			if (!$connection->connect_error)
			{
				$query = "SELECT * FROM users WHERE userName = \"".$usrname."\"";
				$results = $connection->query($query);
				$resassoc = $results->fetch_assoc();
				if ($resassoc["userPass"]=="fbuser" || $resassoc["userPass"]=="twtuser")
					return "YES";
				else
					return "NO";
			}
			else
				return "NO";
		}
		else
			return "NO";
	}

public function IndexUpToHTML()
{
	$myCategoryThreadCountFinder = new CategoryThreadCountFinder();
	$arycnt = $myCategoryThreadCountFinder->Find();
	$ary = $myCategoryThreadCountFinder->Find2();
	echo "<style media=\"screen\" type=\"text/css\">";
			echo".caption3 {
				max-height:100%;
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
	/*
	echo "<div style=\"width:100%;position:relative;overflow:hidden;height:350px;\">";
		echo "<img src=\"images/rand.jpg\"/>";
		echo "<div style=\"font-family:Verdana,Geneva,sans-serif;\" class=\"caption3\">";
			if (isset($_SESSION["user_name"]))
			{
				echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:25px;\">";
					echo "SerinHikaye.com -"."<span style=\"font-size:20px;\"> Herkesin en iyi bildiği şeyler.</span>";
				echo "</p>";
				echo "<p style=\"word-wrap:break-word;color:#d66f69;text-align:left;margin-left:2%;font-size:20px;\">";
					echo "Hoşgeldin <i>".$_SESSION["user_name"]."</i>";
				echo "</p>";
				echo "<div style=\"margin:2%;\">";
					$myActivationFinder = new ActivationFinder($_SESSION["user_name"]);
					if ($myActivationFinder->Find()===true)
					echo "<a href=\"newthread.php\" id=\"index_new_thread\" title=\"Yeni içerik\" class=\"btn btn-success\"><i class=\"fa fa-plus-square\"></i></a>";
					else
					echo "<button id=\"index_new_thread_non_active\" title=\"Yeni içerik\" class=\"btn btn-success\"><i class=\"fa fa-plus-square\"></i></button>";			
					echo "<a title=\"Kullanıcı profili\" href=\"user.php?name=".$_SESSION["user_name"]."\" style=\"margin-left:5px;\" class=\"btn btn-warning\"><i class=\"fa fa-user\"></i></a>";
					echo "<button id=\"index_mesaj_kutusu\" title=\"Mesaj kutusu\" style=\"margin-left:5px;\" class=\"btn btn-primary\"><i class=\"fa fa-envelope\"></i></button>";
					if ($this->isSocial()=="NO")
					echo "<button id=\"index_user_settings\" title=\"Kullanıcı ayarları\" style=\"margin-left:5px;\" class=\"btn btn-danger\"><i class=\"fa fa-cog\"></i></button>";
				echo "</div>";
			}
			else
			{
				echo "<p style=\"word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:25px;\">";
					echo "SerinHikaye.com -"."<span style=\"font-size:20px;\"> Herkesin en iyi bildiği şeyler.</span>";
				echo "</p>";
				echo "<p style=\"word-wrap:break-word;color:#d66f69;text-align:left;margin-left:2%;font-size:20px;\">";
					echo "Kafana takılan her sorunun cevabı burda.";
				echo "</p>";
				echo "<div style=\"margin:2%;font-family:Verdana,Geneva,sans-serif;\">";
					echo "<button id=\"index_giris_yap\" class=\"btn btn-success btn-block\">Giriş yap </button>";
					echo "<button id=\"index_uye_ol\" class=\"btn btn-warning btn-block\">Üye ol </button>";
				echo "</div>";
				echo "<div style=\"margin:2%;font-family:Verdana,Geneva,sans-serif;\">";
					echo "<a href=\"#\" id=\"indexUpFacebookLoginBtn\" class=\"btn btn-facebook\"><i class=\"fa fa-facebook\"></i></a>";
					echo "<a href=\"twitter_send.php\" style=\"margin-left:5px;\" class=\"btn btn-twitter\"><i class=\"fa fa-twitter\"></i></a>";
				echo "</div>";
			}
		echo "</div>";
	echo "</div>";
	*/
	echo "<div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\" style=\"width:100%;position:relative;overflow:hidden;height:450px;\">";
		echo "<ol class=\"carousel-indicators\" style=\"bottom:0;\">";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"0\" class=\"active\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"1\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"2\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"3\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"4\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"5\"></li>";
			echo "<li data-target=\"#myCarousel\" data-slide-to=\"6\"></li>";
		echo "</ol>";
		echo "<div class=\"carousel-inner\" role=\"listbox\">";
			echo "<div class=\"item active\" >";
				echo "<a href=\"category.php?cat=a\"><img src=\"images/alaka2.jpg\" style=\"display:inline-block;\"/></a>";
				echo "<a href=\"category.php?cat=a\"><img src=\"images/alaka2.jpg\" style=\"display:block;\"/></a>";
				echo "<a href=\"category.php?cat=a\"><img src=\"images/alaka2.jpg\" style=\"\"/></a>";
				echo "<div style=\"\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Alakasız";
					echo "</p>";
					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"Uçan midilliler, gökkuşakları ve daha fazlası.\"</i>";
					echo "</p>";
					echo "<div style=\"font-family: 'Josefin Sans', sans-serif;margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[0]."  ";
							echo "<i title=\"Bu kategorideki içerik sayısı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[0]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=a\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Çakmakla bira kapağı nasıl açılır ?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Gitar üzerinden nasıl prim yapılır ?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Göğüsler nasıl daha büyük gösterilir ?";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"item\" >";
				echo "<a href=\"category.php?cat=s\"><img src=\"images/fd.jpg\" style=\"\"/></a>";
				echo "<a href=\"category.php?cat=s\"><img src=\"images/fd.jpg\" style=\"\"/></a>";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Sosyal ilişkiler";
					echo "</p>";

					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"Eski sevgilinin yeni sevgilisi ve asansör sessizlikleri.\"</i>";
					echo "</p>";
					echo "<div style=\"margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[2]."  ";
							echo "<i title=\"Bu kategorideki içerik saysı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[2]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=s\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Yolda alakasız bir arkadaşa nasıl selam verilir ?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Rahatsız edici bir Whatsapp grubundan nasıl çıkılır ?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Friendzone engeli nasıl aşılır ?";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"item\" >";
				echo "<a href=\"category.php?cat=yi\"><img src=\"images/food2.jpg\" style=\"\"/></a>";
				echo "<a href=\"category.php?cat=yi\"><img src=\"images/food2.jpg\" style=\"\"/></a>";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Yemek / İçmek";
					echo "</p>";
					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"Biraz kilo mu aldım ?\"</i>";
					echo "</p>";
					echo "<div style=\"margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[4]."  ";
							echo "<i title=\"Bu kategorideki içerik sayısı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[4]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=yi\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Mikrodalgada yumurta nasıl kırılır ?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Kolay ve lezzetli makarna sosu nasıl yapılır ?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Ice latte nasıl hazırlanır ?";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"item\" >";
				echo "<a href=\"category.php?cat=be\"><img src=\"images/bilgelk3.gif\" style=\"display:inline-block;\"/></a>";
				echo "<a href=\"category.php?cat=be\"><img src=\"images/bilgelk3.gif\" style=\"display:block;\"/></a>";
				echo "<a href=\"category.php?cat=be\"><img src=\"images/bilgelk3.gif\" style=\"\"/></a>";
				/*echo "<a href=\"category.php?cat=be\"><img src=\"images/pc.gif\" style=\"\"/></a>";
				echo "<a href=\"category.php?cat=be\"><img src=\"images/pc.gif\" style=\"\"/></a>";*/
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Bilgisayar / Elektronik";
					echo "</p>";
					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"Gamerlar, Freakler ve dahiler.\"</i>";
					echo "</p>";
					echo "<div style=\"margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[5]."  ";
							echo "<i title=\"Bu kategorideki içerik sayısı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[5]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=be\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Super Mario'da prenses nasıl kurtarılır?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Arduino nasıl programlanır?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Bir şaka virüsü nasıl yapılır?";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"item\" >";
				echo "<a href=\"category.php?cat=bk\"><img src=\"images/rdinth.jpg\" style=\"\"/></a>";
				echo "<a href=\"category.php?cat=bk\"><img src=\"images/rdinth.jpg\" style=\"\"/></a>";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Bilim / Kültür";
					echo "</p>";
					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"İsviçreli bilim adamları, Norveçli balıkçılar.\"</i>";
					echo "</p>";
					echo "<div style=\"margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[1]."  ";
							echo "<i title=\"Bu kategorideki içerik sayısı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[1]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=bk\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Güzel satranç nasıl oynanır ?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Füzyon bombası başlığı nasıl difüze edilir ?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Pisa kulesi nasıl tutuyormuş gibi yapılır ?";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"item\" >";
				echo "<a href=\"category.php?cat=se\"><img src=\"images/stary.jpg\" style=\"\"/></a>";
				echo "<a href=\"category.php?cat=se\"><img src=\"images/stary.jpg\" style=\"\"/></a>";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Sanat / Eğlence";
					echo "</p>";
					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"O tabloyu ben de çok seviyorum Selinsu.\"</i>";
					echo "</p>";
					echo "<div style=\"margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[6]."  ";
							echo "<i title=\"Bu kategorideki içerik sayısı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[6]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=se\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Salsa dansı nasıl yapılır ?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Bir tekno festivalinde nasıl hayatta kalınır ?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Aşırı çağdaş bir sanat müzesinde nasıl doğru davranılır ?";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"item\" >";
				echo "<a href=\"category.php?cat=ss\"><img src=\"images/yoga.jpg\" style=\"display:inline-block;\"/></a>";
				echo "<a href=\"category.php?cat=ss\"><img src=\"images/yoga.jpg\" style=\"display:block;\"/></a>";
				echo "<a href=\"category.php?cat=ss\"><img src=\"images/yoga.jpg\" style=\"\"/></a>";
				echo "<div style=\"font-family: 'Josefin Sans', sans-serif;\" class=\"caption3\">";
					echo "<p style=\"font-family: 'Amatic SC', cursive;word-wrap:break-word;color:#ffffff;text-align:left;margin-left:2%;font-size:45px;\">";
						echo "#Sağlık / Spor";
					echo "</p>";
					echo "<p style=\"font-family: 'Amatic SC', cursive;color:#ffffff;text-align:left;margin-left:2%;font-size:30px;\">";
						echo "<i>\"Bench press ve karatay diyeti.\"</i>";
					echo "</p>";
					echo "<div style=\"margin:2%;\">";
						echo "<p style=\"color:#ffb92a;text-aligh:left;font-size:30px;word-wrap:break-word\">";
							echo $arycnt[3]."  ";
							echo "<i title=\"Bu kategorideki içerik sayısı\" class=\"fa fa-star\"></i>";
							echo "<span style=\"color:#d66f69;margin-left:5%;\">".$ary[3]."  </span>";
							echo "<i title=\"Bu kategoride yazan yazar sayısı\" style=\"color:#d66f69;\" class=\"fa fa-user\"></i>";
						echo "</p>";
					echo "</div>";
					echo "<div style=\"margin:2%;\">";
						echo "<a href=\"category.php?cat=ss\" class=\"btn btn-block btn-success\">Görüntüle</a>";
					echo "</div>";
					echo "<div style=\"margin:2%; margin-top:3%; color:#ffb92a; word-wrap:break-word;font-family: 'Josefin Sans', sans-serif;font-size:15px;\">";
						echo "<i class=\"fa fa-tag\"></i> Seksi sixpack nasıl yapılır ?";
						echo "<br/>";
						echo "<i class=\"fa fa-tag\"></i> Soğuk algınlığı ilaç kullanmadan nasıl giderilir ?";
						echo "<br />";
						echo "<i class=\"fa fa-tag\"></i> Bütün gün hiçbir şey yapmadan nasıl kilo verilir ?";
					echo "</div>";
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


	echo "<script type=\"text/javascript\">";
		echo "
			$('#indexUpFacebookLoginBtn').click(function(){
				Login();
			});
			$('#index_new_thread_non_active').click(function(){
				alert(\"Yeni bir içerik oluşturmadan önce üyeliğinizi aktive etmelisiniz.\");
			});
			$('#index_giris_yap').click(function(){
				$('#login_modal_div').modal(\"toggle\");
			});	
			$('#index_uye_ol').click(function(){
				$('#signup_modal_div').modal(\"toggle\");
			});
			$('#index_mesaj_kutusu').click(function(){
				$('#upmenu_mesajlar').load('conversations.php',function(){
				$('#upmenu_mesajlar_modal').modal(\"toggle\");
				});
			});
			$('#index_user_settings').click(function(){
				$('#upmenu_user_settings_modal').modal(\"toggle\");	
			});
		";
	echo "</script>";
}

}

?>
