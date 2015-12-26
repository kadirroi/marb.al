<?php
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
			/*echo json_encode(array("err"=>utf8_encode('OK'),"msg"=>utf8_encode($img_path),"link"=>utf8_encode($link)),JSON_PRETTY_PRINT);*/ echo "1";
				echo $link;
	     } else {
		 $mesele="Resmin boyutu cok buyuk."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			echo "2";
			echo "Resmin boyutu çok büyük";
	     }
	  } else {
		$mesele="Yuklemeye çalistiginiz resmi, 4 MB'dan buyuk oldugu icin kabul edemiyoruz."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			echo "3";
			echo "Yüklemeye çalıştığınız resmi 4 MB'dan büyük olduğu için kabul edemiyoruz.";
	  }
       } else {
	       $mesele="Gecerli olmayan tipte bir dosya yuklemeye calisiyorsunuz."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			echo "4";
			echo "Geçerli olmayan tiplte bir dosya yüklemeye çalışıyorsunuz";
       }
  } else {
       		$mesele="Varolussal sebeplerden dolayi bir resmi yuklemeden once secmeniz gerekiyor."; 
		/*echo json_encode(array("err"=>utf8_encode('NOT_OK'),"msg"=>utf8_encode($mesele)),JSON_PRETTY_PRINT);*/
			echo "5";
			echo "Varoluşsal sebeplerden dolayı bir resmi yüklemeden önce seçmeniz gerekiyor";
  /*}*/

}

?>
