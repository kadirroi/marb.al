<?php

class IndexSocial
{

public function IndexSocial()
{


}

public function IndexSocialToHTML()
{

	echo "<div style=\"width:100%;\">";
	echo "<a style=\"\" class=\"twitter-timeline\"  href=\"https://twitter.com/TheSerinHikaye\" data-widget-id=\"620617982159548416\">Tweets by @TheSerinHikaye</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\"://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";
          
	echo "</div>";

	echo "<div style=\"margin-top:4%;width:100%;\"  class=\"fb-page\" data-href=\"https://www.facebook.com/theserinhikaye\" data-small-header=\"false\" data-adapt-container-width=\"true\" data-hide-cover=\"false\" data-show-facepile=\"true\" data-show-posts=\"true\"><div class=\"fb-xfbml-parse-ignore\"><blockquote cite=\"https://www.facebook.com/theserinhikaye\"><a href=\"https://www.facebook.com/theserinhikaye\">SerinHikaye.com</a></blockquote></div></div>";


}

}
?>
