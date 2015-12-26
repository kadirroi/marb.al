<?php	
session_start();
include_once ("classes/MessageSender.class.php");

		echo "<div class=\"modal fade \" id=\"mesaj_yollayici_modal\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\" >";
			echo "<div class=\"modal-dialog \">";
				echo "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
	
					echo "<div  class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
										echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: Verdana,Geneva,sans-serif;\">";
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";

							echo "Mesaj yollayıcı ";	
						echo "</p>";	
					echo "</div>";
					echo "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$myConversations=new MessageSender(array($_SESSION["user_name"],$_GET["kime"]));
						$myConversations->MessageSenderToHTML();
					echo "</div>";

				echo "</div>";
			echo "</div>";	
		echo" </div>";
?>


