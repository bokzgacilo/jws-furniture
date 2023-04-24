<?php
  include('connection.php');

  $uid = $_GET['uid'];

  $sql = "SELECT * FROM user WHERE uid='$uid'";
  $result = $conn -> query($sql);
  
  while($row = $result -> fetch_array()){
    if($row['cart'] == 'none'){
      echo "empty";
    }else {
      $cart_array = json_decode($row['cart'], true);
      echo "<h2>Items: ".count($cart_array)."</h2>";

      foreach ($cart_array as $key => $value) {
        $getProductDetails = $conn -> query("SELECT * FROM product WHERE id='".$value['id']."'");
        while($product = $getProductDetails -> fetch_array()){
          echo "
          <div class='cart-item'>
            <div class='cart-image'>
              <img src='".$product['product_photo']."' />
            </div>
            <div class='cart-detail'>
              <h6>".$product['name']."</h6>
              <p>Quantity and Price: ".$value['quantity']." x ".$product['price']."</p>
              <p>Subtotal: ".($value['quantity'] * $product['price'])."</p>
            </div>
            <div class='cart-action'>
              <button class='btn btn-danger btn-sm' id='$key' onclick='removeItem(this.id)'>Remove</button>
            </div>
          </div>";
        }
      }
    }
  }

  $conn -> close();
?>