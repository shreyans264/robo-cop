<?php
require(__DIR__ . '/checkRepo.php');
require(__DIR__ . '/grabDataFromPayload.php');
require(__DIR__ . '/Tasks/linter.php');
require(__DIR__ . '/Tasks/cssChecker.php');
require(__DIR__ . '/Events/forcePushMaster.php');
require(__DIR__ . '/Tasks/mergeIntoMaster.php');

$jsonpayload = $_POST["payload"];

if(is_null($jsonpayload)) {
	echo "Invalid Request\n";
}
else {
	$payload = json_decode($jsonpayload,true);
	if(array_key_exists("pull_request", $payload))
	{
		switch($payload["action"])
		{
			case "opened":
			case "reopened":
			case "synchronize":
				//scanErrors($payload);
				//cssCheck($files,$load);
				break;
			case "closed":
				if($payload["pull_request"]["merged"])
				{
					//pull_request merged with masters
				}
				break;

		}
	}
	elseif(array_key_exists("commits", $payload))
	{
		if($payload["forced"] == true)
		{
			//foreced push into masters
		}
		//scanErrors($payload);


	}
	
}



?>