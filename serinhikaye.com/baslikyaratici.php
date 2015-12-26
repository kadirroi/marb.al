<?php	
session_start();
include_once ("classes/ThreadCreator.class.php");
include_once ("classes/EmptyIDFinder.class.php");

		echo "<div class=\"modal fade bs-example-modal-lg\" id=\"upmenu_yeni_baslik_modal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog modal-lg \">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
	
					echo "<div id=\"thread_olusturucu_top\" class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<a type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></a>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: Verdana,Geneva,sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "Yeni içerik ";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$threadCreatorInfo= array();			
						$myEmptyIDFinder = new EmptyIDFinder();			
						$threadCreatorInfo[0]=$_SESSION["user_name"];
						$threadCreatorInfo[1]=$myEmptyIDFinder->Find();
						$myThreadCreator = new ThreadCreator($threadCreatorInfo);
						$myThreadCreator->ThreadCreatorToHTML();
					echo "</div>";

				echo "</div>";
			echo "</div>";	
		echo" </div>";
?>
