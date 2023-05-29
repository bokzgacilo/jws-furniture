<?php
  include('connection.php');

  $sql = $conn -> query("SELECT * FROM product");

  while($row = $sql -> fetch_array()){
    echo "
    <div class='t-data'>
      <p class='col-1'>".$row['id']."</p>
      <a id='".$row['id']."' onclick='viewImage(this.id)' class='col'>".$row['name']."</a>
      <p class='col-1'>".$row['price']."</p>
    </div>";
  }

  $conn -> close();
?>