<?php

include_once("classes/MessageSeenFinder.class.php");

$myMessageSeenFinder = new MessageSeenFinder(array("onemsiz",$_GET["usr"]));

echo $myMessageSeenFinder -> FindForUpMenu();

?>
