<?php
  session_start();
  include('./config/database.php');
  use Xendit\Xendit;
  require './vendor/autoload.php';

  Xendit::setApiKey('xnd_development_KrH2sC5EUvrbDsCElxsQKUFhzRozuFg9zlJVu6Gln0wPpLqPluvFJqSEv2WSPKC5');

  if(isset($_SESSION['reference'])){
    $sql = "SELECT * FROM transactions WHERE reference_number='".$_SESSION['reference']."'";
    $result = $conn -> query($sql);
  
    $transaction_id = '';
    while($row = $result -> fetch_array()){
      $transaction_id = $row['transaction_id'];
    }
  
    $charge = \Xendit\EWallets::getEWalletChargeStatus(
      $transaction_id
    );
  
    $selectUser = $conn -> query("SELECT * FROM user WHERE uid='".$_SESSION['uid']."'");
    $client_cart = '';
    $order_cart = '';

    while($row = $selectUser -> fetch_array()){
      $client_cart = json_decode($row['cart'], true);
      if($row['orders'] == 'none'){
        $order_cart = [$transaction_id => $client_cart];
      }else {
        $order_cart = json_decode($row['orders'], true);
        $order_cart[$transaction_id] = $client_cart;
      }
    }

    $client_cart_string = json_encode($client_cart);
    $order_cart_string = json_encode($order_cart);

    $conn -> query("UPDATE user SET cart='none' WHERE uid='".$_SESSION['uid']."'");
    $conn -> query("UPDATE user SET orders='$order_cart_string' WHERE uid='".$_SESSION['uid']."'");

    if($charge['status'] == 'SUCCEEDED'){
      $conn -> query("UPDATE transactions SET status='SUCCEEDED', orders='$client_cart_string' WHERE reference_number='".$_SESSION['reference']."'");
      echo 'Payment Successful';
      echo "<a href='http://localhost/jws-furniture/cart.html'>Back to Cart</a>";
    }
  }else {
    echo "<a href='http://localhost/jws-furniture/cart.html'>Back to Cart</a>";
  }
  
  unset($_SESSION['reference']);
  $conn -> close();
?>