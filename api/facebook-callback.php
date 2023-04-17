<?php 
  error_reporting(0);
	require '../config/facebook-config.php';
  include('../config/database.php');

	$helper = $fb -> getRedirectLoginHelper();
  $accessToken = $helper -> getAccessToken();

  $responseUser = $fb -> get('/me?fields=id,name,link', $accessToken);
  $responseImage = $fb->get('/me/picture?redirect=false&type=large', $accessToken);
  $pictureData = $responseImage -> getDecodedBody();
  $pictureUrl = $pictureData['data']['url'];

  $user = $responseUser -> getGraphUser();

  $token = $accessToken -> getValue();
  $uid = $user -> getId();
  $name = $user['name'];

  // $url = "https://graph.facebook.com/$user_id?fields=email&access_token=$token";
  // $responseEmail = file_get_contents($url);
  // $data = json_decode($responseEmail);
  // $email = $data -> email;

  $checkUser = $conn -> query("SELECT * FROM user WHERE uid='$uid'");
  if($checkUser -> num_rows == 0){
    $sql = "INSERT INTO user(name, uid, photo_url, email) VALUE(
      '$name',
      '$uid',
      '$pictureUrl',
      'Email is private.'
    )";

    $result = $conn -> query($sql);

    if($result){
      echo 1;
    }else {
      echo 0;
    }
  }else {
    echo 2;
  }
  
  header("location: ../facebook-login-page.php?id=$uid");

  $conn -> close();
?>