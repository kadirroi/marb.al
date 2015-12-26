<?php
	$curStep = intval($_POST["current_step_input"]);
	$stepCount = intval($_POST["step_count_input"]);
	$direction = $_POST["which_direction"];
	if ($direction==="next")
	{	
		$fadeInStep = $curStep+1;
		$fadeOutStep = $curStep;
		if ($fadeInStep>$stepCount){
			$fadeInStep=1;
			$fadeOutStep=$stepCount;
		}
		echo json_encode(array("fadeIn"=>$fadeInStep,"fadeOut"=>$fadeOutStep),JSON_NUMERIC_CHECK);
	}
	else if ($direction==="prev")
	{
		$fadeInStep = $curStep-1;
		$fadeOutStep = $curStep;
		if ($fadeInStep <1)
		{
			$fadeInStep=$stepCount;
			$fadeOutStep=1;
		}
		echo json_encode(array("fadeIn"=>$fadeInStep,"fadeOut"=>$fadeOutStep),JSON_NUMERIC_CHECK);
	}
?>
