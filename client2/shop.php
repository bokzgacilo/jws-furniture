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
        <div onclick='quickView(this.id)' class='product card' id='".$row['id']."'>
          <p class='has-text-right has-text-weight-bold is-size-7'>".$row['stock']."  in stock</p>
          <img src='".$row['product_photo']."' alt='".$row['name']."' />
          <p class='is-size-6 has-text-weight-semibold'>".$row['name']."</p>
          <div class='is-size-5 has-text-weight-semibold'>₱ ".number_format($row['price'], 2, '.', ',')." <span class='is-size-7'>".$row['sold']." sold </span></div>
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
  <title>Shop - JWS Furnitures</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.web.css">
  <link rel="stylesheet" href="css/shop.web.css">
  <link rel="icon" type="image/x-icon" href="../assets/logo.png">
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="js/form.js"></script>
  <script src="../assets/sweetalert2@11.js"></script>
</head>
<body>
  <main>
    <header id="header-container">

    </header>
    <article>
      <div class="product-container">
        <style>
          
        </style>
        <div class="category-list">
        </div>
        <div id="product-list">
          <?php echo $products; ?>
        </div>
        </div>
      </div>
    </article>
  </main>

  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/shop.js"></script>
  <script src="loader.js"></script>
</body>
</html>

<?php

?>