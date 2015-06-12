<?php
class createComment
{
	public function createComment($msg, $line, $filename, $owner, $repository, $number, $id) {
	
		echo $msg . " : " . $line . " : " . $filename;
		require(__DIR__ . '/github-php-client/client/GitHubClient.php');
		$config = include "config.php";	
		$filename = str_replace("\ "," ", $filename);
		$client = new GitHubClient();
		$client->setCredentials($config["username"], $config["password"]);
		$commentTry=$client->pulls->comments->createComment($owner, $repository, $number, $msg, intval($line), $id, $filename);

	}
}



?>