<?php 
    require("config.php");
    if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on")
    {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
    }
    $submitted_username = ''; 
    $logged_in = false;
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    $result = $db->getProducts();
    $cart_filled = false;
    foreach ($result as $row){
        if($_SESSION['cart'][$row['id']] > 0){ 
            $cart_filled = true; 
        }         
    }
    if(!empty($_SESSION['customer']) && $cart_filled){
        $logged_in = true;
    }else{
        header("Location: index.php"); 
        die("Redirecting to: index.php");
    }
?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Web shop</title>
    <meta name="description" content="A web shop for the course Web security [EITF05]">
    <meta name="author" content="Group 13">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
        .product-sell {
            position: absolute;
            width: 100%;
            text-align: right;
            margin-top: -40px;
            padding-right: 30px;
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
      <a class="navbar-brand" href="index.php">Web shop</a>
    </div>

      <ul class="nav navbar-nav navbar-right">
        <?php if($logged_in){
            ?>
        <li><?php print("<a>".$_SESSION['customer']."</a>"); ?></li>
        <?php }else{ ?>


        <li><a href="register.php">Register</a></li>
        <?php } ?>
        <?php  if($logged_in){  ?>
            <li><a href="logout.php">Log Out</a></li>
            <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
        <h1>Receipt</h1>
        <h2>You have bought: </h2>
        <?php $total_price = 0; 
        foreach($result as $row){
            print $db->getNameOfProduct($row['id']);
            print " ";
            print "Amount: ";
            print $_SESSION['cart'][$row['id']];
            $price = $db->getPriceOfProduct($row['id'])*$_SESSION['cart'][$row['id']];
            $total_price += $price;
            print " = ".$price." SEK";
            print "<p>";

        } 
        print "Total price: ".$total_price." SEK"?>
        
    </div>


<?php $db->closeConnection(); ?>
</body>
</html>