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
	<title>SerinHikaye.com</title>
	
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



<?php
	include_once ("classes/ThreadMobile.class.php");
	include_once ("classes/SuggestionsBar.class.php");
	include_once ("classes/YazarBasliklari.class.php");
	include_once ("classes/Upmenu.class.php");
	include_once ("classes/DBConnector.class.php");

	if (isset($_GET["id"]))
		$threadID = $_GET["id"];
		
	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	
	if ($connection->connect_error)
	{
		echo "<span>Database hatası</span>";
	}
	else
	{

		$connection->set_charset("utf8");
		if (isset($_GET["mode"]))
			if ($_GET["mode"]==="rand")
			{
				$myquery1 = "SELECT threadID from threads ORDER BY RAND() LIMIT 1";
				$resultRand = $connection->query($myquery1);
				$resultRandAssoc = $resultRand->fetch_assoc();
				$threadID= $resultRandAssoc["threadID"];
			}
		if (!is_numeric($threadID))
			echo "<script>window.location=\"http://serinhikaye.com\"</script>";
		$myquery = "SELECT * from threads where threadID='$threadID'";
		
		$results = $connection->query($myquery);
		if ($results->num_rows==0)
		{
			echo "<script type=\"text/javascript\">location.href=\"oops.php\";</script>";
		}
		$curResult = $results->fetch_assoc();
		$threadDate =	$curResult["threadDate"];
		$threadWriter =	$curResult["threadWriter"];
		$threadCategory = $curResult["threadCategory"];	
		$threadPicture = $curResult["threadPicture"];	
		$stepCount =  $curResult["stepCount"];
		$strx1 = str_replace('\"','"',$curResult["threadName"]);
		$strx2 = str_replace("\'","'",$strx1);
		$threadName = $strx2;
		$threadPoint = $curResult["threadPoint"];

		echo "<input id=\"title_input\" type=\"text\" style=\"display:none;\" value=\"".$threadName."\"/>";
		$mySuggestionsBar = new SuggestionsBar(array($threadCategory,$threadName));
		$myThread = new Thread (array($threadID,$threadDate,$threadWriter,$threadCategory,$threadPicture,$stepCount,$threadName,$threadPoint));

		$myYazarBasliklari = new YazarBasliklari($threadWriter);
		$myUpmenu = new Upmenu();
		echo "<div class=\"container\" style=\"top:1%;\">";
			echo "<div class=\"row\">";
				echo "<div class=\"col-md-12\">";
					$myUpmenu->UpmenuToHTML();
				echo "</div>";
			echo "</div>";
			echo "<div class=\"row\">";
				
					$myThread->ThreadToHTML();
				
			echo "</div>";
		echo "</div>";	
		
		if (isset($_GET["olay"]))
			if ($_GET["olay"] === "success")
			{
				echo "<script> alert(\"Başlığınız başarıyla kaydedildi\"); </script>";
			}
	}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$(this).attr("title",$('#title_input').val()+' - serinhikaye.com');
	});
</script>
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
