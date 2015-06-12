<?php
require(__DIR__ . '/../createComment.php');

class cssChecker
{
	private $comment = new createComment();
	private function notImpFinder($files)
	{
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
			    		$this->comment->createComment("Try to avoid !important",$lineNo,$file, $owner, $repository, $number, $id);
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
		$this->notImpFinder($files,$load["owner"], $load["repository"], $load["number"], $load["id"]);
	}
}


?>