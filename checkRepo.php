<?php

class checkRepo
{
	public function chkRepo($owner,$repo)
	{
		$mainDir=getcwd();
		if(!is_dir($mainDir . "/repo"))
		{
			shell_exec("mkdir repo");
		}
		if(is_dir($mainDir . "/repo/" . $repo) and is_dir($mainDir . "/repo/" . $repo . "/.git"))
		{
			chdir($mainDir . "/repo/" . $repo);
			shell_exec("git checkout master");
			shell_exec("git pull");
		}	
		else
		{
			chdir($mainDir . "/repo");
			if(is_dir($mainDir . "/repo/" . $repo))
			{
				shell_exec("rm -rf " . $repo);
			}
			shell_exec("git clone git@github.com:" . $owner . "/" . $repo . ".git");
		}
		chdir($mainDir);
	}
}


?>