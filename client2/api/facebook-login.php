<?php 
  require '../../vendor/autoload.php';
	// include('../../config/facebook-config.php');
  $fb = new Facebook\Facebook([
	  'app_id' => '778477127194753',
	  'app_secret' => '4923a5b47ed7927795dda43b95d82dbd',
	  'default_graph_version' => 'v2.10',
	]);


	$helper = $fb -> getRedirectLoginHelper();

	$loginUrl = $helper -> getLoginUrl('https://jws-furniture/client/api/facebook-callback.php');
  
	header("location:" . $loginUrl);
?>