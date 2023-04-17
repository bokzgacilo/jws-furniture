<?php
  include('../config/database.php');

  $uid = $_GET['uid'];

  $sql = "SELECT * FROM user WHERE uid='$uid'";
  $result = $conn -> query($sql);

  $orders = '';

  while($row = $result -> fetch_array()){
    if($row['orders'] == 'none'){
      echo "<h2>No Transaction</h2>";
    }else {
      echo "<h2>Transactions</h2>";

      $orders = $row['orders'];

      $order_array = json_decode($orders, true);
      // print_r($order_array);
      
      foreach ($order_array as $key => $value) {
        // print_r($order_array);
        // echo $order_array[$key];
        echo "<a class='transaction' onclick='getTransactionDetail(this.id)' id='$key'>$key</a>";
      }
    }
  }

  $conn -> close();
?>