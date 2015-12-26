<?php
include_once("classes/Comment.class.php");
include_once("classes/DBConnector.class.php");

		echo "<div class=\"modal fade \" id=\"show_all_comments_modal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog \">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
	
					echo "<div  class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: Verdana,Geneva,sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo $_GET["usr"]." kullanıcısının yorumları ";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$myDBConnector = new DBConnector();
						$dbARY = $myDBConnector->infos();
						$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);

						if($connection->connect_error)
							echo "Database bağlantı sorunu";
						else
						{
							$connection->query("SET NAMES utf8");
							$query = "SELECT * FROM comments NATURAL JOIN threads WHERE comments.writerName='".$_GET["usr"]."'";
							$results = $connection->query($query);
							while ($curResult = $results->fetch_assoc())
							{	
									echo "<div style=\"margin-top:2%;\">";
									echo "<div>";
									echo "<a style=\"margin-left:2%;float:right;\" href=\"thread.php?id=".$curResult["threadID"]."\" class=\"btn btn-success\" title=\"Başlığı görüntüle\">";
										echo "<i class=\"fa fa-arrow-right\"></i>";

									echo "</a>";
									echo "</div>";
									echo "<p style=\"color:#ec583a;margin-left:2%;font-size:18px;font-family: Verdana,Geneva,sans-serif;word-wrap:break-word;\">";
										echo $curResult["threadName"];
									echo "</p>";	
					$myComment = new Comment(array($curResult["writerName"],$curResult["comment"],$curResult["commentDate"],$curResult["threadID"]));
								$myComment->CommentToHTML();
									echo "</div>";
							}
						if ($results->num_rows==0)
							echo "<span style=\"font-family: Verdana,Geneva,sans-serif;font-size:18px;color:#6e6e6e;\">Hiç yorum yazılmamış.</span>";
						}
					echo "</div>";

				echo "</div>";
			echo "</div>";	
			
		echo" </div>";


?>
