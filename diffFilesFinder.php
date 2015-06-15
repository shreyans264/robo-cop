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
			if(substr($x,-3) == ".js")
			{
				array_push($groupedFiles["js"],$file);
			}
			elseif(substr($x, -4) == ".css")
			{
				array_push($groupedFiles["css"],$file);
			}
			elseif(substr($x, -4) == ".php")
			{
				array_push($groupedFiles["php"],$file);
			}
			elseif(substr($x, -5) == ".html")
			{
				array_push($groupedFiles["html"],$file);
			}
		}
		return $groupedFiles;
	}
	private function scanForFiles($string)
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
			array_push($fileList,$sub);
			$pos = strpos($string, $findmeAfter,$endpos);
		}
		return $fileList;
	}

	public getFilesList($payload)
	{
		if($payload["event_type"] == "pull_request")
		{
			$mainDir = getcwd();
			chdir($mainDir . "/" . $payload["repository"]);
			shell_exec("git checkout " . $branch);
			if($payload["action"] == "synchronize"){
				$theDiff = shell_exec("git diff HEAD^ HEAD");
			}
			elseif($payload["action"] == "opened" || $payload["action"] == "reopened"){
				$theDiff = shell_exec("git diff master " . $branch);
			}
			else{
				$theDiff = "";
			}
			shell_exec("git checkout master");
			chdir($mainDir);
			$theList = $this->scanForFiles($theDiff);

		}
		elseif($payload["event_type"] == "push")
		{
			$theList = array_merge($payload["added"],$payload["modified"]);
		}
		else
		{
			$theList = array();
		}
		return $this->groupFiles($theList);
	}

}



?>