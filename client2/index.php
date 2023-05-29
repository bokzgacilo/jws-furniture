<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JWS Furniture</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.web.css">
  <link rel="icon" type="image/x-icon" href="../assets/logo.png">
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="../assets/sweetalert2@11.js"></script>
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
     
      <a href="api/logout.php">Logout</a>
    </div>
  </div>

  <main>
    <header>
      <div class="brand">
        <img src="../assets/logo.png" />
        <h5>JWS FURNITURES</h5> 
      </div>
      <form id="searchForm" method="get" action="shop.php">
        <input type="text" name="q" placeholder="Search in JWS Furniture" >
        <button>
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
      <div class="action">
      <style>
    </style>
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
      <section class="carousel-section">
        <div id="bannerCarousel" class="carousel slide">
          <div class="carousel-inner">
            <?php
              for ($i = 1; $i <= 3; $i++) { 
                if($i == 1){
                  echo "
                  <div class='active carousel-item'>
                    <img src='../uploads/banner/banner ($i).jpg' class='active d-block'>
                  </div>
                ";
                }else {
                  echo "
                  <div class='carousel-item'>
                    <img src='../uploads/banner/banner ($i).jpg' class='d-block'>
                  </div>
                ";
                }
              }
            ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </section>
      <section class="offer-section">
        <div>
          <div 
            class="mt-4 mb-2"
            style="
              display: flex;
              flex-direction: row; 
              justify-content: space-between; 
              align-items: center;"
          >
            <h2 style="color: #fff;">New Arrival</h2>
            <a href="#">See More</a>
          </div>
          <div class="card-container">
            <div class="card">
              <img src="../uploads/offer/offer (1).jpg" class="card-img-top">
              <div class="card-body">
                <p class="card-text">A Beautiful dining set made out of mahogany wood</p>
                <button style="margin-top: auto;" class="btn btn-primary w-100">View Product</button>
              </div>
            </div>
            <div class="card">
              <img src="../uploads/offer/offer (2).jpg" class="card-img-top">
              <div class="card-body">
                <p class="card-text">Gray sofa good for barkada</p>
                <button style="margin-top: auto;" class="btn btn-primary w-100">View Product</button>
              </div>
            </div>
            <div class="card">
              <img src="../uploads/offer/offer (3).jpg" class="card-img-top">
              <div class="card-body">
                <p class="card-text">The white comfortable single seat sofa</p>
                <button style="margin-top: auto;" class="btn btn-primary w-100">View Product</button>
              </div>
            </div>
            <div class="card">
              <img src="../uploads/offer/offer (4).jpg" class="card-img-top">
              <div class="card-body">
                <p class="card-text">I don't know what this is, but you need to check this out</p>
                <button style="margin-top: auto;" class="btn btn-primary w-100">View Product</button>
              </div>
            </div>
          </div>
        </div>
      </section>
      
    </article>
  </main>
  
  <script src="../assets/popper.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script>
    <?php
      if(isset($_GET['message'])){
        echo "
          Swal.fire({
            title: 'Successfully Logged In',
            text: 'Welcome back my friend',
            icon: 'success',
            confirmButtonText: 'Got It'
          })

          window.history.pushState({}, document.title, '/jws-furniture/client2/' + 'index.php');
        ";
      }
    ?>

    $(document).ready(function(){

    })

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