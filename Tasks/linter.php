<?php
require_once(__DIR__ . '/../createComment.php');
class linter
{
	
	
	private function updateLog($report, $fileName, $fileType, $owner, $repository, $number, $id) {
		echo $report;
		$comment = new createComment();
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
						$comment->Comment($errorMsg,$lineNo,$fileName,$owner,$repository,$number,$id);
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
						$comment->Comment($errorMsg,$lineNo,$fileName,$owner,$repository,$number,$id);
						$pos = strpos($report, ".js: line ",$errEndPos);
					}
				}
				break;
			default:
				break;
		}
		return;

	}

	public function scanErrors($load,$groupedFiles)
	{
		//echo "scanning Errors";
		$mainDir = getcwd();
		chdir($mainDir . "/repo/" .$load["repository"]);
		shell_exec("git checkout " . $load["branch"]);
		foreach($groupedFiles as $type => $files)
		{
			if($type == "js")
			{
				foreach($files as $file)
				{
					echo $file;
					$errReport = shell_exec("jshint " . str_replace(" ","\ ",$file[0]));
					$this->updateLog($errReport, $file, "js",  $load["owner"], $load["repository"], $load["number"], $load["id"]);
				}
			}
			/*elseif($type == "php")
			{
				foreach($files as $file)
				{
					$errReport = shell_exec("php -l " . str_replace(" ","\ ",$file));
					$this->updateLog($errReport, $x, "php",  $owner, $repository, $number, $id);
				}
			}*/

		}
		shell_exec("git checkout master");
		chdir($mainDir);
	}





}


?>