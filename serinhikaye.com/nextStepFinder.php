<?php
	$stepCount = $_POST["how_many_steps_there_are"];
	$intStepCount = intval ($stepCount);
	if ($intStepCount <10)
		echo json_encode(utf8_encode($intStepCount+1));
	else
		echo json_encode(utf8_encode("MAX_SIZE_REACHED"));
?>
