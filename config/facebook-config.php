<?php
  session_start();
  // Include the autoloader provided in the SDK
  require '../vendor/autoload.php';

  // define('APP_ID', '776444090430275');
  // define('APP_SECRET', 'af938dd001b31a1c77c6ce4cedaffc50');
  // define('API_VERSION', 'v2.5');
  // define('FB_BASE_URL', 'http://localhost/furniture/');

  // define('BASE_URL', 'http://localhost/furniture/');

  // if(!session_id()){
  //     session_start();
  // }

  // // Call Facebook API
  // $fb = new Facebook\Facebook([
  // 'app_id' => APP_ID,
  // 'app_secret' => APP_SECRET,
  // 'default_graph_version' => API_VERSION,
  // ]);

  // 	session_start();
	// require './vendor/autoload.php';
  
	$fb = new Facebook\Facebook([
	  'app_id' => '776444090430275', // Replace {app-id} with your app id
	  'app_secret' => 'af938dd001b31a1c77c6ce4cedaffc50', // Replace {app_secret} with your app secret
	  'default_graph_version' => 'v2.10',
	]);
  // header("location: $fb_login_url");
?>