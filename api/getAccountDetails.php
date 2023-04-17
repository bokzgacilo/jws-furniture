<?php
  include('../config/database.php');

  $uid = $_GET['uid'];
  $sql = "SELECT * FROM user WHERE uid='$uid'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
      <h4>".$row['name']."</h4>
      <img class='ms-2 avatar' onclick='openSidebar()' src='".$row['photo_url']."'>
      <a class='signout-button' onclick='signout()'>Signout</a>
    ";
  }
  
  $conn -> close();
?>