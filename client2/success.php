<?php
  use Xendit\Xendit;
  session_start();
  include('api/connection.php');
  require '../vendor/autoload.php';

  $user = $conn -> query("SELECT * FROM user WHERE uid='".$_SESSION['client']."'");
  $user = $user -> fetch_assoc();

  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $reference_id = '';

  for ($i = 0; $i < 16; $i++) {
    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
  }

  if(isset($_SESSION['maya_reference_number'])){
    $reference_id = $_SESSION['maya_reference_number'];
  }

  if(isset($_SESSION['gcash_reference_number'])){
    $reference_id = $_SESSION['gcash_reference_number'];
  }

  $user_orders = $user['orders'];
  $cart_order = $user['cart'];
  
  $order_array = [];
  $array_imploded = '';

  if($user_orders == 'none'){
    array_push($order_array, $reference_id);
    $array_imploded = json_encode($order_array);
  }else {
    $orders = json_decode($user_orders, true);
    array_push($orders, $reference_id);
    $array_imploded = json_encode($orders);
  }

  switch($_SESSION['payment_method']){
    case 'GCASH' : 
      if(!isset($_SESSION['payment_status'])){
        header("location: cart.php");
      }
      
      Xendit::setApiKey('xnd_development_KrH2sC5EUvrbDsCElxsQKUFhzRozuFg9zlJVu6Gln0wPpLqPluvFJqSEv2WSPKC5');

      $status = \Xendit\EWallets::getEWalletChargeStatus(
        $_SESSION['transaction_id']
      );
    
      if($status['status'] == 'SUCCEEDED'){
        $reference_id = $status['reference_id'];
    
        // Updating Transaction Status
        $conn -> query("UPDATE transactions SET status='SUCCEEDED' WHERE reference_number='$reference_id'");

        // Creating Order for Production
        $conn -> query("INSERT INTO production (reference_number, client, orders) VALUES(
          '".$reference_id."',
          '".$_SESSION['client']."',
          '".$cart_order."'
        )");
    
        // Updating Transaction Status
        $conn -> query("UPDATE user SET orders='$array_imploded' WHERE uid='".$_SESSION['client']."'");
    
        $conn -> query("UPDATE user SET cart='none' WHERE uid='".$_SESSION['client']."'");
      }

      break;
    case 'MAYA':
      $status = "SUCCEEDED";

      $sql = $conn -> query("INSERT INTO transactions(transaction_id,mode,reference_number, checkout_url, amount, orders, status) VALUES(
        '".$_SESSION['maya_checkout_id']."',
        'MAYA',
        '".$_SESSION['maya_reference_number']."',
        '".$_SESSION['maya_href']."',
        '".$_SESSION['maya_amount']."',
        '$cart_order',
        '$status'
      )");

      // Creating Order for Production
      $conn -> query("INSERT INTO production (reference_number, client, orders) VALUES(
        '".$_SESSION['maya_reference_number']."',
        '".$_SESSION['client']."',
        '".$cart_order."'
      )");

      // Updating Transaction Status
      $conn -> query("UPDATE user SET orders='$array_imploded' WHERE uid='".$_SESSION['client']."'");
  
      $conn -> query("UPDATE user SET cart='none' WHERE uid='".$_SESSION['client']."'");

      break;
    case 'PAYPAL':
      require_once('api/paypal-config.php');

      if(array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)){
        $transaction = $gateway -> completePurchase(array(
          'payer_id' => $_GET['PayerID'],
          'transactionReference' => $_GET['paymentId']
        ));

        $response = $transaction -> send();
        
        if($response -> isSuccessful()){
          $arr_body = $response -> getData();

          print_r($arr_body);

          if($arr_body['state'] == 'approved'){
            $transaction_id = $arr_body['id'];
            $reference_number = $reference_id;
            $amount = $arr_body['transactions'][0]['amount']['total'];
            $status = "SUCCEEDED";
            $checkout_url = "none";
            
            $sql = $conn -> query("INSERT INTO transactions(transaction_id,mode, reference_number, checkout_url, amount, orders, status) VALUES(
              '$transaction_id',
              'PAYPAL'
              '$reference_number',
              '$checkout_url',
              '$amount',
              '$cart_order',
              '$status'
            )");

            // Creating Order for Production
            $conn -> query("INSERT INTO production (reference_number, client, orders) VALUES(
              '".$reference_id."',
              '".$_SESSION['client']."',
              '".$cart_order."'
            )");

            // Updating Transaction Status
            $conn -> query("UPDATE user SET orders='$array_imploded' WHERE uid='".$_SESSION['client']."'");
        
            $conn -> query("UPDATE user SET cart='none' WHERE uid='".$_SESSION['client']."'");
          }
        }else {
          echo $response -> getMessage();
        }
      }else { 
        echo 'Transaction is declined';
      }

      break;
  }
  
?>

<!DOCTYPE html>
<html>
    <head>
      <title><?php echo $_SESSION['payment_method']; ?> - Payment Successful</title>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <div class="container">
        <p class="is-size-4 has-text-weight-bold">Payment Successful</p>
        <a class="button is-link" href="../index.php">Back to Homepage</a>
      </div>
    </body>
  </html>

<?php
  unset($_SESSION['maya_checkout_id']);
  unset($_SESSION['maya_reference_number']);
  unset($_SESSION['gcash_reference_number']);
  unset($_SESSION['maya_amount']);
  unset($_SESSION['maya_href']);
?>