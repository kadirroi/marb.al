<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link href='https://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Amatic+SC&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="images/fil.ico">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap-modal-master/css/bootstrap-modal.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap.file-input.js"></script>
	<script src="bootstrap-modal-master/js/bootstrap-modalmanager.js"></script>
    	<script src="bootstrap-modal-master/js/bootstrap-modal.js"></script>
	<title>En iyi içerikler - SerinHikaye.com</title>
</head>
<body style="background-color:#f9f9f9; padding-top:70px; padding-bottom:70px;">
<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation" style="font-family: 'Josefin Sans', sans-serif; border-top:1px solid #c7d0d5;">
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

<?php
include_once("classes/Upmenu.class.php");
include_once("classes/Best.class.php");

$myUpmenu  = new Upmenu();
$myBest = new Best();
echo "<div class=\"container\">";
	echo "<div class=\"row\">";
		echo "<div class=\"col-sm-12 col-md-12\">";
			$myUpmenu->UpmenuToHTML();
		echo "</div>";
	echo "</div>";
	echo "<div class=\"row\">";
		echo "<div class=\"col-sm-12 col-md-12\">";
			$myBest->BestToHTML();
		echo "</div>";	
	echo "</div>";
echo "</div>"; 

?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66743314-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
