<?php
  session_start();
  include('connection.php');

  $update = $conn -> query("UPDATE address SET 
    contact='".$_POST['contact']."',
    block='".$_POST['block']."', 
    street='".$_POST['street']."', 
    barangay='".$_POST['barangay']."', 
    city='".$_POST['city']."', 
    province='".$_POST['province']."' WHERE uid='".$_SESSION['client']."'");

  if($update){
    echo 1;
  }else {
    echo 2;
  }

  $conn -> close();
?>