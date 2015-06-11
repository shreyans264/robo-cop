<?php

$jsonpayload = $_POST["payload"];

if(is_null($jsonpayload)) {
	echo "Invalid Request\n";
}
else {
	$payload = json_decode($jsonpayload,true);
	if(array_key_exists("pull_request", $payload))
	{
		scanErrors($payload);
	}
	
}



?>