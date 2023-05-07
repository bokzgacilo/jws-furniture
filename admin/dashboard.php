<?php
  session_start();

  if(isset($_SESSION['logged'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../client/assets/logo.png" type="image/x-icon">
  <title>JWS Furniture - Admin</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.web.css">
  <script src="js/jquery-3.6.4.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
  <aside>
    <h4>Dashboard</h4>
    <a name="products">
      <i class="fa-solid fa-list"></i>
      <p>Products</p>
    </a>
    <a name="inventory">
      <i class="fa-solid fa-warehouse"></i>
      <p>Inventory</p>
    </a>
    <a name="transaction">
      <i class="fa-solid fa-money-bill"></i>
      <p>Transaction</p>
    </a>
    <a name="sales">
      <i class="fa-solid fa-chart-line"></i>
      <p>Sales</p>
    </a>
    <a href="api/logout.php">
      <p>Logout</p>
    </a>
  </aside>

  <main id="root">
    <h2>Main</h2>
  </main>
  <script src="../client/assets/bootstrap/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function(){
      if(location.hash){
        var sitehash = location.hash.split("#");
        console.log(location)
        $(`[name='${sitehash[1]}']`).addClass('active')

        $('#root').load(`views/${sitehash[1]}.html`);

      }else {
        $("[name='products']").addClass('active')
        $('#root').load(`views/products.html`);
      }
      
      $('a').on("click", function(){
        $('a').removeClass('active');

        let view_name = $(this).attr('name');
        location.hash = view_name;
        $(`[name='${view_name}']`).addClass('active')
        $('#root').load(`views/${view_name}.html`);
      })
    })
  </script>
</body>
</html>

<?php
  }else {
    header('location: index.php');
  }
?>