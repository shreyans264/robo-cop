# robo-cop
# robo-cop


Robo-cop a bot that guards your github repositories

scans the DIFF files on pull_request and comments on the problems if present.
currently scans the js files for syntax errors.

Data to be fetched from webhooks payload


used github-php-client

*[8/06/2015]fixed pull_request review comment

*[11/06/2015]webhook grabbing payload functionality added not tested

*[15/06/2015]tested and linked

REQUIRED

>PHP

>git
( On terminal type command : sudo apt-get install git )

>jshint
( Install node.js and then type the command : npm install -g jshint )

>php-client-api
(download composer.phar in directory and type command : php composer.phar install )



Instructions

>rename config.php.sample to config.php

>add username and password in config.php file

>create a public access to this service(you can use tools like ngrok for that)

>in github got to the repository to add hook

>goto settings-->Webhooks & Services-->click on Add Webhook

>enter the URL to the webhook file cop.php in Payload URL

>set content type to application/x-www-form-urlencoded

>select the triggers you want to send payload for

>click Add webhook



