<?php
class grabDataFromPayload
{
	private function getPullData($load)
	{
		return array(
			"event_type" = "pull",
			"repository" = $load["pull_request"]["head"]["repo"]["name"],
			"owner" = $load["pull_request"]["head"]["repo"]["owner"]["login"],
			"branch" = $load["pull_request"]["head"]["ref"],
			"number" = $load["number"],
			"id" = $load["pull_request"]["head"]["sha"],
			"action" = $load["action"],
			"committer" = $load["commits"]["commiter"]
			);

	}
	private function getPushData($load)
	{
		return array(
			"event_type" = "push",
			"repository" = $load["repository"]["name"],
			"owner" = $load["repository"]["owner"]["name"],
			"branch" = substr($load["ref"], 11),
			"forced" = $load["forced"],
			"id" = $load["after"],
			"prevId" = $load["before"]
			);
	}

	public function getData($payload)
	{
		if(array_key_exists("pull_request", $payload))
		{
			return $this->getPullData($payload);
		}
		elseif(array_key_exists("commits", $payload))
		{
			return $this->getPushData($payload);
		}
		else
		{
			return array();
		}
	}
}


?>