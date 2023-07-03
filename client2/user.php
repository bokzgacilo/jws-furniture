<?php
  session_start();
  include('api/connection.php');

  if(!isset($_SESSION['client'])){
    header("location: shop.php");
  }

  $user = $conn -> query("SELECT * FROM user WHERE uid='".$_SESSION['client']."'");
  $user = $user -> fetch_assoc();

  $address = $conn -> query("SELECT * FROM address WHERE uid='".$user['uid']."'");
  $address = $address -> fetch_assoc();

  $userOrder = [];

  if($user['orders'] != 'none'){
    $userOrder = json_decode($user['orders'], true);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $user['name']; ?> - Profile</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/user.web.css">
  <link rel="icon" type="image/x-icon" href="../assets/logo.png">
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="../assets/sweetalert2@11.js"></script>
  <script src="js/user-ui.js"></script>
</head>
<body>
  <div id="order-products-view" class="modal">
    <div class="modal-background"></div>

    <div class="modal-card">
        <div class="modal-card-head">
          <p class="modal-card-title">Modal title</p>
          <button class="delete" aria-label="close"></button>
        </div>
        <div class="modal-card-body">
          <!-- Content ... -->
        </div>
    </div>

    <button class="modal-close is-large" aria-label="close"></button>
  </div>

  <main>
    <div class="profile-header">
      <a class="button is-link" href="shop.php">Back to Shopping</a>
    </div>
    <div class="basic card">
      <form id="avatarForm" enctype="multipart/form-data" class="avatar">
        <img id="avatar-preview" src="<?php echo $user['photo_url']; ?>" />
        <div class="file">
          <label class="file-label w-100">
            <input class="file-input" accept="image/*" type="file" name="avatar_input">
            <span class="file-cta w-100">
              <span class="file-icon">
                <i class="fas fa-upload"></i>
              </span>
              <span class="file-label">
                Choose a file…
              </span>
            </span>
          </label>
        </div>
      <button id="change-avatar-button" type="submit" class="button is-success" disabled>Change Avatar</button>

      </form>
      <div class="basic-meta">
        <h4 class="is-size-3 has-text-weight-semibold" ><?php echo $user['name'];?></h4>
        <p><?php echo $user['email'];?></p>
        <p><?php echo $address['contact'];?></p>

        <div class="mt-4 title-address">
          <p class="is-size-4 has-text-weight-bold">Delivery Address</p> 
          <a class="button is-small js-modal-trigger" data-target="modal-js-example">Edit</a>
        </div>
        <p><?php echo $address['block'];?></p>
        <p><?php echo $address['street'];?></p>
        <p><?php echo $address['barangay'];?></p>
        <p><?php echo $address['city'];?></p>
        <p><?php echo $address['province'];?></p>
      </div>
    </div>
    <p class="is-size-4 has-text-weight-bold">Orders <?php echo count($userOrder); ?></p>

    <div class="order-table">
      <?php
        if($user['orders'] != "none"){
          foreach ($userOrder as $order) {
            $select_order = $conn -> query("SELECT * FROM transactions WHERE reference_number='$order'");
            $show_status = $conn -> query("SELECT * FROM production WHERE client='".$user['uid']."' AND reference_number='$order'");
            $show_status = $show_status -> fetch_assoc();

            while($row = $select_order -> fetch_array()){
              $itemCount = count(json_decode($row['orders'], true));

              echo "
                <div class='order card pt-2 pb-2 pl-4 pr-4'>
                  <div>
                    <a class='is-size-6 has-text-weight-medium js-modal-trigger' id='$order' data-target='order-products-view'>$order</a>
                    <p class='is-size-7'>".date("F j, Y, g:i a", strtotime($row['date_created']))."</p>
                  </div>
                  <div>
                    <p>₱ ".number_format($row['amount'], 2, '.', ',')." <span class='is-size-7'>$itemCount item/s </span></p>
                  </div>
                  <div>
                    <p class='is-size-7'>".$show_status['status_description']."</p> 
                    <a class='is-size-7' target='_blank' href='https://www.messenger.com/t/100092144012686'>Contact JWS</a>
                  </div>
                </div>
              ";
            }
          }
        }            
      ?>  
      <!-- <table class="table">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Items</th>
            <th>Cost</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php

            if($user['orders'] != "none"){
              foreach ($userOrder as $order) {
                $select_order = $conn -> query("SELECT * FROM transactions WHERE reference_number='$order'");
                $show_status = $conn -> query("SELECT * FROM production WHERE client='".$user['uid']."' AND reference_number='$order'");
                $show_status = $show_status -> fetch_assoc();

                while($row = $select_order -> fetch_array()){
                  $itemCount = count(json_decode($row['orders'], true));
  
                  echo "
                    <tr>
                      <th>
                        $order
                        <a id='$order' class='js-modal-trigger view-order-button' data-target='order-products-view'>View</a>
                      </th>
                      <th>".date("F j, Y, g:i a", strtotime($row['date_created']))."</th>
                      <th>
                        $itemCount Items
                      </th>
                      <th>₱ ".number_format($row['amount'], 2, '.', ',')."</th>
                      <th>
                        <span class='tag is-primary'>".$show_status['status']."</span>
                      </th>
                    </tr>
                  ";
                }
              }
            }            
          ?>
        </tbody> -->
      </table>
    </div>
  </main>

  <div id="modal-js-example" class="modal">
  <div class="modal-background"></div>

  <div class="modal-content">
      <div class="box" id="address-modal-content">
        <p class="is-size-4">Edit Address</p>
        <form id="addressForm">
          <p class="is-size-6">Contact Number</p>
          <input type="text" name="contact" class="input" value="<?php echo $address['contact']; ?>"/>
          <p class="is-size-6">House Number/ Block/ Lot</p>
          <input type="text" name="block" class="input" value="<?php echo $address['block']; ?>"/>
          <p class="is-size-6">Street</p>
          <input type="text" name="street" class="input" value="<?php echo $address['street']; ?>"/>
          <p class="is-size-6">Barangay</p>
          <input type="text" name="barangay" class="input" value="<?php echo $address['barangay']; ?>"/>
          <p class="is-size-6">City</p>
          <input type="text" name="city" class="input" value="<?php echo $address['city']; ?>"/>
          <p class="is-size-6">Province</p>
          <input type="text" name="province" class="input" value="<?php echo $address['province']; ?>"/>
          <button class="button is-success" type="submit">Update Address</button>
        </form>
        <!-- Your content -->
      </div>
    </div>

    <button class="modal-close is-large" aria-label="close"></button>
  </div>

  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/user.js"></script>
</body>
</html>