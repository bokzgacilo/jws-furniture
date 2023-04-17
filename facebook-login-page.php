<?php
  include('config/database.php');
  $uid = $_GET['id'];

  $client_name = '';

  $selectUser = $conn -> query("SELECT * FROM user WHERE uid='$uid'");
  while($row = $selectUser -> fetch_array()){
    $client_name = $row['name'];
  }

  $conn -> close();
  // echo $uid;
  // echo 'facebook login success';
?>

<html>
  <head>
    <title>Facebook Login - Success</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  </head>
  <body>
    <h2>Facebook Login Successful</h2>
    <a href="index.html">Back to Homepage</a>

    <script>
      localStorage.setItem('authenticated', 'true');
      localStorage.setItem('uid', <?php echo $uid; ?>)
    </script>
  </body>
</html>