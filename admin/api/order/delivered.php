<?php
  include('../connection.php');

  $status = strtoupper($_GET['status']);

  $select = $conn -> query("SELECT * FROM production WHERE status='$status'");
  
  while($row = $select -> fetch_array()){
    echo "
      <div class='card mb-4 p-4'>
        <div>
          <a href='#order' id='".$row['reference_number']."' onclick='open_offcanvas(this.id)'>ID: ".$row['reference_number']."</a>
          <p class='is-size-7'>CLIENT ID: ".$row['client']."</p>
        </div>
        <div style='margin-left: auto;'>
          <p class='is-size-7 has-text-weight-medium is-success tag'>Order Complete</p>
        </div>
      </div>
    ";
  }

  $conn -> close();
?>