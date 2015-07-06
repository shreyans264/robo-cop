<?php
class forcedPushed
{
	public function findEnforcer($load)
	{
		echo " forced push";
		if($load["branch"] == "master")
		{
			echo " in master";
			echo " " . $load["branch"];
			$msg ="owner: " . $load["owner"] . "\nauthor: " . $load["author"] . "\ncommitter: " . $load["committer"] . "\nrepository: " . $load["repository"] . "\nBranch: " . $load["branch"];
			mail("ray.dev@practo.com","[Robo-Cop] Someone forced pushed",$msg);
		}
	}
}


?>