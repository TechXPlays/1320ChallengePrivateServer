<?php
	session_start();
	// echo "<pre>";
	
	require_once('include/config.php');
	require_once('include/init.php');
	// var_dump(Helper::randomActivationCode('soulseekah')); die();
	// $fp = fopen('lo', 'ab');
	
	$debug_post['data'] = urldecode('%1BR%22LB%14F%7D%3Cb%09%07%14%09T3MV%17W%09%0B0MM%12%1FT%2AB%5F%5CBU%0B%2CON%13%1E%0C%26BC%09SY%5E%2C%5DR%12%13%5E%2FhR%03%0FD%0E6%5FEWBT%2AH%01CD%01%403%5E%19%12H%7Ex00%7E%2EQ%7Ex00%7EH%7Ex00%7E%12%19%3CLH%0E%14%0C%28M%5E%0E%5BU%146BD');
	$request = new Request(empty($_POST) ? $debug_post : $_POST);
	$response = $request->getResponse();
	
	// Don't encrypt the response if action is that of version checking
	if ($request->variables['action'] == 'checkVersion') echo $response->toString(false);
	else echo $response->toString(true);
	// fwrite($fp, $response->toString(false)."\n");
	// fclose($fp);
	// echo "--------------------------------------";
	// echo $request->decode(substr($response->toString(true), 5));
?>