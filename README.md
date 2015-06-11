# robo-cop
# robo-cop


Robo-cop a bot that gaurds your github repositories

scans the DIFF files on pull_request and comments on the problems if present.
currently scans the js files for syntax errors.

Data to be inheritted from webhooks payload


used github-php-client

*[8/06/2015]fixed pull_request review comment

*[11/06/2015]webhook grabbing payload functionality added not tested


REQUIRED
>PHP
>git
>jshint


Instructions
>add username and password in gitDiff.php file in createComment function

>create a public access to this service

>in github got to the repository to add hook

>goto settings-->Webhooks & Services-->click on Add Webhook

>enter the URL to the webhook file gitDiff.php in Payload URL

>set content type to application/x-www-form-urlencoded

>select the triggers you want to send payload for

>click Add webhook



