<?php
  session_start();
  require_once '../../vendor/autoload.php';
  include('connection.php');
  $client = new Google\Client();
  $client -> setAuthConfig('google-client.json');
  
  // DEVELOPMENT
  $client -> setRedirectUri('http://localhost/jws-furniture/client2/api/google-login.php');
  // LIVE
  // $client -> setRedirectUri('https://jwsfurniture.website/api/google-login.php');


  $client -> addScope('profile');
  $client -> addScope('email');

  if (isset($_GET['code'])) {
    $token = $client -> fetchAccessTokenWithAuthCode($_GET['code']);

    $google_service = new Google_Service_Oauth2($client);

    $userData = $google_service -> userinfo -> get();
    
    $uid = $userData['id'];
    $email = $userData['email'];
    $name = $userData['name'];
    $picture = $userData['picture'];


    // print_r($userData);
    echo "$uid, $email, $name";

    $checkUser = $conn -> query("SELECT * FROM user WHERE uid='$uid'");

    $_SESSION['authenticated'] = 'true';

    if($checkUser -> num_rows == 0){
      echo 'new user';

      $sql = "INSERT INTO user(name, uid, photo_url, email) VALUE(
        '$name',
        '$uid',
        '$picture',
        '$email'
      )";

      $result = $conn -> query($sql);

      if($result){
        echo 1;
      }else {
        echo 0;
      }
    }
  }else {
    header("location:" . $client -> createAuthUrl());
  }

  $conn -> close();
?>

<?php
  if(isset($_SESSION['authenticated'])){
?>
  <html>
    <head>
      <title>Google Login - Success</title>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    </head>
    <body>
      <h2>Google Login Successful</h2>
      <a href="../index.html">Back to Homepage</a>

      <script>
        localStorage.setItem('authenticated', 'true');
        localStorage.setItem('uid', '<?php echo $uid; ?>')
      </script>
    </body>
  </html>
<?php 
    unset($_SESSION['authenticated']);
  }
?>

