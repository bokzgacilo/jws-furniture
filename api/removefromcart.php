<?php
  include('../config/database.php');

  $product_name = $_POST['product_name'];
  $uid = $_POST['uid'];

  $selectUser = "SELECT * FROM user WHERE uid='$uid'";
  $result = $conn -> query($selectUser);
  $userCart = '';

  while($row = $result -> fetch_array()){
    $userCart = json_decode($row['cart'], true);
  }

  // print_r($userCart);
  unset($userCart[$product_name]);
  // print_r($userCart);

  if(empty($userCart)){
    $updateCart = $conn -> query("UPDATE user SET cart='none' WHERE uid='$uid'");
  }else {
    $arrayString = json_encode($userCart);
    $updateCart = $conn -> query("UPDATE user SET cart='$arrayString' WHERE uid='$uid'");
  }

  $conn -> close();
?>