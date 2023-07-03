<?php
  include('connection.php');

  $sql = $conn -> query("SELECT * FROM product");

  while($row = $sql -> fetch_array()){
    echo "
    <div data-target='product-modal' class='js-modal-trigger card p-4' id='".$row['id']."' onclick='viewImage(this.id)'>
      <img src='".$row['product_photo']."' />
      <p class='is-size-5 has-text-weight-semibold'>".$row['name']."</p>
      <p class='is-size-5'>₱ ".number_format($row['price'], 2, '.', ',')."</p>
    </div>";
  }

  $conn -> close();
?>