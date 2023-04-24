<?php
  session_start();
  include('connection.php');

  $email = $_POST['email'];
  $fullname = $_POST['fullname'];
  $photo = $_POST['photoURL'];
  $uid = $_POST['uid'];

  $selectUser = $conn -> query("SELECT * FROM user WHERE uid='$uid'");

  if($selectUser -> num_rows != 0){
    echo 1;
  }else {
    $sql = "INSERT INTO user(name, email, uid, photo_url) VALUES ('$fullname','$email', '$uid', '$photo')";
    $result = $conn -> query($sql);
    
    if($result){
      echo 1;
    }
  }

  $conn -> close();
?>