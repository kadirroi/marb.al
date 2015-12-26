<?php	
include_once("classes/DBConnector.class.php");

$myDBConnector = new DBConnector();
$dbARY = $myDBConnector->infos();

$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

		echo "<div class=\"modal fade \" id=\"bunu_favlayanlar_modal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog \">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
	
					echo "<div  class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: Verdana,Geneva,sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "Bu başlığı favorileyenler ";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						echo "<div style=\"color:#6e6e6e;margin-left:4%;font-family:Verdana,Geneva,sans-serif;font-size:18px;\">";
						if ($connection->connect_error)
							echo "Bağlantı sorunu";
						else
						{
							$query = "SELECT * FROM favoriler WHERE threadID='".$_GET["id"]."'";
							$results = $connection -> query($query);
							if ($results->num_rows==0)
							{
								echo "Bu başlığı henüz kimse favorilerine eklememiş.";
							}
							else
							{
								while ($curResult = $results->fetch_assoc())
								{
									echo "<a href=\"user.php?name=".$curResult["userName"]."\">". $curResult["userName"]."</a>";
									echo "<br/>";
								}
							}
						}
						echo "</div>";
					echo "</div>";

				echo "</div>";
			echo "</div>";	
		echo" </div>";
?>

