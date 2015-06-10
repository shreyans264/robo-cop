<?php
$username='shreyans264';
$password='sj9672522331';

require_once(__DIR__ . '/client/GitHubClient.php');

$client = new GitHubClient();
$client->setCredentials($username, $password);

$owner='shreyans264';
$repo='robo-cop';
$title="It is a Test";
$body='checking github php client';
$position="1";

$pullReqs = $client->pulls->listPullRequests($owner, $repo);
foreach($pullReqs as $pullReq){
	$number=$pullReq->getNumber();
	$id=$pullReq->getId();
	echo $pullReq->getTitle() . "\n";
	echo $pullReq->getBody() . "\n";
	$foo = $client->pulls->comments->createComment($owner, $repo, $number,$body,$position);




}
?>