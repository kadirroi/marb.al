<?php
include_once ("classes/Comment.class.php");
include_once ("classes/Commenter.class.php");
include_once ("classes/DBConnector.class.php");
class Comments
{
	var $contentThreadID;	

	public function Comments($whichID)
	{
		global $contentThreadID;
		$contentThreadID = $whichID;
	}

	public function commentsToHTML()
	{
		global $contentThreadID;
		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();
		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
		$myCommenter = new Commenter ($contentThreadID);
		$myCommenter -> CommenterToHTML();
		echo " <div id=\"comments_wrapper\" style=\"margin-bottom:2%;padding-bottom:1%;margin-top:1%;border:1px solid #c7d0d5;border-radius:15px;width:100%;max-width:100%;background-color:#e6e6e6;\">";
			echo "<div id=\"comments_header_div\" style=\"padding-top:1%;border-bottom:1px solid #c7d0d5;\">";
				echo "<p style=\"color:#cb7c7a;margin-left:2%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";
					echo "Yorumlar ";
					echo "<a id=\"yorum_genisletici_a\" style=\"margin-right:3%;float:right;\" href=\"javascript:void(0)\">";
						echo "<img style=\"width:30px;\" id=\"yorum_genisletici_img\" src=\"images/genislet1.gif\" onmouseover=\"this.src='images/genislet2.gif';\" onmouseout=\"this.src='images/genislet1.gif';\" alt=\"genişlet\" title=\"Ferah bir şekilde gör\">";
					echo "</a>";
				echo "</p>";
			echo "</div>";
			echo "<div id=\"comments_commnt_div\" style=\"max-height:203px;overflow:auto;\">";
				if ($connection->connect_error)
					echo "Database bağlantı sorunu";
				else
				{
					$connection->set_charset("utf8");
					$i = 0;
					$querro = "SELECT * FROM comments WHERE threadID=".$contentThreadID;
					$resso = $connection->query($querro);
					while ($curresso = $resso -> fetch_assoc())
					{
						$i++;
						$myComment = new Comment(array($curresso["writerName"],$curresso["comment"],$curresso["commentDate"],$curresso["threadID"]));
						$myComment->CommentToHTML();	
					}
					
					if ($i==0)
						echo "<br/><p style=\"margin-left:2%;font-size:15px;font-family: 'Josefin Sans', sans-serif;\"> Bu başlıkla alakalı bir yorum girilmemiş </p>";
				}
			echo "</div>";
		echo "</div>";

		echo "<div class=\"modal fade\" id=\"CommentsModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"basicModal\" aria-hidden=\"true\">";	
			echo "<div class=\"modal-dialog\">";
				echo  "<div class=\"modal-content\" style=\"background-color:#e6e6e6;\">";
					echo "<div class=\"modal-header\" style=\"background-color:#e6e6e6;border-bottom:1px solid #c7d0d5;\">";
						echo "<p style=\"color:#ec583a;margin-left:4%;font-size:23px;font-family: 'Josefin Sans', sans-serif;\">";	
											echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";					
							echo "<img src=\"images/headerfil2.jpg\" style=\"margin-right:2%;max-width:10%;\"/>";
							echo "Yorumlar";
						echo "</p>";
					echo "</div>";
					echo  "<div class=\"modal-body\" style=\"background-color:#e6e6e6;\">";
						$resso2 = $connection->query($querro);
						while ($curresso2 = $resso2 -> fetch_assoc())
						{
							$myComment2 = new Comment(array($curresso2["writerName"],$curresso2["comment"],$curresso2["commentDate"],$curresso2["threadID"]));
							$myComment2 -> CommentToHTMLBigSize();
						}
						if ($i==0)
						echo "<br/><p style=\"margin-left:2%;font-size:15px;font-family: 'Josefin Sans', sans-serif;\"> Bu başlıkla alakalı bir yorum girilmemiş </p>";	
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<script style=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					var element = document.getElementById('comments_commnt_div');
					element.scrollTop = element.scrollHeight;
					$('#yorum_genisletici_a').click(function(){
						$('#CommentsModal').modal(\"toggle\");
					});


				});
			";
		echo "</script>";		

	}
		

}

?>
