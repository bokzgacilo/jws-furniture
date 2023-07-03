<?php

  include('connection.php');
  $search = $_GET['q'];

  $sql = $conn -> query("SELECT * FROM product WHERE name LIKE '%$search%'");

  if($sql -> num_rows != 0 ){
    while($row = $sql -> fetch_array()){
      echo "
        <div onclick='quickView(this.id)' class='product card' id='".$row['id']."'>
          <p class='has-text-right has-text-weight-bold is-size-7'>".$row['stock']."  in stock</p>
          <img src='".$row['product_photo']."' alt='".$row['name']."' />
          <p class='is-size-6 has-text-weight-semibold'>".$row['name']."</p>
          <div class='is-size-5 has-text-weight-semibold'>₱ ".number_format($row['price'], 2, '.', ',')." <span class='is-size-7'>".$row['sold']." sold </span></div>
        </div>
      ";
    }
  }else {
    echo "
      <p>No results found for $search</p> 
    ";
  }

  $conn -> close();
?>