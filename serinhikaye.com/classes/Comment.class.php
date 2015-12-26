<?php
session_start();
class Comment
{
	var $commentInfos = array ();	

	public function Comment($ary)
	{
		global $commentInfos;
		
		$commentInfos ['writerName'] = $ary[0];
		$commentInfos ['comment'] = $ary[1];
		$commentInfos ['commentDate'] = $ary[2];
		$commentInfos['threadID'] = $ary[3];
		$commentInfos['deleteLink'] = "commentEreaser.php?threadID=".$ary[3]."&commentDate=".$ary[2]."&writerName=".$ary[0];
		$str = $ary[2];
		$str2= str_replace("/","",$str);
		$str3= str_replace(":","",$str2);
		$commentInfos['commentDate2'] = str_replace (" ","",$str3);
	}

	public function CommentToHTML()
	{
		global $commentInfos;
		echo "<form id=\"comment_delete_form_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos['writerName']."\" method=\"post\" action=\"".$commentInfos['deleteLink']."\">";
			echo "<input name=\"threadID\" type=\"text\" style=\"display:none;\" value=\"".$commentInfos['threadID']."\">";
		echo "</form>";
		echo " <div id=\"comment_wrapper".$commentInfos['threadID']."_".$commentInfos["writerName"]."\"style=\"border-bottom:1px solid #c7d0d5;width:100%;max-width:100%;background-color:#e6e6e6;\">";
			echo "<div style=\"margin-top:1%;background-color:#e6e6e6;\" id=\"comment_user_name\">";
				echo "<a style=\"margin-left:2%;font-size:20px;font-family: 'Josefin Sans', sans-serif;\" href = \"user.php?name=".$commentInfos['writerName']."\">";
					echo $commentInfos['writerName']." :";
				echo "</a>";
			echo "</div>";
			echo "<div style=\"background-color:#e6e6e6;width:100%;\" id=\"comment_comment\">";
				echo "<p style=\"font-size:20px;font-family: 'Josefin Sans', sans-serif;margin-left:2%;word-wrap:break-word;text-align:left;width:95%;max-width:95%;color:#6e6e6e;\">";
					echo nl2br($commentInfos['comment']);
					echo "<br/>";
						echo "<span style=\"color:#6e6e6e;font-size:15px;font-style:italic;\">";
						echo "(".$commentInfos['commentDate'].")";
					if (isset($_SESSION["user_name"]))
						if ($_SESSION["user_name"]===$commentInfos["writerName"]){
						echo "<a href=\"javascript:void(0)\"  id=\"comment_delete_a_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos["writerName"]."\"> Sil </a>";
					echo "</span>";
					}
				echo "</p>";
			echo "</div>";
		echo "</div>";
	
		echo "<script type=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					$('#comment_delete_a_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos['writerName']."').click(function(event){
						event.preventDefault();
						$('#comment_delete_form_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos['writerName']."').ajaxForm({						
							success: function(msg){
								msg=$.parseJSON(msg);
								if (msg=='OK')
									location.reload();
								if (msg =='QUERY_ERR')
									alert(\"Veritabanı sıkıntısı yaşıyoruz, bu sorunu en kısa sürede düzelticez\");
								if (msg =='CONNECT_ERR')
									alert(\"Veritabanına bağlanamıyoruz, bu sorunu en kısa sürede düzelticez\");
							},
							error : function(){
								alert(\"Yorum Silici Ltd Şti sıçtı, bu sorunu en kısa sürede düzelticez\");
							}
						}).submit();
					});
				});
			";
		echo "</script>";
		
	}

	public function CommentToHTMLBigSize()
	{
		global $commentInfos;
		echo "<form id=\"comment_delete_form_2_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos['writerName']."\" method=\"post\" action=\"".$commentInfos['deleteLink']."\">";
			echo "<input name=\"threadID\" type=\"text\" style=\"display:none;\" value=\"".$commentInfos['threadID']."\">";
		echo "</form>";
		echo " <div id=\"comment_wrapper".$commentInfos['threadID']."_".$commentInfos["writerName"]."\"style=\"border-bottom:1px solid #c7d0d5;width:100%;max-width:100%;background-color:#e6e6e6;\">";
			echo "<div style=\"margin-top:1%;background-color:#e6e6e6;\" id=\"comment_user_name\">";
				echo "<a style=\"margin-left:2%;font-size:20px;font-family: 'Josefin Sans', sans-serif;\" href = \"users.php?name=\"".$commentInfos['writerName']."\">";
					echo $commentInfos['writerName']." :";
				echo "</a>";
			echo "</div>";
			echo "<div style=\"background-color:#e6e6e6;width:100%;\" id=\"comment_comment\">";
				echo "<p style=\"font-size:20px;font-family: 'Josefin Sans', sans-serif;margin-left:2%;word-wrap:break-word;text-align:left;width:95%;max-width:95%;color:#6e6e6e;\">";
					echo nl2br($commentInfos['comment']);
					echo "<br/>";
						echo "<span style=\"color:#6e6e6e;font-size:15px;font-style:italic;\">";
						echo "(".$commentInfos['commentDate'].")";
					if (isset($_SESSION["user_name"]))
						if ($_SESSION["user_name"]===$commentInfos["writerName"]){
						echo "<a href=\"#\"  id=\"comment_delete_a_2_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos["writerName"]."\"> Sil </a>";
					echo "</span>";
					}
				echo "</p>";
			echo "</div>";
		echo "</div>";
	
		echo "<script type=\"text/javascript\">";
			echo "
				$(document).ready(function(){
					$('#comment_delete_a_2_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos['writerName']."').click(function(event){
						event.preventDefault();
						$('#comment_delete_form_2_".$commentInfos['commentDate2']."_".$commentInfos['threadID']."_".$commentInfos['writerName']."').ajaxForm({						
							success: function(msg){
								msg = $.parseJSON(msg);
								if (msg=='OK')
									location.reload();
								if (msg =='QUERY_ERR')
									alert(\"Veritabanı sıkıntısı yaşıyoruz, bu sorunu en kısa sürede düzelticez\");
								if (msg =='CONNECT_ERR')
									alert(\"Veritabanına bağlanamıyoruz, bu sorunu en kısa sürede düzelticez\");
							},
							error : function(){
								alert(\"Yorum Silici Ltd Şti sıçtı, bu sorunu en kısa sürede düzelticez\");
							}
						}).submit();
					});
				});
			";
		echo "</script>";
		
	}
}

?>
