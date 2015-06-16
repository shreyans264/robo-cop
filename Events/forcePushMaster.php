<?php
class forcedPushed
{
	public function findEnforcer($load)
	{
		echo " forced push";
		//if($load["branch"] == "master")
		//{
			echo " in master";
			echo " " . $load["branch"];
			$msg ="owner: " . $load["owner"] . "\nauthor: " . $load["author"] . "\ncommitter: " . $load["committer"] . "\nrepository: " . $load["repository"] . "\nPushed from Branch: " . $load["branch"];
			mail($load["owner_email"],"[Robo-Cop] Someone forced pushed",$msg);
			mail($load["author_email"],"[Robo-Cop] Someone forced pushed in your repo",$msg);
		//}
	}
}


?>