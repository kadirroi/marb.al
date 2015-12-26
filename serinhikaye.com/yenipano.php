<?php
session_start();
include_once("classes/DBConnector.class.php");
$file_formats = array("jpg", "png", "gif", "bmp","jpeg"); // Set File format
$filepath = "uploads/";


/*if ($_POST['submitbtn']=="Yükleyiver") {*/
  $name = $_FILES['imagefile']['name'];
  $size = $_FILES['imagefile']['size'];

   if (strlen($name)) {
      $extension = substr($name, strrpos($name, '.')+1);
      if (in_array($extension, $file_formats)) { 
          if ($size < (4*2048 * 1024)) {
             $imagename = md5(uniqid().time()).".".$extension;
             $tmp = $_FILES['imagefile']['tmp_name'];
             if (move_uploaded_file($tmp, $filepath . $imagename)) {
		/*$img_path= "<img class=\"preview\" alt=\"yuklenen_resim\" src=\"".$filepath."/".$imagename."\" style=\"margin-left:5%;margin-top:3%;max-width:80%;\"/>";*/
		$link = $filepath."/".$imagename;
			/*echo json_encode(array("err"=>utf8_encode('OK'),"msg"=>utf8_encode($img_path),"link"=>utf8_encode($link)),JSON_PRETTY_PRINT);*/ 
				/* buraya database yüklemesi yapcaz */
				$myDBConnector = new DBConnector();
				$dbARY = $myDBConnector->infos();
				$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
				$connection->set_charset("utf8");
				$query = "SELECT * FROM boards";
				$results = $connection->query($query);

				$id = $results->num_rows + 1;

					$threadName1 = $connection->real_escape_string($_POST["baslik_part_1"]);
					$threadName2 = $connection->real_escape_string($_POST["baslik_part_2"]);
					$threadName = $threadName1." nasıl ".$threadName2;
					$name2 = str_replace(" ","-",$threadName);
					$name3 = str_replace("?","",$name2);
					$name4 = str_replace("ç","c",$name3);
					$name4 = str_replace("ğ","g",$name4);
					$name4 = str_replace("ı","i",$name4);
					$name4 = str_replace("ö","o",$name4);
					$name4 = str_replace("ş","s",$name4);
					$name4 = str_replace("ü","u",$name4);
					$name4 = str_replace("İ","i",$name4);
					$name4 = str_replace("Ç","C",$name4);
					$name4 = str_replace("Ğ","G",$name4);
					$name4 = str_replace("Ö","O",$name4);
					$name4 = str_replace("Ş","S",$name4);
					$name4 = str_replace("Ü","U",$name4);
					$name4 = str_replace("'","-",$name4);
					$name4 = str_replace("\"","-",$name4);
					$name4 = str_replace(",","-",$name4);

				$query = "INSERT INTO `boards`(`boardID`, `boardName`, `boardCategory`, `boardCreator`, `boardImage`, `boardDate`) VALUES (\"".$id."\",\"".$threadName."\",\"".$_POST["pano_cat"]."\",\"".$_SESSION["user_name"]."\",\"".$link."\",\"".date("Y-m-d H:i:s")."\")";

				$connection->query($query);

				$sitemap = simplexml_load_file("sitemap.xml");
				$myNewUrl = $sitemap->addChild("url");
				$myNewUrl->addChild("loc", "http://serinhikaye.com/board/".$id."/".$name4);
				$sitemap->asXml("sitemap.xml");
				echo "1";
				echo "http://serinhikaye.com/board/".$id."/".$name4;
				/* **********************************/
	     } else {
		 $mesele="Resmin boyutu cok buyuk."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			
			echo "Resmin boyutu çok büyük";
	     }
	  } else {
		$mesele="Yuklemeye çalistiginiz resmi, 4 MB'dan buyuk oldugu icin kabul edemiyoruz."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			
			echo "Yüklemeye çalıştığınız resmi 4 MB'dan büyük olduğu için kabul edemiyoruz.";
	  }
       } else {
	       $mesele="Gecerli olmayan tipte bir dosya yuklemeye calisiyorsunuz."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			
			echo "Geçerli olmayan tiplte bir dosya yüklemeye çalışıyorsunuz";
       }
  } else {
       		$mesele="Varolussal sebeplerden dolayi bir resmi yuklemeden once secmeniz gerekiyor."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			
			echo "Varoluşsal sebeplerden dolayı bir resmi yüklemeden önce seçmeniz gerekiyor";
  /*}*/

}

?>
