<?php 
	require '../config/facebook-config.php';
	$helper = $fb -> getRedirectLoginHelper();
	$loginUrl = $helper -> getLoginUrl('https://jwsfurniture.website/api/facebook-callback.php');
	header("location:" . $loginUrl);
?>