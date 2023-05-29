<?php
  sleep(2);

  include('connection.php');
  $search = $_GET['q'];

  $sql = $conn -> query("SELECT * FROM product WHERE name LIKE '%$search%'");

  if($sql -> num_rows != 0 ){
    while($row = $sql -> fetch_array()){
      echo "
        <div onclick='quickView(this.id)' class='product' id='".$row['id']."'>
          <img src='".$row['product_photo']."' alt='".$row['name']."' />
          <p>".$row['name']."</p>
          <p>".$row['price']."</p>
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