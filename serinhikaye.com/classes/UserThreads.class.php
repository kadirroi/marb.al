<?php
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
class UserThreads
{

var  $whichUsr;

public function UserThreads($which)
{
	global $whichUsr;
	$whichUsr = $which;
}

public function UserThreadsToHTML()
{
	global $whichUsr;
	echo "<div style=\"margin-top:2%;\">";

	$myDBConnector = new DBConnector();
	$dbARY = $myDBConnector->infos();
	
	$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
	if ($connection -> connect_error)
		echo "Database'e bağlantı sorunu";
	else
	{
		$connection->set_charset("utf8");
		$res0 = $connection->query ("SELECT * from threads where threadWriter= '$whichUsr'");
		$totalCount = $res0->num_rows;
		$res = $connection -> query ("SELECT * from threads where threadWriter='$whichUsr' ORDER BY threadPoint DESC LIMIT 6");
		$curCount = $res->num_rows;
				while ($curres = $res -> fetch_assoc())
			{
				$threadID5 = $curres ["threadID"];
				$threadDate5 = $curres["threadDate"];
				$threadWriter5 = $curres["threadWriter"];
				$threadCategory5 = $curres["threadCategory"];
				$threadPicture5 = $curres["threadPicture"];
				$stepCount5 = $curres["stepCount"];
				$threadName5 = $curres["threadName"];
				$threadPoint5 = $curres["threadPoint"];
				
				$myThread5 = new Thread(array($threadID5,$threadDate5,$threadWriter5,$threadCategory5,$threadPicture5,$stepCount5,$threadName5,$threadPoint5));  
						$myThread5-> ThreadToPetitHTML();
			}
		$connection->close();
	}
		echo "<div id=\"more_data_div\" style=\"\">";
		echo "</div>";
	
		echo "<div style=\"margin:2%;\">";
				if ($totalCount!=0)
				{
				echo "<form method =\"post\" id =\"userThreadsForm\" action=\"usrThreadsLoadMore.php?usr=".$whichUsr."\">";
					echo "<input name=\"offsetUsrThread\" id=\"offsetUsrThread\" value=\"".$curCount."\" style=\"display:none;\" />";					
					echo "<input name=\"totalUsrThread\" id=\"totalUsrThread\" value=\"".$totalCount."\" style=\"display:none;\" />";
					echo "<button id=\"loadMoreDataButton\" class=\"btn btn-block btn-success\" style=\"\">";
						echo "<i id=\"loadMoreThreadSpinner\" style=\"display:none;\" class=\"fa fa-refresh fa-spin\"></i>";
						echo  "<span id=\"loadMoreDataTXT\"> Daha fazla göster </span>";
					echo "</button>";
				echo "</form>";
				}
				else
					echo "<span style=\"font-family: 'Josefin Sans', sans-serif;font-size:18px;color:#6e6e6e;\"> Bu yazar henüz başlık oluşturmamış. </span>";
		echo "</div>";
	echo "</div>";

	echo "<script type=\"text/javascript\">";
		echo "
			$('#loadMoreDataButton').click(function(e){
				e.preventDefault();
				$('#loadMoreDataTXT').hide();
				$('#loadMoreThreadSpinner').show();
				$('#userThreadsForm').ajaxForm({
					success : function(msg){
						$('#loadMoreDataTXT').show();
						$('#loadMoreThreadSpinner').hide();
						oldoffset = $('#offsetUsrThread').val();
						newoffset = msg.charAt(0);
						oldint = parseInt(oldoffset);
						newint = parseInt(newoffset);
						if (newint==0)
						{
							$('#loadMoreDataTXT').html('Hepsi yüklendi');
							 $('#loadMoreDataButton').attr(\"disabled\", true);
						}
						$('#offsetUsrThread').val(oldint+newint);
						msg2 = msg.substring(1);
						$('#more_data_div').append(msg2);
						
					},
					error : function(){

					}
				}).submit();
			});
		";
	echo "</script>";
}

}

?>