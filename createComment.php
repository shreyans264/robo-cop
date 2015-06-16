<?php
class createComment
{
	public function Comment($msg, $line, $filename, $owner, $repository, $number, $id) {
	
		echo $msg . " : " . $line . " : " . $filename;
		require_once(__DIR__ . '/vendor/tan-tan-kanarek/github-php-client/client/GitHubClient.php');
		$config = include "config.php";	
		$filename = str_replace("\ "," ", $filename);
		$client = new GitHubClient();
		$client->setCredentials($config["username"], $config["password"]);
		$commentTry = $client->pulls->comments->createComment($owner, $repository, $number, $msg, intval($line), $id, $filename);

	}
}



?>