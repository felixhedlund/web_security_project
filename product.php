<?php
    require("config.php");
    $_SESSION['current_page'] = "product.php";
    $submitted_username = '';
    $logged_in = false;
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    if(!empty($_SESSION['customer'])){
        $logged_in = true;
    }

    if (!empty($_SESSION['product_id'])) {
        $product = $db->getProductWithId($_SESSION['product_id']);
        $reviews = $db->getProductReviews($_SESSION['product_id']);
    } else {
        $product = $db->getProductWithId($_POST['product_id']);
        $reviews = $db->getProductReviews($_POST['product_id']);
    }

    $_SESSION['product_id'] = $_POST['product_id']; // Store product id in session

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
        body {
            background: url(assets/images/background.png);
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
    <div class="row">
        <div class="col-md-6">
            <?php print "<img src='{$product[0]['image']}' class='img-responsive img-thumbnail' alt='Responsive image'>"; ?>
        </div>
        <div class="col-md-6">
            <?php
                print "<h2>{$product[0]['name']}</h2>";
                print "<h3>This is a very nice cat... Buy it.</h3>";
                print "<a class='btn btn-primary' href='index.php'>Back to homepage</a>";
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php
                foreach ($reviews as $review) {
                    print "<div class='panel panel-default'>";
                    print "<div class='panel-heading'>";
                    print "<h3 class='panel-title'>{$review['username']}</h3>";
                    print "</div>";
                    print "<div class='panel-body'>";
                    // print htmlspecialchars($review['message'], ENT_QUOTES, 'UTF-8');
                    print $review['message'];
                    print "</div></div>";
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php
                if($logged_in) {
                    print "<form action='addReview.php' method='post'>";
                    print "<input type='hidden' name='product_id' value='{$_POST['product_id']}' />";
                    print "<textarea class='form-control' name='message' rows='6'></textarea>";
                    print "<input type='submit' class='btn btn-info' value='Submit' />";
                    print "</form>";
                }
            ?>
        </div>
    </div>
</div>

</body>
</html>