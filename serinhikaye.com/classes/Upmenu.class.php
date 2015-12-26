<?php
session_start();
include_once ("classes/UserSettings.class.php");
include_once ("classes/ActivationFinder.class.php");
include_once("classes/Login.class.php");
include_once("classes/SignUp.class.php");
include_once('classes/DBConnector.class.php');


class Upmenu
{

	public function Upmenu()
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
	public function signUpLogin() /* ben malın tekiyim */
	{
		

		echo "<div class=\"modal fade\" id=\"signup_modal_div\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog\">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
					echo "<div class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "SerinHikaye platformuna katıl";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$mySignUp = new SignUp();
						$mySignUp->SignUpToHTML();
					echo "</div>";
				echo "</div>";
			echo "</div>";	
		echo" </div>";		

		echo "<div class=\"modal fade\" id=\"login_modal_div\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog\">";
				echo  "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
					echo "<div class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";						
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";
							echo "SerinHikaye platformuna bağlan";
						echo "</p>";
					echo "</div>";	
					echo  "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$myLogin = new Login();
						$myLogin->LoginToHTML();
					echo "</div>";
				echo  " </div>";
			echo "</div>";
		echo "</div>";
	}
	public function UpmenuToHTML()
	{
		
		echo "<link rel=\"stylesheet\" href=\"bootstrap-social-gh-pages/bootstrap-social.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"font-awesome-4.3.0/css/font-awesome.min.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"font-awesome-4.3.0/css/font-awesome.css\"/>";
		echo "<link rel=\"stylesheet\" href=\"collapse_fix.css\"/>";

		$this->signUpLogin();

		if (isset($_SESSION["user_name"])){

		echo "<div class=\"modal fade\" id=\"upmenu_user_settings_modal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog\">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
					echo "<div class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";					
						
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "Hesap ayarları ";	
						echo "</p>";
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$myUserSettings = new UserSettings($_SESSION["user_name"]);
						$myUserSettings->UserSettingsToHTML();
					echo "</div>";
				echo "</div>";	
			echo "</div>";
		echo "</div>";


		echo "<div id=\"upmenu_yeni_baslik\"></div>";
		echo "<div id=\"upmenu_mesajlar\"></div>";
		
		}

		echo "<nav class=\"navbar navbar-default navbar-fixed-top  \" style=\"border-bottom:1px solid #c7d0d5;font-size:25px;font-family: 'Amatic SC', cursive; background-color:#e6e6e6; \" role=\"navigation\">";
				echo "<div class=\"container-fluid\">";
			echo "<div class=\"navbar-header\" style=\"margin-left:1%;\">";
				echo "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\">";
					echo "<span class=\"icon-bar\"></span>";
					echo "<span class=\"icon-bar\"></span>";
					echo "<span class=\"icon-bar\"></span>";
				echo "</button>";
				 echo "<a class=\"\" href=\"http://www.serinhikaye.com\" style=\"\">";
					echo "<img title=\"SerinHikaye.com - Herkesin en iyi bildiği şeyler.\" src=\"images/headerfil2.jpg\" style=\"width:50px;\"/>";
				 echo "</a>";
			echo "</div>";
			echo "<div class=\"collapse navbar-collapse\" id=\"myNavbar\">";
			echo "<ul style=\"margin-left:2%;\" class=\"nav navbar-nav\">";
				echo "<li  onmouseout=\"this.style.background='#e6e6e6'\" onmouseover=\"this.style.background='#ffffff'\"  class=\"dropdown\" style=\"\">";
					echo"<a href=\"javascript:void(0)\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" title=\"Neler neler..\">";
						echo "Kategoriler";
						echo "<b class=\"caret\"></b>";
					echo "</a>";
					echo "<ul class=\"dropdown-menu\" style=\"font-size:20px;background-color:#e6e6e6;  border-radius:15px;\">";
						echo "<li ><a style=\"color:#6e6e6e;\" href=\"category.php?cat=se\" title=\"O tabloyu ben de çok seviyorum Selinsu.\">#Sanat/Eğlence</a></li>";
						echo "<li><a style=\"color:#6e6e6e;\" href=\"category.php?cat=be\" title=\"Gamerlar, Freakler ve dahiler.\">#Bilgisayar/Elektronik</a></li>";
						echo "<li><a style=\"color:#6e6e6e;\" href=\"category.php?cat=yi\" title=\"Biraz kilo mu aldım ?\">#Yemek/İçmek</a></li>";
						echo "<li><a style=\"color:#6e6e6e;\" href=\"category.php?cat=ss\" title=\"Bench press ve karatay diyeti.\">#Sağlık/Spor</a></li>";
						echo "<li><a style=\"color:#6e6e6e;\" href=\"category.php?cat=s\" title=\"Eski sevgilinin yeni sevgilisi ve asansör sessizlikleri.\">#Sosyal ilişkiler</a></li>";
						echo "<li><a style=\"color:#6e6e6e;\" href=\"category.php?cat=bk\" title=\"İsviçreli bilim adamları, Norveçli balıkçılar.\">#Bilim/Kültür</a></li>";
						echo "<li><a style=\"color:#6e6e6e;\" href=\"category.php?cat=a\" title=\"Uçan midilliler, gökkuşakları ve daha fazlası.\">#Alakasız</a></li>";
					echo "</ul>";
				echo "</li>";
				echo "<li  onmouseout=\"this.style.background='#e6e6e6'\" onmouseover=\"this.style.background='#ffffff'\" style=\"\">";
					echo "<a href=\"best.php\" title=\"Süper, şahane, harkulade eserler.\">";
						echo "En iyiler";
					echo "</a>";
				echo "</li>";
				echo "<li  onmouseout=\"this.style.background='#e6e6e6'\" onmouseover=\"this.style.background='#ffffff'\" style=\"\">";
					echo "<a href=\"recent.php\" title=\"Gencecik, taptaze.\">";
						echo "En yeniler";
					echo "</a>";
				echo "</li>";
				echo "<li onmouseout=\"this.style.background='#e6e6e6'\" onmouseover=\"this.style.background='#ffffff'\" style=\"\">";
					echo "<a href=\"thread.php?mode=rand\" title=\"Ortaya karışık, bol limonlu.\">";
						echo "<span style=\"color:#007157;\">S</span><span style=\"color:#edb8b4;\">e</span><span style=\"color:#d67226;\">r</span><span style=\"color:#5d5d5d;\">i</span><span style=\"color:#d65757;\">n</span> <span style=\"color:#edb8b4;\">H</span><span style=\"color:#5d5d5d;\">i</span><span style=\"color:#007157;\">k</span><span style=\"color:#edb8b4;\">a</span><span style=\"\">y</span><span style=\"color:#d67226;\">e</span>";
					echo "</a>";
				echo "</li>";
			echo "</ul>";
			echo "<form class=\"navbar-form navbar-left\" id=\"thread_suggestion_form\" method=\"post\" action=\"threadSuggestion.php\">";
				echo "<div class=\"input-group\" style=\"font-family: 'Josefin Sans', sans-serif;\">";
					echo "<input name=\"baslik_arayici_input\" autocomplete=\"off\" id=\"baslik_arayici_input\" type=\"text\" class=\"form-control\" placeholder=\"Başlık / Yazar\">";
						
					echo "<div class=\"input-group-btn\">";
						echo "<button id=\"kapsamli_ara_button\" title=\"Kapsamlı ara\" type=\"submit\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-search\"></span></button>";
					echo "</div>";	
				echo "</div>";
			echo "</form>";
			if (!isset($_SESSION["user_name"])){
				echo "<ul class=\"nav navbar-nav navbar-right\" style=\"margin-right:1%;\">";
					echo "<li>";
						echo "<a title=\"\" href=\"javascript:void(0)\" id=\"up_menu_giris_yap\" > Giriş yap </a>";
					echo "</li>";
					echo "<li>";
						echo "<a title=\"\" href=\"javascript:void(0)\" id=\"up_menu_uye_ol\" > Üye ol </a>";
					echo "</li>";
				echo "</ul>";
				echo "<button id=\"fbConnectButtonUpMenu\" style=\"font-family:Verdana,sans-serif;width:100px;margin-right:2%;\" class=\"btn navbar-right navbar-btn btn-facebook\">";
					echo "<i class=\"fa fa-facebook\"></i>";
					echo "";
				echo "</button>";
				echo "<a href=\"twitter_send.php\" id=\"twtConnectButtonUpMenu\" style=\"font-family:Verdana,sans-serif;width:100px;margin-right:2%;\" class=\"btn navbar-right navbar-btn btn-twitter\">";
					echo"<i class=\"fa fa-twitter\"></i>";
				echo "</a>";
			}
			else{
				$myActivationFinder = new ActivationFinder($_SESSION["user_name"]);
				echo "<ul class=\"nav navbar-nav navbar-right\" style=\"\">";
					echo "<li class=\"dropdown\" style=\"\">";
						echo"<a href=\"javascript:void(0)\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
						echo $_SESSION["user_name"];
						echo "<b class=\"caret\"></b>";
					echo "</a>";
					echo "<ul class=\"dropdown-menu\" style=\"background-color:#e6e6e6;  border-radius:15px;\">";	
						echo "<li><a style=\"font-size:23px;color:#6e6e6e;\" href=\"user.php?name=".$_SESSION["user_name"]."\">Profilim</a></li>";
						echo "<li><a id=\"ikinci_mesaj_kutusu_acici\" style=\"font-size:23px;color:#6e6e6e;\" href=\"javascript:void(0)\">Mesajlar</a></li>";
						if ($this->isSocial()=="NO")
						echo "<li><a style=\"font-size:23px;color:#6e6e6e;\" id=\"hesap_ayarlari_acici_link\" href=\"javascript:void(0)\">Hesap ayarları</a></li>";
						else
						echo "<li style=\"display:none;\"><a style=\"color:#6e6e6e;\" id=\"hesap_ayarlari_acici_link\" href=\"javascript:void(0)\">Hesap ayarları</a></li>";
						echo "<li><a style=\"font-size:23px;color:#6e6e6e;\" id=\"upmenu_cikis_linki\" href=\"javascript:void(0)\">Çıkış</a></li>";
					echo "</ul>";
				echo "</li>";
				echo "</ul>";
				echo "<form id=\"UpMenuSeenMessageSeenUpdateForm\" style=\"display:none;\" method=\"post\" action=\"UpMenuMessageSeenUpdate.php?usr=".$_SESSION["user_name"]."\"></form>";
			
				echo "<ul id=\"upmenu_messager_ul\" style=\"border-left:1px solid #e6e6e6;border-right:1px solid #e6e6e6;\" class=\"nav navbar-nav navbar-right\" style=\"\">";					
					echo "<li >";
						echo "<a id=\"upmenu_mesaj_kutusu_ac_a\" href=\"javascript:void(0)\">Mesaj
</a>";
					echo "</li>";
				echo "</ul>";
				
				if ($myActivationFinder->Find()){
				echo "
		<div class=\"dropdown navbar-btn navbar-right\" id=\"yeni_icerik_dropdown\" style=\"font-family: 'Josefin Sans', sans-serif;display:inline-block;margin-right:2%;\">
  		<button class=\"btn btn-info  dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Yeni içerik
  		<span class=\"caret\"></span></button>
  		<ul class=\"dropdown-menu\">
    		<li><a id=\"upmenu_yeni_pano_button\" href=\"javascript:void(0);\">Yeni pano</a></li>
    		<li><a id=\"upmenu_yeni_icerik_button\" href=\"javascript:void(0);\">Yeni başlık</a></li>
  		</ul>
		</div>";
					/*echo "<button type=\"button\" title=\"Anlat ki bilmeyenler öğrensin.\" id=\"upmenu_yeni_icerik_button\" class=\"btn btn-info navbar-btn navbar-right \" style=\"font-family: 'Josefin Sans', sans-serif;margin-right:2%;\">";
						echo "Yeni içerik oluştur";
					echo "</button>";*/
				}
				else{
					echo "<button id=\"upmenu_icerik_olustur_btn_non_active\" title=\"İçerik oluşturabilmek için hesabını aktive etmen gerekiyor.\"  class=\"btn btn-info navbar-btn navbar-right\" style=\"font-family: 'Josefin Sans', sans-serif;margin-right:2%;\">";
						echo "Yeni içerik oluştur";
					echo "</button>";
				}
			}
		echo "</div>";
		echo "</div>";
		echo "</nav>";
		echo "<div style=\"display:none;border-right:1px solid #e6e6e6;border-left:1px solid #e6e6e6;border-top:1px solid #e6e6e6;z-index:2;background-color:#e6e6e6;\" id=\"baslik_arayici_datalist\"></div>";
		echo "<form id=\"upmenu_cikis_formu\" method=\"post\" action=\"sessionexit.php\"></form>";
		/*******/
		echo "<script src=\"//connect.facebook.net/en_US/all.js\"></script>";
	
		echo "<div id=\"fb-root\"></div>
		<script>
  		window.fbAsyncInit = function() {
   		FB.init({
      		appId      : '662948600472315', // App ID
      		channelUrl : 'http://www.serinhikaye.com',
      		status     : true, // check login status
      		cookie     : true, // enable cookies to allow the server to access the session
      		xfbml      : true  // parse XFBML
    		});
    		};
 
  		(function(d){
    		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     		if (d.getElementById(id)) {return;}
     		js = d.createElement('script'); js.id = id; js.async = true;
     		js.src = \"//connect.facebook.net/en_US/all.js\";
     		ref.parentNode.insertBefore(js, ref);
   		}(document));
 
		</script>";
		/******/
		echo "<form id=\"facebookUpdateFormUpMenu\" method=\"post\" style=\"\" action=\"facebookUpdate.php\">";
			echo "<input type=\"text\" id=\"facebookUpdateIDTXT\" name=\"facebookUpdateIDTXT\" style=\"display:none;\"/>";
			echo "<input type=\"text\" id=\"facebookUpdateNameTXT\" name=\"facebookUpdateNameTXT\" style=\"display:none;\"/>";
		echo "</form>";
		echo "<div id=\"upmenuchoosenick\"></div>";
		echo "<script type=\"text/javascript\">";
			echo "
				function Login()
    				{
 
        				FB.login(function(response) {
           				if (response.authResponse)
           				{
                				getUserInfo(); // Get User Information.
 
            				} else
            				{
             					console.log('Authorization failed.');
            				}
         				},{scope: 'email'});
 
    				}

				function getUserInfo() {
       					FB.api('/me',  function(response) {
 
        				//response.name       - User Full name
        				//response.link       - User Facebook URL
       					//response.username   - User name
        				//response.id         - id
        				//response.email      - User email
							
					$('#facebookUpdateIDTXT').val(response.id);
					$('#facebookUpdateNameTXT').val(response.name);
					$('#facebookUpdateFormUpMenu').ajaxForm({
						success : function(msg){
							if (msg=='CONNECT_ERR')
							{
								alert(\"Bağlantı sorunu.\");
							}
							else
							{
								if (msg=='YES')
								{
									location.reload();
								}
								else
								{									
									$('#upmenuchoosenick').load('chooseNick.php?id='+msg,function(){
										$('#nickChooserModal').modal(\"toggle\");
									});
								}
							}
						},
						error : function(){
							alert(\"Bir sorun oldu ve Facebook ile bağlanamadık.\");
						}
					}).submit();
        				});
   				}


				$('#fbConnectButtonUpMenu').click(function(){
					Login();
				});

				$(document).ready(function(){

					$('#kapsamli_ara_button').click(function(e){
						e.preventDefault();
						if ($('#baslik_arayici_input').val()!='')
							window.location='search.php?query='+$('#baslik_arayici_input').val();
					});					
	
					$(document).mouseup(function (e)
					{
    						var container = $('#baslik_arayici_datalist');

    						if (!container.is(e.target) 
        					&& container.has(e.target).length === 0)
    						{
        						container.hide(250);
    						}
					});
					$('#baslik_arayici_input').keyup(function(){
						if($(window).width()>=1250){
						if ($('#baslik_arayici_input').val()!='')
						$('#thread_suggestion_form').ajaxForm({
							success : function (msg){
								var pos = $('#baslik_arayici_input').position();
								$('#baslik_arayici_datalist').css({
									top: pos.top + $('#baslik_arayici_input').height()  + 20,
									left: pos.left,
									width : 265 ,
									position: 'absolute'
								}).insertAfter($('#baslik_arayici_input'));
								$('#baslik_arayici_datalist').hide();
								$('#baslik_arayici_datalist').html(msg);
								$('#baslik_arayici_datalist').show(250);
							},
							error : function(){
								
							}
						}).submit();	
						else
							$('#baslik_arayici_datalist').hide(250);
						}
					});
					$('#ikinci_mesaj_kutusu_acici').click(function(){
						$('#upmenu_mesajlar').load('conversations.php',function(){
							$('#upmenu_mesajlar_modal').modal(\"toggle\");
						});
					});
					$('#upmenu_mesaj_kutusu_ac_a').click(function(){
						$('#upmenu_mesajlar').load('conversations.php',function(){
							$('#upmenu_mesajlar_modal').modal(\"toggle\");
						});
					});
					$('#upmenu_yeni_icerik_button').click(function(){
						$('#upmenu_yeni_baslik').load('baslikyaratici.php',function(){
							
							$('#upmenu_yeni_baslik_modal').modal(\"toggle\");
						});	
					});
					$('#upmenu_yeni_pano_button').click(function(){
						$('#upmenu_yeni_baslik').load('panoyaratici.php',function(){
							
							$('#upmenu_yeni_pano_modal').modal(\"toggle\");
						});	
					});
					$('#upmenu_icerik_olustur_btn_non_active').click(function(){
						alert(\"İçerik oluşturabilmek için hesabını aktive etmen gerekiyor. Eğer aktivasyon maili ulaşmadıysa tekrar yollamak için 'Hesap ayarları' sekmesine git.\");
					});
					$('#up_menu_giris_yap').click(function(){
						$('#login_modal_div').modal(\"toggle\");
					});	
					$('#up_menu_uye_ol').click(function(){
						$('#signup_modal_div').modal(\"toggle\");
					});				
					$('#upmenu_cikis_linki').click(function(){
						$('#upmenu_cikis_formu').ajaxForm({
							success : function (msg){
								msg = $.parseJSON(msg);
								if (msg=='OK')
									location.reload();
								else
									alert(\"çıkamayış\");
							},
							error : function () {
								alert(\"sıçış\");
							}
						}).submit();
					});
					$('#hesap_ayarlari_acici_link').click(function(){
						$('#upmenu_user_settings_modal').modal(\"toggle\");	
					});
					setInterval(function() {
						$('#UpMenuSeenMessageSeenUpdateForm').ajaxForm({
							success : function(msg){
								if (msg=='YES')
									$('#upmenu_messager_ul').css(\"box-shadow\",\"0 0 10px 10px #9bca3e inset\");
								else
									$('#upmenu_messager_ul').css(\"box-shadow\",\"none\");	
							},
							error : function(){

							}
						}).submit();	
					},1000);
				});

			";
		echo "</script>";
	}
}

?>
