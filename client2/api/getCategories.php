<?php
  // sleep(1);

  include('connection.php');

  $sql = $conn -> query("SELECT DISTINCT category FROM product");
  while($row = $sql -> fetch_array()){
    $count = $conn -> query("SELECT * FROM product WHERE category='".$row['category']."'");

    echo "
      <a name='".$row['category']."'>
        <img src='../assets/icon/".$row['category'].".png' />
        <h5>".$row['category']."</h5>
      </a>
    ";
  }

  $conn -> close();
?>