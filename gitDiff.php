<?php

function scanForFiles($string)
{
	$fileList = array();
	$findmeAfter="diff --git a/";
	$findmeTill =" b/";
	$pos = strpos($string, $findmeAfter);																																																																														
	while($pos !== false)																																																														
	{
		$pos=$pos+13;
		$endpos = strpos($string, $findmeTill,$pos);
		$sub = substr($string,$pos,$endpos-$pos);
		$sub=str_replace(" ","\ ", $sub);
		array_push($fileList,$sub);
		$pos = strpos($string, $findmeAfter,$endpos);
	}
	return $fileList;
}

function createComment($msg, $line, $filename, $owner, $repository, $number, $id) {
	echo $msg . " : " . $line . " : " . $filename;
	require(__DIR__ . '/github-php-client/client/GitHubClient.php');
	$username='';
	$password='';
	$filename = str_replace("\ "," ", $filename);
	$client = new GitHubClient();
	$client->setCredentials($username, $password);
	$commentTry=$client->pulls->comments->createComment($owner, $repository, $number, $msg, intval($line), $id, $filename);

}

function updateLog($report, $fileName, $fileType, $owner, $repository, $number, $id) {
	echo $report;
	switch ($fileType) {
		case "php":
			$pos = strpos($report, "PHP Parse error:");
			if($pos !== false) {
				while($pos !== false) {
					$pos+=16;
					$endpos = strpos($report, " in ",$pos);
					$errorMsg = substr($report,$pos,$endpos-$pos);
					$lineNoPos = strpos($report, " on line ",$endpos);
					$lineNoPos += 9;
					$lineNoEndPos = strpos($report, " ",$lineNoPos);
					$lineNo = substr($report,$lineNoPos,$lineNoEndPos-$lineNoPos);
					createComment($errorMsg,$lineNo,$fileName);
					$pos = strpos($report, "PHP Parse error:",$lineNoEndPos);
				}
			}
			break;
		case "js":
			$pos = strpos($report, ".js: line ");
			if($pos !== false) {
				while($pos !== false) {
					$pos+=10;
					$endpos = strpos($report, ", ",$pos);
					$lineNo = substr($report,$pos,$endpos-$pos);
					$errPos = strpos($report, ", ",$endpos+1);
					$errPos += 2;
					$errEndPos = strpos($report, ".",$errPos);
					$errorMsg = substr($report,$errPos,$errEndPos-$errPos);
					createComment($errorMsg,$lineNo,$fileName);
					$pos = strpos($report, ".js: line ",$errEndPos);
				}
			}
			break;
		default:
			break;
	}
	return;

}

function scanErrors($load)
{
	$mainDir = getcwd();
	$repository = $load["pull_request"]["head"]["repo"]["name"];
	$owner = $load["pull_request"]["head"]["repo"]["owner"]["login"];
	$branch = $load["pull_request"]["head"]["ref"];
	$number = $load["number"];
	$id = $load["pull_request"]["head"]["sha"];
	shell_exec("git clone git@github.com:" . $owner . "/" . $repository . ".git");
	chdir($mainDir . "/" . $repository);
	shell_exec("git checkout master");
	shell_exec("git pull");															
	shell_exec("git checkout " . $branch);
	if($payload["action"] == "synchronize") 
		$theDiff = shell_exec("git diff HEAD^ HEAD");
	elseif($payload["action"] == "opened" || $payload["action"] == "reopened")
		$theDiff = shell_exec("git diff master " . $branch);
	$theList = scanForFiles($theDiff);
	foreach($theList as $x) {
		if(substr($x,-3) == ".js") {
			$errReport = shell_exec("jshint " . $x);
			updateLog($errReport, $x, "js",  $owner, $repository, $number, $id);
		}
		/*elseif(substr($x, -4) == ".php") {
			//echo "php file here \n";
			$errReport = shell_exec("php -l " . $x);
			updateLog($errReport, $x, "php",  $owner, $repository, $number, $id);
		}*/

	}
	chdir($mainDir);
	shell_exec("rm -rf " . $repository);

}

// initial part

$jsonpayload = $_POST["payload"];

if(is_null($jsonpayload)) {
	echo "Invalid Request\n";
}
else {
	$payload = json_decode($jsonpayload,true);
	if(array_key_exists("pull_request", $payload)) // check for Pull_request
	{
		scanErrors($payload);
	}
	
}



?>