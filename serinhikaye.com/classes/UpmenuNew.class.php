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
echo "<style>";
echo "
.navbar-brand {
  float: none;
  }

.navbar-center
{
    position: absolute;
    width: 100%;
    left: 0;
    top: 0;
    text-align: center;
    margin: auto;
  height:100%;
}
";
echo "</style>";
echo "
<nav class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class=\"navbar-header\">
      <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#navbar-collapse-1\">
        <span class=\"sr-only\">Toggle navigation</span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
      </button>
      &nbsp;
      <div class=\"btn-group\">    
        <a href=\"#\" class=\"btn btn-default navbar-btn dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"glyphicon glyphicon-chevron-down\"></i> <span class=\"hidden-xs\">Discover</span></a>
        <ul class=\"dropdown-menu\">
          <li><a href=\"#\">Action</a></li>
          <li><a href=\"#\">Another action</a></li>
          <li><a href=\"#\">Something else here</a></li>
          <li class=\"divider\"></li>
          <li><a href=\"#\">Separated link</a></li>
          <li class=\"divider\"></li>
          <li><a href=\"#\">One more separated link</a></li>
        </ul> 
      </div>  
    </div>
  <div class=\"navbar-center navbar-brand\" href=\"#\"><a class=\"navbar-brand\">Brand</a></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class=\"collapse navbar-collapse\" id=\"navbar-collapse-1\">
     
      <form class=\"navbar-form navbar-left\" role=\"search\">
        <div class=\"form-group\">
          <input class=\"form-control\" placeholder=\"Search\" type=\"text\">
        </div>
        <button type=\"submit\" class=\"btn btn-default\"><i class=\"glyphicon glyphicon-search\"></i></button>
      </form>
      <ul class=\"nav navbar-nav navbar-right\">
        <li><a href=\"#\">Link</a></li>
        <li><a href=\"#\">Link</a></li>
        <li><a href=\"#\">Link</a></li>
        <li class=\"dropdown\">
          <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <b class=\"caret\"></b></a>
          <ul class=\"dropdown-menu\">
            <li><a href=\"#\">Action</a></li>
            <li><a href=\"#\">Another action</a></li>
            <li><a href=\"#\">Something else here</a></li>
            <li class=\"divider\"></li>
            <li><a href=\"#\">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
</nav>
";


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
