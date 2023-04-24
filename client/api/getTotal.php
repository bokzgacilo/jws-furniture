<?php
  include('connection.php');
  $uid = $_GET['uid'];

  $selectUser = $conn -> query("SELECT * FROM user WHERE uid='$uid'");
  $userCart = '';

  while($row = $selectUser -> fetch_array()){
    if($row['cart'] != 'none'){
      $userCart = json_decode($row['cart'], true);

      $total_price = 0;

      foreach ($userCart as $key => $cart) {
        $item_price = $userCart[$key]['total_price'];
        $total_price += $item_price;
      }

      echo "
      <hr>

      <input type='number' id='total_price' class='form-control' readonly value='$total_price' />
      <button id='proceed-button' onclick='proceed_checkout()' class='btn btn-primary w-100'>Proceed Checkout</button>
      <a href='https://invoice-staging.xendit.co/od/jwsfurniture'>Another Link for Payment</a>
      ";
    }
  }
 
  $conn -> close();
?>