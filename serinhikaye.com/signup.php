<?php
session_start();
include_once('PHPMailer/class.phpmailer.php');
include_once('PHPMailer/class.smtp.php');
include_once('PHPMailer/PHPMailerAutoload.php');
include_once('classes/DBConnector.class.php');

function validateLatin($string) {
    $result = false;
 
    if (preg_match("/^[\w\d\s.,-]*$/", $string)) {
        $result = true;
    }
 
    return $result;
}
$email =htmlspecialchars($_POST["email_signup"]);
$userName = htmlspecialchars(str_replace(" ","_",$_POST["nick_signup"]));
$password = htmlspecialchars($_POST["password_signup"]);

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

if (validateLatin($userName)){
if (validateLatin($password)){
$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
if ($connection -> connect_error)
	echo "CONNECT_ERR";
else
{
	/*database'e bağlandık */
	$query1 = "SELECT * FROM users WHERE userName=\"".$userName."\"";
	$query2 = "SELECT * FROM users WHERE userEmail=\"".$email."\"";
	$result1 = $connection->query($query1);
	
	$result2 = $connection->query($query2);
			if ($result1->num_rows==0)
			{
				if ($result2->num_rows==0)
				{
					$connection->set_charset("utf8");
					$activationCode =md5(uniqid(rand(), true));
					$query3 = "INSERT INTO users(activation,activationCode,userEmail,userName,userPass) VALUES (\"NO\",\"".$activationCode."\",\"".$email."\",\"".$userName."\",\"".$password."\")";
					if ($connection->query($query3)===TRUE)
					{
						$query4 = "INSERT INTO `conversations`(`user1`, `user2`, `lastDate`) VALUES (\"TheSerinHikaye\",\"".$userName."\",\"".date("Y-m-d H:i:s")."\")";
						$connection->query($query4);
						$query5 = "INSERT INTO `messages`(`MessageDate`, `From_msg`, `To_msg`, `Message`, `Read_msg`) VALUES (\"".date("Y-m-d H:i:s")."\",\"TheSerinHikaye\",\"".$userName."\",\"Aramıza hoşgeldin ".$userName.". SerinHikaye.com ekibi olarak amacımız insanlara bir şeylerin nasıl yapıldığını adım adım anlatmak. Sen de yeni içerikler hazırlayarak bunu yapabilir, sosyal medyada arkadaşlarınla paylaşabilirsin. (Tabi bunu yaparken eğlenmeyi ihmal etmemen şartıyla) . NOT : Diğerlerinden daha iyi bildiğin şeylere odaklan ;) Sevgilerimizle..\",\"NO\")";
						$connection->query($query5);
						$activationLink = "http://www.serinhikaye.com/activation.php?code=".$activationCode;
						$mail = new PHPMailer();
						$mail->isSMTP();
						$mail->Host = 'mail.serinhikaye.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'info@serinhikaye.com';
						$mail->Password = 'o1g2u3z4TROLOLOLO';
						/*$mail->SMTPSecure = 'tls';*/
						$mail->Port = 587;
						$mail->From = 'info@serinhikaye.com';
						$mail->addAddress($email);
						$mail->Subject  = "SerinHikaye.com uyelik aktivasyonu";
						$mail->CharSet = 'UTF-8';
						$body = "Merhaba ".$userName.",<br/><br/> Öncelikle SerinHikaye platformuna hoşgeldin.<br/><br/> İçerik yazabilmek, gönderilere yorum yapabilmek vs. gibi işlemler için yapman gereken tek adım kaldı : Aşağıdaki link ile üyeliğini aktive etmek . <br/><br/> Link : <a href=\"".$activationLink. "\">".$activationLink."</a><br/><br/> En güzel dileklerimizle, <br/><br/> SerinHikaye ekibi.";
						$mail->MsgHTML($body);
						if(!$mail->send())
    							echo $mail->ErrorInfo;
		 				else {
							$_SESSION["user_name"] = $userName;
							$sitemap = simplexml_load_file("sitemap.xml");
							$myNewUrl = $sitemap->addChild("url");
							$myNewUrl->addChild("loc", "http://www.serinhikaye.com/user.php?name=".$userName);
							$sitemap->asXml("sitemap.xml");
    							echo "OK";
							}	
					}
					else
						echo "QUERY_ERR";
				}
				else
					echo "EMAIL_VAR";
			}
			else
				echo "KULLANICI_VAR";


}
}
else
	echo "TURKCE_KARAKTER_PASS";
}
else
	echo "TURKCE_KARAKTER_NICK";
?>
