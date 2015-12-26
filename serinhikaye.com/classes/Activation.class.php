<?php
session_start();
include_once("classes/DBConnector.class.php");
class Activation
{
	var $code;
	public function Activation($whichCode)
	{
		global $code;
		$code = $whichCode;
	}

	public function Activate()
	{
		global $code;
		echo "<div  style=\"margin-top:10%;padding:3%;font-family:Verdana,Geneva,sans-serif;font-size:20px;background-color:#e6e6e6;border:1px solid #c7d0d5;border-radius:15px;width: 100%; max-width:100%;color:#6e6e6e;height:250px;\">";
		echo "<img src=\"images/headerfil2.jpg\" style=\"max-width:60px;\"/>";
		echo "<br/>";
		if (isset($_SESSION["user_name"]))
		{
			$usr = $_SESSION["user_name"];
			$myDBConnector = new DBConnector();
			$dbARY = $myDBConnector->infos();
			$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
			if ($connection->connect_error)
				echo "Veritabanı bağlantı sorunu.";
			else
			{
				$query = "UPDATE users SET activation=\"OK\" WHERE ( userName=\"".$usr."\" AND activationCode=\"".$code."\")";
				if ($connection->query($query)===TRUE)
					echo "Üyeliğiniz başarıyla aktive edildi.";
				else
					echo "Veritabanı hatası.";
			}
		}
		else
		{
			echo "Üyeliğinizi aktive etmeden önce giriş yapmalısınız.";
		}
		echo "<br/><br/>";
		echo "<button id=\"anasayfaya_don_buttonu\" class=\"btn btn-primary\">";
			echo "Anasayfaya git";
		echo "</button>";
		echo "<br/>";
		echo "</div>";
		echo "<script type=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					$('#anasayfaya_don_buttonu').click(function(){
						window.location.replace(\"http://www.serinhikaye.com\");
					});
				});
			";
		echo "</script>";
	}

}

?>
