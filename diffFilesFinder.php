<?php
class diffFilesFinder
{
	private function groupFiles($files)
	{
		$groupedFiles = array(
				"js"=>array(),
				"php"=>array(),
				"css"=>array(),
				"html"=>array()
			);
		foreach($files as $file) {
			if(substr($file["filename"],-3) == ".js")
			{
				array_push($groupedFiles["js"],$file);
			}
			elseif(substr($file["filename"], -4) == ".css")
			{
				array_push($groupedFiles["css"],$file);
			}
			elseif(substr($file["filename"], -4) == ".php")
			{
				array_push($groupedFiles["php"],$file);
			}
			elseif(substr($file["filename"], -5) == ".html")
			{
				array_push($groupedFiles["html"],$file);
			}
		}
		return $groupedFiles;
	}

	public function getFilesList($owner,$repo,$number)
	{
		require_once(__DIR__ . '/vendor/tan-tan-kanarek/github-php-client/client/GitHubClient.php');
		$config = include "config.php";	
		$client = new GitHubClient();
		$client->setCredentials($config["username"], $config["password"]);
		$jsonFileList = $client->pulls->listPullRequestsFiles($owner,$repo,$number);
		$fileList = json_decode($jsonFileList);
		return groupFiles($fileList);
	}
		
}



?>