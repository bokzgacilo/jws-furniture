<?php
  include('../api/connection.php');

  $get_stock = $conn -> query("SELECT SUM(stock) as total_stock FROM product");
  $get_stock = $get_stock -> fetch_assoc();
  $get_sold = $conn -> query("SELECT SUM(sold) as total_sold FROM product");
  $get_sold = $get_sold -> fetch_assoc();

?>
<style>
  .total-number-container {
    display: grid;
    grid-template-columns: 20% 20% 20% 20%;
    justify-content: center;
  }

  .total-number {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
</style>

<p class="is-size-4 has-text-weight-bold">Inventory</p>
<div class="total-number-container">
  <div class="total-number">
    <p class="is-size-2 has-text-weight-semibold"><?php echo $get_stock['total_stock']; ?></p>
    <p class="is-size-7">Total number of products in inventory</p>
  </div>
  <div class="total-number">
    <p class="is-size-2 has-text-weight-semibold"><?php echo $get_sold['total_sold']; ?></p>
    <p class="is-size-7">Total number of products in inventory</p>
  </div>
</div>
<table class="table">
  <thead>
    <tr>
      <th>Product Name</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Sold</th>
      <th>Reviews</th>
    </tr>
  </thead>
  <tbody>
    <?php

      $select = $conn -> query("SELECT * FROM product");

      while($row = $select -> fetch_array()){
        $count = 0;
        
        if($row['review'] != "none"){
          $count = count(json_decode($row['review'], true));
        }

        echo "
          <tr>
            <td>".$row['name']."</td>
            <td>".$row['price']."</td>
            <td>".$row['stock']."</td>
            <td>".$row['sold']."</td>
            <td>$count</td>
          </tr>
        ";
      }
      
      $conn -> close();
    ?>
  </tbody>
</table>