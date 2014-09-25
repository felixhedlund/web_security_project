<?php 
    require("config.php");
    $_SESSION['current_page'] = "index.php";
    $submitted_username = ''; 
    $logged_in = false;
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    
    if(!empty($_SESSION['customer'])){
        $logged_in = true;
    }
    $result = $db->getProducts();
    $db->closeConnection();
?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Web shop</title>
    <meta name="description" content="A web shop for the course Web security [EITF05]">
    <meta name="author" content="Group 13">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style type="text/css">
        body { background: url(assets/images/background.png); }
        .hero-unit { background-color: #fff; }
        .center { display: block; margin: 0 auto; }
    </style>
    <style type="text/css">
        h3 { margin-top: 10px; }
        .product-thumbnail { position: relative; width: 410px; }
        .product-caption {
            background: none repeat scroll 0 0 #FFFFFF;
            opacity: 0.7;
            top: 0;
            left: 0;
            width: 100%;
            position: absolute;
            padding-left: 20px;
            padding-bottom: 5px;
        }
        .product-price {
            background: none repeat scroll 0 0 #FFFFFF;
            opacity: 0.7;
            width: 100%;
            position: absolute;
            margin-top: -50px;
            padding-left: 20px;
        }
        .product-buy {
            position: absolute;
            width: 100%;
            text-align: right;
            margin-top: -44px;
            padding-right: 10px;
        }
    </style>
</head>

<body>


<nav class="navbar navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Web shop</a>
    </div>

      <ul class="nav navbar-nav navbar-right">
        <li><button onclick="location.href = 'shoppingcart.php';" type="button" class="btn btn-default btn-lg">
  <span class="glyphicon glyphicon-shopping-cart"></span>
</button></li>
        <li><a href="register.php">Register</a></li>
        <li class="divider-vertical"></li>
        <?php  if(!$logged_in){  ?>
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                <form action="login.php" method="post"> 
                    Username:<br /> 
                    <input type="text" name="username" value="<?php echo $submitted_username; ?>" /> 
                    <br /><br /> 
                    Password:<br /> 
                    <input type="password" name="password" value="" /> 
                    <br /><br /> 
                    <input type="submit" class="btn btn-info" value="Login" /> 
                </form> 
            </div>
          </li>
          <?php }else{ ?>
            
            <li><a href="logout.php">Log Out</a></li>
            <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
        <h1>All cats for sale:</h1>
        <?php
            
            $index = 1;
            foreach ($result as $row){
                if ($index == 1) {
                    print "<div class='row'>";
                }
                print "<div class='col-md-6'>";
                print "<div class='product-thumbnail'>";
                print "<img src='{$row['image']}' class='img-responsive img-thumbnail' alt='Responsive image'>";
                print "<div class='product-caption'>";
                print "<h2>{$row['name']}</h2>";
                print "</div>";
                print "<div class='product-price'>";
                print "<h3>Price: {$row['price']} SEK</h3>";
                print "</div>";
                print "<div class='product-buy'>";
                print "<button type='button' class='btn btn-success'>Add to cart</button>";
                print "</div>";
                print "</div>"; // End of thumbnail
                print "</div>"; // End of column
                if ($index++ == 3) {
                    print "</div>"; // End of row
                    $index = 1;
                }
            }
        ?>
    </div>

</body>
</html>