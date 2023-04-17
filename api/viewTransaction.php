<?php
  include('../config/database.php');
  require '../vendor/autoload.php';

  use Xendit\Xendit;
  Xendit::setApiKey('xnd_development_KrH2sC5EUvrbDsCElxsQKUFhzRozuFg9zlJVu6Gln0wPpLqPluvFJqSEv2WSPKC5');

  $transaction_id = $_GET['transaction_id'];

  $charge = \Xendit\EWallets::getEWalletChargeStatus(
    $transaction_id
  );

  $selectTransaction = $conn -> query("SELECT * FROM transactions WHERE transaction_id='$transaction_id'");
  
  while($row = $selectTransaction -> fetch_array()){
    $orders = json_decode($row['orders'], true);
    echo "<h3>Items</h3>";
    foreach ($orders as $key => $value) {
      # code...
      $getPhoto = $conn -> query("SELECT * FROM product WHERE name='".$value['name']."'");
      $photo = '';

      while($product = $getPhoto -> fetch_array()){
        $photo = $product['product_photo'];
      }

      // print_r($value);
      echo "<div class='item'>
        <div class='item-image'>
          <img src='$photo' />
        </div>
        <div class='item-details'>
          <p>".$value['name']."</p>
          <p>".$value['quantity']."</p>
          <p>".$value['total_price']."</p>
        </div>
      </div>";
    }

    echo "<h3>Details</h3>";
    // print_r($charge);
    echo "
    <h5>Total Price: ".$charge['charge_amount']."</h5>
    <h5>Status: <span class='badge bg-success'>".$charge['status']."</span></h5>
    ";
  }

  // print_r($charge);

  $conn -> close();
?>