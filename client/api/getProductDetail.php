<?php
  include('connection.php');

  $id = $_GET['id'];

  $sql = "SELECT * FROM product WHERE id='$id'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
      <img src='".$row['product_photo']."' />
      <h2>".$row['name']."</h2>
      <h3>PHP ".$row['price']."</h3>
      <input id='quantity$id' type='number' class='form-control' value='0'/>
      <button id='$id' class='btn btn-primary' onclick='addtocart(this.id)'>Order</button>
    ";
  }

  $conn -> close();
?>