<?php

class checkRepo()
{
	public function checkRepo($owner,$repo)
	{
		$mainDir=getcwd();
		if(is_dir($mainDir . "/" . $repo) and is_dir($mainDir . "/" . $repo . "/.git"))
		{
			chdir($mainDir . "/" . $repo);
			shell_exec("git checkout master");
			shell_exec("git pull");
		}	
		else
		{
			if(is_dir($mainDir . "/" . $repo))
			{
				shell_exec("rm -rf /" . $repo);
			}
			shell_exec("git clone git@github.com:" . $owner . "/" . $repository . ".git");
			chdir($mainDir . "/" . $repo);
		}	
	}
}


?>