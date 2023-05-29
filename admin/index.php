<?php
  session_start();

  if(!isset($_SESSION['logged'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login JWS Furniture Admin</title>
  <link rel="stylesheet" href="css/style.css" />
  <script src="js/jquery-3.6.4.min.js"></script>
</head>
<body>
  <style>
    body {
      display: grid;
      place-items: center;
    }

    form {
      margin-top: 5rem;
      width: 400px;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    form > img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      align-self: center;
    }
  </style>
    <form id="loginForm">
      <img src="../assets/logo.png"/>
      <h5 class="mt-4 mb-2">Admin Login</h5>
      <input required class="form-control" name="username" type="text" placeholder="Username" />
      <input required class="form-control" name="password" type="password" placeholder="Password" />
      <button class="btn btn-primary" type="submit">LOGIN</button>
    </form>
  </body>

  <script>
    $(document).ready(function(){
      // alert()
      $('#loginForm').submit(function(event){
        event.preventDefault();

        var data = {
          username: $("[name='username']").val(),
          password: $("[name='password']").val()
        }

        $.ajax({
          type: 'post',
          url: 'api/login.php',
          data: data,
          success: (response) => {
            console.log(response)

            if(response == 1){
              location.href = 'dashboard.php';
            }
            $('#loginForm')[0].reset();
          }
        })
      })
    })
  </script>
</html>

<?php
  }else {
    header('location: dashboard.php');
  }
?>