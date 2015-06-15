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
	$dataGrab = new grabDataFromPayload();
	$load = $dataGrab->getData($payload);
	if($load["event_type"]!="none")
	{
		$checkRepo = new checkRepo();
		$checkRepo->checkRepo($load["owner"],$load["repository"]);
		

	}
	switch($load["event_type"])
	{
		case "pull_request":
			switch($load["action"])
			{
				case "opened":
				case "reopened":
				case "synchronize":
					$diffFilesFinder = new diffFilesFinder();
					$diffFiles = $diffFilesFinder->getFilesList($load);
					$cssChecker = new cssChecker();
					$cssChecker->cssCheck($diffFiles["css"],$load);
					$linter = new linter();
					$linter->scanErrors($load,$diffFiles);
					//scanErrors($payload);
					break;
				case "closed":
					if($load["merged"])
					{
						//pull_request merged with masters
					}
					break;

			}
			break;
	
		case "push":
			if($load["forced"] == true)
			{
				$forced = new forcedPushed();
				$forced->findEnforcer($load);
				//foreced push into masters
			}
			$diffFilesFinder = new diffFilesFinder();
			$diffFiles = $diffFilesFinder->getFilesList($load);
			//scanErrors($payload);
			break;
		case "none":
			echo "invalid Request\n";
			break;

	}

	
}



?>