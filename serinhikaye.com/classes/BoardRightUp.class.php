<?php
include_once("classes/IndexSocial.class.php");
include_once("classes/Thread.class.php");
include_once("classes/DBConnector.class.php");
class BoardRightUp
{

var $infos;

public function BoardRightUp($ary)
{
	global $infos;
	
	$infos['boardID'] = $ary[0];
	$infos['boardCategory'] = $ary[1];
}

public function BoardRightUpToHTML()
{
	global $infos;	
	$myIndexSocial = new IndexSocial();
	echo "<div id=\"catcher2\" style=\"border:1px solid #c7d0d5; border-radius:15px;\">";
		$myIndexSocial->IndexSocialToHTML();
	echo "</div>";
	
	echo "<div id=\"sticky2\" style=\"margin-top:2%;width:100%;\">";
		$myDBConnector = new DBConnector();
		$dbARY = $myDBConnector->infos();
		$connection = new mysqli($dbARY[0],$dbARY[1],$dbARY[2],$dbARY[3]);
		$connection->set_charset("utf8");
		$query = "SELECT * FROM threads WHERE threadCategory=\"".$infos['boardCategory']."\" ORDER BY rand() LIMIT 2";	
			$results2 = $connection -> query ($query);
			while ($curResult2 = $results2 -> fetch_assoc())
			{
				$threadID2 = $curResult2 ["threadID"];
				$threadDate2 = $curResult2["threadDate"];
				$threadWriter2 = $curResult2["threadWriter"];
				$threadCategory2 = $curResult2["threadCategory"];
				$threadPicture2 = $curResult2["threadPicture"];
				$stepCount2 = $curResult2["stepCount"];
				$threadName2 = $curResult2["threadName"];
				$threadPoint2 = $curResult2["threadPoint"];
				
				$myThread2 = new Thread(array($threadID2,$threadDate2,$threadWriter2,$threadCategory2,$threadPicture2,$stepCount2,$threadName2,$threadPoint2));
				$myThread2-> ThreadToPetitHTML();
			}
		
	echo "</div>";
	
	echo "<script>";
		echo "
		$(document).ready(function(){
			if ($(window).width()<=1028)
			{
				$('#catcher2').remove();
				$('#sticky2').remove();
				$('#random_for_mobile').show();
			}
		});
	var wid = $('#sticky2').width();
	function isScrolledTo(elem) {
    var docViewTop = $(window).scrollTop(); //num of pixels hidden above current screen
    var docViewBottom = docViewTop + $(window).height();
 
    var elemTop = $(elem).offset().top; //num of pixels above the elem
    var elemBottom = elemTop + $(elem).height();
 
    return ((elemTop <= docViewTop));
}

	var catcher = $('#catcher2');
var sticky = $('#sticky2');

	$(window).scroll(function() {
	if ($(window).width()>1028){
    if(isScrolledTo(sticky)) {
        sticky.css('position','fixed');
        sticky.css('top','100px');
	sticky.css('max-width',wid);
	$('#sticky_footer_div').show(500);
    }
	
    var stopHeight = catcher.offset().top + catcher.height(); 
	  if ( stopHeight > sticky.offset().top) {
        sticky.css('position','absolute');
        sticky.css('top',stopHeight-70);
	$('#sticky_footer_div').hide(500);
    }
}
});
		";
	echo "</script>";



}

}

?>
