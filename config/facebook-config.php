<?php
  session_start();
  require '../vendor/autoload.php';
	$fb = new Facebook\Facebook([
	  'app_id' => '778477127194753', // Replace {app-id} with your app id
	  'app_secret' => '4923a5b47ed7927795dda43b95d82dbd', // Replace {app_secret} with your app secret
	  'default_graph_version' => 'v2.10',
	]);
?>  