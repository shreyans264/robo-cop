<?php
class forcedPushed
{
	public function findEnforcer($load)
	{
		if($load["branch"] == "master")
		{
			$msg ="author: " . $load["author"] . "\ncommitter: " . $load["committer"];
			mail($load["owner_email"],"[Robo-Cop] Someone forced pushed into masters",$msg);
		}
	}
}


?>