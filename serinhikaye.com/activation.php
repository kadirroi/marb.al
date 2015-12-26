<!DOCTYPE html>
<html lang="en">
<head>
	<title> Üyelik Aktivasyonu </title>
	<meta http-equiv="content-type" content="text/html; charset=UTF8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="shortcut icon" href="images/fil.ico">
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
<body style="background-color:#f9f9f9; padding-top:70px;">
<?php
require ("classes/Activation.class.php");
$code = $_GET["code"];
$myActivation = new Activation($code);
$myActivation->Activate();
?>
</body>
</html>
