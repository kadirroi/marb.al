<!DOCTYPE html>
<html lang="en">
<head>	
	<base href="http://serinhikaye.com/">
	<meta http-equiv="content-type" content="text/html; charset=UTF8">
	<link href='https://fonts.googleapis.com/css?family=Amatic+SC&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="shortcut icon" href="http://serinhikaye.com/images/fil.ico">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap-modal-master/css/bootstrap-modal.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap.file-input.js"></script>
	<script src="bootstrap-modal-master/js/bootstrap-modalmanager.js"></script>
    	<script src="bootstrap-modal-master/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<title>SerinHikaye.com</title>
	<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	
</head>
<body style="background-color:#f9f9f9; padding-top:70px; padding-bottom:70px; ">

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation" id="sticky_footer_div" style="font-family: 'Josefin Sans', sans-serif; border-top:1px solid #c7d0d5;display:none;">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" 
         data-target="#example-navbar-collapse2">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
   </div>
   <div class="collapse navbar-collapse" id="example-navbar-collapse2">
      <ul class="nav navbar-nav" style="margin-left:30%;">
         <li title="Aynen haberleşiriz"><a href="iletisim.php">iletişim</a></li>
         <li title="Ciddi meseleler"><a href="sartlar.php">kullanım koşulları</a></li>
         <li title="[S]ıklıkla [S]orulan [S]orular"><a href="sss.php">sss</a></li>
	 <li title="Facebook sayfamız"><a href="https://www.facebook.com/theserinhikaye">facebook</a></li>
	 <li title="Twitter sayfamız"><a href="https://twitter.com/TheSerinHikaye">twitter</a></li>
	 <li title="Kim bu gizemli insanlar ?"><a href="bizkimiz.php">biz kimiz ?</a></li>
      </ul>
   </div>
</nav>

<style media="screen" type="text/css">
.thumbnailx {
    background-color: #e6e6e6;
    position:relative;
    overflow:hidden;
}
.caption-btmx{
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
</style>
<?php

include_once("classes/Upmenu.class.php");
include_once("classes/Board.class.php");
include_once("classes/DBConnector.class.php");
include_once("classes/BoardRightUp.class.php");

if (!isset($_GET["id"]))
	echo "<script>window.location=\"http://serinhikaye.com\"</script>";

if (!is_numeric($_GET["id"]))
	echo "<script>window.location=\"http://serinhikaye.com\"</script>";

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

$query = "SELECT * FROM boards WHERE boardID=\"".$_GET["id"]."\"";
$connection->set_charset("utf8");
$results = $connection->query($query);
$curResult = $results->fetch_assoc();
if ($results->num_rows==0)
	echo "<script>window.location=\"http://serinhikaye.com\"</script>";

echo "<div class=\"container\" style=\"top:1%;\">";
	echo "<div class=\"row\">";
		echo "<div class=\"col-md-12\">";
			$myUpmenu = new Upmenu();
			$myUpmenu->UpmenuToHTML();
		echo "</div>";
	echo "</div>";
	echo "<div class=\"row\">";
		echo "<div class=\"col-xs-12 col-md-12 col-lg-9\">";
			$myBoard = new Board(array($curResult["boardID"],$curResult["boardName"],$curResult["boardCategory"],$curResult["boardCreator"],$curResult["boardImage"],$curResult["boardDate"]));
			$myBoard->BoardToHTML();
			/*$myBoard = new Board(array("1","Güzel bir Erasmus nasıl geçirilir?","Alakasız","turbulans67","images/alaka.jpg","12.08.2012 12:34"));
			$myBoard->BoardToHTML();*/
		echo "</div>";
		echo "<div class=\"col xs-12 col-md-12-12 col-lg-3\">";
			$myBoardRightUp = new BoardRightUp(array($curResult["boardID"],$curResult["boardCategory"]));
			$myBoardRightUp->BoardRightUpToHTML();
		echo "</div>";
	echo "</div>";
echo "</div>";
echo "
<script type=\"text/javascript\">
	$(document).ready(function(){
		$(this).attr(\"title\",'Pano: '+".$curResult["boardName"]."+' - serinhikaye.com');
	});
</script>
";
?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66743314-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
</body>
</html>
