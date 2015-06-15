<?php
require_once(__DIR__ . '/../createComment.php');

class cssChecker
{

	private function notImpFinder($files,$owner,$repository,$number,$id)
	{
		$comment = new createComment();
		foreach($files as $file)
		{
			$handle = fopen($file, "r");
			if ($handle)
			{
				$lineNo = 0;
			    while (($line = fgets($handle)) !== false)
			    {
			    	$lineNo+=1;
			    	if(strpos($line,"!important"))
			    	{
			    		echo $lineNo;
			    		echo "\n";   		
			    		$comment->Comment("Try to avoid !important",$lineNo,$file, $owner, $repository, $number, $id);
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

	public function cssCheck($files,$load) 
	{
		$mainDir = getcwd();
		chdir($mainDir . "/" . $load["repository"]);
		$this->notImpFinder($files,$load["owner"], $load["repository"], $load["number"], $load["id"]);
		chdir($mainDir);
	}
}


?>