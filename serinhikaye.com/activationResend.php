<?php
include_once('PHPMailer/class.phpmailer.php');
include_once('PHPMailer/class.smtp.php');
include_once('PHPMailer/PHPMailerAutoload.php');
include_once("classes/DBConnector.class.php");

$userName = $_GET["userName"];

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

if ($connection -> connect_error)
	echo "CONNECT_ERR";
else
{
	$query = "SELECT * FROM users WHERE userName='".$userName."'";
	$results = $connection->query($query);
	$curResult = $results->fetch_assoc();
	$activationCode =  $curResult["activationCode"];
	$connection->close();
	$activationLink = "http://www.serinhikaye.com/activation.php?code=".$activationCode;
						
						$mail = new PHPMailer();
						$mail->isSMTP();
						$mail->Host = 'mail.serinhikaye.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'info@serinhikaye.com';
						$mail->Password = 'o1g2u3z4TROLOLOLO';
						//$mail->SMTPSecure = 'tls';
						$mail->Port = 587;
						$mail->From = 'info@serinhikaye.com';
						$mail->addAddress($curResult["userEmail"]);
						$mail->Subject  = "SerinHikaye.com uyelik aktivasyonu";
						$mail->CharSet = 'UTF-8';
						$body = "Merhaba ".$userName.",<br/><br/> Öncelikle SerinHikaye platformuna hoşgeldin.<br/><br/> İçerik yazabilmek, gönderilere yorum yapabilmek vs. gibi işlemler için yapman gereken tek adım kaldı : Aşağıdaki link ile üyeliğini aktive etmek . <br/><br/> Link : <a href=\"".$activationLink."\">".$activationLink."</a><br/><br/> En güzel dileklerimizle, <br/><br/> SerinHikaye ekibi.";
						$mail->MsgHTML($body);
						if(!$mail->send())
							echo $mail->ErrorInfo;
						else
							echo "OK";

}

?>
