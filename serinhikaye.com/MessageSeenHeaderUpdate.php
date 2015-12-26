<?php

include_once("classes/MessageSeenFinder.class.php");

$myMessageSeenFinder = new MessageSeenFinder(array($_GET["to"],$_GET["from"]));

echo $myMessageSeenFinder->Find();

?>
