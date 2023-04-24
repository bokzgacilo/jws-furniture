<?php
  include('../../config/database.php');

  $name = $_POST['name'];
  $price = $_POST['price'];
  $url = $_POST['url'];

  $sql = $conn -> query("INSERT INTO product(name, price, product_photo) VALUES(
    '$name',
    '$price',
    '$url'
  )");

  if($sql){
    echo 1;
  }else {
    echo 0;
  }

  $conn -> close();
?>