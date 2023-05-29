<?php
  include('api/connection.php');
  session_start();
  $userID = $_SESSION['client'];
  $sql = $conn -> query("SELECT * FROM user WHERE id=$userID");

  $cartHTML = "";
  $cartJSON = "";

  while($row = $sql -> fetch_array()){
    $cart = $row['cart'];
    $cartJSON = json_decode($cart, true);

    foreach ($cartJSON as $value => $item) {
      $productQuery = $conn -> query("SELECT * FROM product WHERE id='".$item['id']."'");
      $product = $productQuery -> fetch_assoc();

      $cartHTML .= "
        <div class='order'>
          <div class='opd'>
            <img src='".$product['product_photo']."' />
            <div>
              <h6>".$product['name']."</h6>
              <a class='mt-2'>Remove</a>
            </div>
          </div>
          <div class='quantity text-center'>
            <a>
              <i class='fa-solid fa-minus'></i>
            </a>
            <p>2</p>
            <a>
              <i class='fa-solid fa-plus'></i>
            </a>
          </div>
          <p class='text-center'>₱".$product['price']."</p>
          <p class='text-center'>₱".($product['price']*$item['quantity'])."</p>
        </div>
      ";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.web.css">
  <link rel="stylesheet" href="css/cart.web.css">
  <link rel="icon" type="image/x-icon" href="../assets/logo.png">
  <script src="js/jquery-3.6.4.min.js"></script>
</head>
<body>
  <!-- Navigator -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="navigator" aria-labelledby="navigatorLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="navigatorLabel">Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <a href="shop.php">Catalogs</a>
      <a href="">New Arrivals</a>
      <a href="">Help</a>
      <a href="">About</a>
    </div>
  </div>

  <!-- Not Logged OffCanvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="account" aria-labelledby="accountLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="accountLabel">Account</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <a href="api/login.php">Login</a>
    </div>
  </div>

  <!-- Logged OffCanvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="loggedAccount" aria-labelledby="loggedAccountLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="loggedAccountLabel">Account</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <?php
        echo $_SESSION['client'];
      ?>
      <a href="api/logout.php">Logout</a>
    </div>
  </div>

  <main>
    <header>
      <div class="brand">
        <img src="../assets/logo.png" />
        <h5>JWS FURNITURES</h5> 
      </div>
      <form id="searchForm">
        <input type="text" name="q" placeholder="Search in JWS Furniture" >
        <button>
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
      <div class="action">
        <?php
          if(isset($_SESSION['client'])){
            echo "
              <a title='My Cart' href='cart.php'>
                <i class='fa-solid fa-cart-shopping'></i>
              </a>
              <a data-bs-toggle='offcanvas' href='#loggedAccount' role='button' aria-controls='loggedAccount' title='My Account'>
                <img src='../assets/default-picture.jpg' />
              </a>
            ";
          }else {
            echo "
              <a data-bs-toggle='offcanvas' href='#account' role='button' aria-controls='account' title='Account'>
                <i class='fa-solid fa-user'></i>
              </a>
            ";
          }
        ?>

        <a data-bs-toggle='offcanvas' href='#navigator' role='button' aria-controls='navigator' title="Show Menu">
          <i class="fa-solid fa-bars"></i>
        </a>
      </div>
    </header>
    <article>
      <div class="shopping-cart">
        <a href="shop.php">
          <i class="fa-solid fa-regular fa-arrow-left-long"></i>
          Continue Shopping
        </a>
        <div class="sc-header">
          <h4>Shopping Cart</h4>
          <h4><?php echo count($cartJSON); ?> Items</h4>
        </div>
        <div class="cart">
          <div class="my-cart-header">
            <p>PRODUCT DETAILS</p>
            <p class="text-center">QUANTITY</p>
            <p class="text-center">PRICE</p>
            <p class="text-center">TOTAL</p>
          </div>
          <div class="my-order">
            <?php echo $cartHTML; ?>
            <!-- <div class="order">
              <div class="opd">
                <img src="../uploads/products/111196-W-2.jpg" />
                <div>
                  <h6>Testing Product</h6>
                  <a class="mt-2">Remove</a>
                </div>
              </div>
              <div class="quantity text-center">
                <a>
                  <i class="fa-solid fa-minus"></i>
                </a>
                <p>2</p>
                <a>
                  <i class="fa-solid fa-plus"></i>
                </a>
              </div>
              <p class="text-center">₱44.00</p>
              <p class="text-center">₱88.00</p>
            </div>
            <div class="order">
              <div class="opd">
                <img src="../uploads/products/chair.jpg" />
                <div>
                  <h6>Testing Product</h6>
                  <a class="mt-2">Remove</a>
                </div>
              </div>
              <div class="quantity text-center">
                <a>
                  <i class="fa-solid fa-minus"></i>
                </a>
                <p>1</p>
                <a>
                  <i class="fa-solid fa-plus"></i>
                </a>
              </div>
              <p class="text-center">₱249.99</p>
              <p class="text-center">₱249.99</p>
            </div>
            <div class="order">
              <div class="opd">
                <img src="../uploads/products/computer-table.jpg" />
                <div>
                  <h6>Testing Product</h6>
                  <a class="mt-2">Remove</a>
                </div>
              </div>
              <div class="quantity text-center">
                <a>
                  <i class="fa-solid fa-minus"></i>
                </a>
                <p>1</p>
                <a>
                  <i class="fa-solid fa-plus"></i>
                </a>
              </div>
              <p class="text-center">₱119.99</p>
              <p class="text-center">₱119.99</p>
            </div> -->
          </div>
        </div>
      </div>
      <div class="order-summary">
        <h4>Order Summary</h4>
        <div class="total-price">
          <p>3 ITEMS</p>
          <p>₱457.98</p>
        </div>
        <hr>
        <div class="total-price">
          <h6>Shipping Details</h6>
          <a href="">Edit</a>
        </div>
        <div class="shipping-details">
          <p>Name: Ariel Jericko Gacilo</p>
          <p>Contact Number: 09762220951</p>
          <p>House/Building Number: Block 282 Lot 5</p>
          <p>Street: Lilac Street</p>
          <p>Barangay: Rizal</p>
          <p>Municipality: Makati</p>
          <p>Region: Metro Manila</p>
        </div>
        <hr>  
        <div class="mb-4 total-price">
          <h5>Total Cost</h5>
          <h5>₱457.98</h5>
        </div>
        <button class="btn btn-primary">CHECKOUT</button>
      </div>
    </article>
  </main>

  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script>
    $(window).scroll(function() {
      if ($(this).scrollTop() > 0){  
        $('header').addClass("bordered");
      }
      else{
        $('header').removeClass("bordered");
      }
    });
  </script>
</body>
</html>

<?php
  // }else {
  //   header("location: index.php?warning=No Search Item");
  // }
?>