<?php
  include('connection.php');

  $orderID = $_GET['id'];

  $sql = $conn -> query("SELECT * FROM transactions WHERE reference_number='$orderID'");
  $sql = $sql -> fetch_assoc();

  $order_item = json_decode($sql['orders'], true);

  foreach ($order_item as $item) {
    $select_item = $conn -> query("SELECT * FROM product WHERE id='".$item['id']."'");

    while($row = $select_item -> fetch_array()){
      echo "
        <div class='order'>
          <div>
            <img src='".$row['product_photo']."' />
          </div>
          <div>
            <p>".$row['name']."</p>
            <p>₱ ".number_format($row['price'], 2, '.', ',')."</p>
            <p>Ordered: ".$item['quantity']."</p>
            <p>Total: ₱ ".number_format(($item['quantity']*$row['price']), 2, '.', ',')."</p>
          </div>
        </div>
      ";
    }
  }

  $conn -> close();
?>