<?php
  session_start();
  require '../vendor/autoload.php';
	$fb = new Facebook\Facebook([
	  'app_id' => '901939544433136', // Replace {app-id} with your app id
	  'app_secret' => 'b24a86674c7000d632121a01deb1d968', // Replace {app_secret} with your app secret
	  'default_graph_version' => 'v2.10',
	]);
?>  