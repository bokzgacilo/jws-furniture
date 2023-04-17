<?php
  include('../../config/database.php');

  $sql = $conn -> query("SELECT * FROM product");
  
  while($row = $sql -> fetch_array()){
    echo "
      <tr>
        <th scope='row'>".$row['id']."</th>
        <td>".$row['name']."</td>
        <td>".$row['price']."</td>
        <td>".$row['product_photo']."</td>
      </tr>
    ";
  }

  $conn -> close();
?>