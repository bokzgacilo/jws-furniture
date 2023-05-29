<?php
  session_start();
  include('api/connection.php');

  $sql = "";
  $products = "";


  if(isset($_GET['q']) && isset($_GET['category'])){
    $sql = $conn -> query("SELECT * FROM product WHERE name LIKE '%".$_GET['q']."%' AND category='".$_GET['category']."'");
  }else if(isset($_GET['category'])){
    $sql = $conn -> query("SELECT * FROM product WHERE category='".$_GET['category']."'");
  }else if(isset($_GET['q'])){
    $sql = $conn -> query("SELECT * FROM product WHERE name LIKE '%".$_GET['q']."%'");
  }else {
    $sql = $conn -> query("SELECT * FROM product");
  }


  if($sql -> num_rows != 0){
    while($row = $sql -> fetch_array()){
      $products .= "
        <div onclick='quickView(this.id)' class='product' id='".$row['id']."'>
          <img src='".$row['product_photo']."' alt='".$row['name']."' />
          <p>".$row['name']."</p>
          <p>".$row['price']."</p>
        </div>
      ";
    }
  }else {
    $products =  "
      <p>No results found</p>
    ";
  }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JWS Catalog</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.web.css">
  <link rel="stylesheet" href="css/shop.web.css">
  <link rel="icon" type="image/x-icon" href="../assets/logo.png">
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="js/form.js"></script>
  <script src="../assets/sweetalert2@11.js"></script>
</head>
<body>
  <style>
    
  </style>
  <!-- Quick View Modal -->
  <div class="quickview">
    <div class="quickview-header">
      <h4>Quick View</h4>
      <button type="button" class="btn-close quickview-closer"></button>
    </div>
    <div class="quickview-body">
      
    </div>
  </div>

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
        <input type="text" id="searchInput" placeholder="Search in JWS Furniture" >
        <button type="submit">
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
      <div class="sidebar">
        <div class="d-flex justify-content-center">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="product-container">
        <div id="product-list">
            <?php echo $products; ?>
            <!-- <div class="d-flex justify-content-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div> -->
          </div>
        </div>
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
  <script src="js/shop.js"></script>
</body>
</html>

<?php

?>