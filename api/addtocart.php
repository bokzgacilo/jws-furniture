<?php
  include('../config/database.php');

  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  $uid = $_POST['uid'];

  $selectUser = $conn -> query("SELECT * FROM user WHERE uid='$uid'");
  $selectProduct = $conn -> query("SELECT * FROM product WHERE id='$id'");
  
  $userCart = '';
  $productName = '';
  $productPrice = '';

  while($row = $selectProduct -> fetch_array()){
    $productName = $row['name'];
    $productPrice = $row['price'];
  }

  while($row = $selectUser -> fetch_array()){
    $userCart = $row['cart'];
  }
  
  if($userCart == 'none'){
    $total_price = $productPrice * $quantity;
    $newProduct = array(
      "id" => $id,
      "name" => $productName,
      "quantity" => $quantity,
      "total_price" => $total_price
    );
    $userCart = [$productName => $newProduct];
  }else {
    $userCart = json_decode($userCart, true);
    $newCart = '';
  
    if (array_key_exists($productName, $userCart)){
      $userCart[$productName]['quantity'] = $quantity;
    }else {
      $total_price = $productPrice * $quantity;
      $newProduct = array(
        "id" => $id,
        "name" => $productName,
        "quantity" => $quantity,
        "total_price" => $total_price
      );
      $userCart[$productName] = $newProduct;
    }
  }

  $arrayString = json_encode($userCart);
  $updateCart = $conn -> query("UPDATE user SET cart='$arrayString' WHERE uid='$uid'");
  
  if($updateCart){
    echo 'success';
  }else {
    echo 'failed';
  }

  $conn -> close();
?>