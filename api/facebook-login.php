<?php 
	require '../config/facebook-config.php';
	$helper = $fb -> getRedirectLoginHelper();
	$loginUrl = $helper -> getLoginUrl('http://localhost/jws-furniture/api/facebook-callback.php');
	header("location:" . $loginUrl);
 ?>