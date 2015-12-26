<?php
include_once('PHPMailer/class.phpmailer.php');
include_once('PHPMailer/class.smtp.php');
include_once('PHPMailer/PHPMailerAutoload.php');
include_once("classes/DBConnector.class.php");

$email = $_POST["email_forgot"];

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection -> connect_error)
	echo json_encode(utf8_encode("CONNECT_ERR"));
else
{
	$query = "SELECT * FROM users WHERE userEmail=\"".$email."\"";
	$result = $connection->query($query);
	if ($result->num_rows==0)
		echo json_encode(utf8_encode("KULLANICI_YOK"));
	else
	{
		$curResult = $result->fetch_assoc();
		$password= $curResult["userPass"];

		/* mail yollama atraksiyonları */

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'mail.serinhikaye.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'info@serinhikaye.com';
		$mail->Password = 'o1g2u3z4TROLOLOLO';
		//$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->From = 'info@serinhikaye.com';
		$mail->addAddress($email);
		$mail->Subject  = "SerinHikaye.com sifre hatirlatici";
		$mail->CharSet = 'UTF-8';
		$body     = "<body> Merhaba ! <br/><br/> Şifrenizi unuttuğunuza dair duyumlar aldık, bu yüzden size şifrenizi hatırlatıyoruz.<br/><br/> Şifreniz : ".$password." <br/><br/> Bu maili beklemiyorduysanız birisi şifrenizi çalmaya çalışıyor ve o sakıncalı kişinin IP adresi : ".$_SERVER["REMOTE_ADDR"]." <br/><br/> En güzel dileklerimizle, <br/><br/> SerinHikaye ekibi.";
		$mail->MsgHTML($body);
		if(!$mail->send()) 
    			echo json_encode(utf8_encode($mail->ErrorInfo));
		 else 
    			echo json_encode(utf8_encode("OK"));
		 
	}
	$connection->close();
}
?>
