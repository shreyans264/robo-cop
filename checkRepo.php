<?php

class checkRepo
{
	public function chkRepo($owner,$repo,$number)
	{
		$mainDir=getcwd();
		if(!is_dir($mainDir . "/repo"))
		{
			shell_exec("mkdir repo");
		}
		chdir($mainDir . "/repo");

		if(!is_dir($mainDir . "/repo/" . $owner))
		{
			shell_exec("mkdir " . $owner);
		}
		chdir($mainDir . "/repo/" . $owner);

		if(!is_dir($mainDir . "/repo/" . $repo))
		{
			shell_exec("mkdir " . $repo);
		}
		chdir($mainDir . "/repo/" . $repo);
		
		if(is_dir($mainDir . "/repo/" . $repo . "/".$number)) 
		{
			shell_exec("rm -rf " . $number);
		}

		shell_exec("mkdir ". $number);
		
		chdir($mainDir);
	}
}


?>