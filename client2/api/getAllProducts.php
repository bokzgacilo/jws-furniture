<?php
  sleep(3);

  include('connection.php');

  $sql = $conn -> query("SELECT * FROM product");

  while($row = $sql -> fetch_array()){
    echo "
      <div onclick='quickView(this.id)' class='product' id='".$row['id']."'>
        <img src='".$row['product_photo']."' alt='".$row['name']."' />
        <p>".$row['name']."</p>
        <p>".$row['price']."</p>
      </div>
    ";
  }
  
  $conn -> close();
?>