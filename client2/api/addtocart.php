<?php
  include('connection.php');
  session_start();

  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  $user = $_SESSION['client'];

  $getUserCart = $conn -> query("SELECT * FROM user WHERE id='".$user."'");
  $cart = "";
  while($row = $getUserCart -> fetch_array()){
    $cart = $row['cart'];
  }

  $cartJSON = json_decode($cart, true);
  $searchKey = 'id';
  $searchValue = "$id";

  foreach ($cartJSON as $cartJSON) {
    foreach ($cartJSON as $key => $value) {
      if($key === $searchKey && $value === $searchValue){
        echo "Found the value '$searchValue' in the key '$searchKey' of an object.";
        break 2;
      }
    }
  }

  // echo 'not in the cart';
  
  echo json_encode($cartJSON);
  
  $conn -> close();
?>