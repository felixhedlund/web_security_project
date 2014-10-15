<?php
    require("config.php");
    if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on")
    {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
    }
    $_SESSION['current_page'] = "index.php";
    $submitted_username = '';
    $logged_in = false;
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    if(!empty($_SESSION['customer'])){
        $logged_in = true;
    }
    $result = $db->getProducts();
    if(empty($_SESSION['cart'])){
        $_SESSION['cart'] = array();
        foreach ($result as $row){
            $_SESSION['cart'][$row['id']] = 0;
        }
    }

    $db->closeConnection();
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
        <li class="divider-vertical"></li>
        <?php  if(!$logged_in){  ?>
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                <?php if(!empty($_SESSION['login_denied']) && $_SESSION['login_denied'] == true){
                    ?>
                    Access denied for 30 min
                <?php
                } ?>
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
        <h1>Shopping cart
        <?php

            $index = 1;
            $show_checkout = false;
            foreach ($result as $row){
                if($_SESSION['cart'][$row['id']] > 0){ $show_checkout = true; }

            }
            if($show_checkout){?>

                <a class="btn btn-info" href="checkout.php">Proceed to checkout</a><?php } ?>
                </h1><?php if(!$logged_in && $show_checkout){
                    print "<p>You must login to proceed to checkout!";
                } ?> <?php

            foreach ($result as $row){


                if ($index == 1) {
                    print "<div class='row'>";
                }

                print "<div class='col-md-6'>";
                print "<div class='product-thumbnail'>";
                print "<img src='{$row['image']}' class='img-responsive img-thumbnail' alt='Responsive image'>";
                print "<div class='product-caption'>";
                print "<h2>{$row['name']}</h2>";
                if($_SESSION['cart'][$row['id']] > 0){
                print "<h3>Amount in cart: {$_SESSION['cart'][$row['id']]}</h3>";

                    print "<div class='product-sell'>";
                    print "<form action='removeProductFromCart.php' method='post'> ";
                    print "<input type='hidden' name='product_id' value='{$row['id']}' />";
                    print "<input type='submit' class='btn btn-danger' value='Remove from cart'/>";
                    print "</form>";
                    print "</div>";
                }
                print "</div>";

                print "<div class='product-price'>";
                print "<h3>Price: {$row['price']} SEK</h3>";
                print "</div>";


                print "<div class='product-buy'>";

                print "<form action='addProductToCart.php' method='post'> ";
                print "<input type='hidden' name='product_id' value='{$row['id']}' />";
                print "<input type='submit' class='btn btn-success' value='Add to cart'/>";
                //print "<button type='button' class='btn btn-success'>Add to cart</button>";
                print "</form>";



                print "</div>";

                print "</div>"; // End of thumbnail

                // Print 'review' button
                print "<form action='product.php' method='post'> ";
                print "<input type='hidden' name='product_id' value='{$row['id']}'/>";
                print "<input type='submit' class='btn btn-warning' value='Reviews'/>";
                print "</form>";

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