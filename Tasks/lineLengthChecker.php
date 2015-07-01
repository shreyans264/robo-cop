<?php
require_once(__DIR__ . '/../createComment.php');

class lineLengthChecker
{

	private function longLineFinder($files,$owner,$repository,$number,$id)
	{
		$comment = new createComment();
		foreach($files as $file)
		{
			echo $file[0];
			$handle = fopen($file[0], "r");
			if ($handle)
			{
				$lineNo = 0;
			    while (($line = fgets($handle)) !== false)
			    {
			    	$lineNo+=1;
			    	if(strlen($line)>80)
			    	{
			    		echo $lineNo;
			    		echo "\n"; 
				    		$comment->Comment("Please do not exceed 80 chars per line.",$lineNo,$file, $owner, $repository, $number, $id);
			    	}
			    }
			    fclose($handle);
			}
			else
			{
				echo "Problem Opening the file.\n";
			} 	
		}
	}

	public function lineLengthCheck($files,$load) 
	{
		$mainDir = getcwd();
		chdir($mainDir . "/repo/" . $load["repository"]);
		$this->longLineFinder($files,$load["owner"], $load["repository"], $load["number"], $load["id"]);
		chdir($mainDir);
	}
}


?>