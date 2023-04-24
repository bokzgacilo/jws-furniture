<?php
  include('connection.php');

  $sql = "SELECT * FROM product";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
    <div class='box'>
      <div class='icons'>
        <a id=".$row['id']." onclick='openProductModal(this.id)' data-bs-target='#staticBackdrop' class='fas fa-shopping-cart'></a>
      </div>
      <div class='image'>
          <img src=".$row['product_photo'].">
      </div>
      <div class='content'>
        <div class='price'>PHP ".$row['price']."</div>
        <h3>".$row['name']."</h3>
        <div class='stars'>
          <i class='fas fa-star'></i>
          <i class='fas fa-star'></i>
          <i class='fas fa-star'></i>
          <i class='fas fa-star'></i>
          <i class='far fa-star'></i>
          <span>(50)</span>
        </div>
      </div>
    </div>
    ";
  }


  $conn -> close();
?>