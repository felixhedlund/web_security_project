<?php 
    require("config.php");
    $submitted_username = ''; 
    $logged_in = false;
    if(!empty($_POST)){ 
        $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
        $db->openConnection();
        if($db->loginCustomer($_POST['username'], $_POST['password'])){
            $logged_in = true;
        }else{
            $logged_in = false;
        }
        $db->closeConnection();
    } 
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
        <li><button type="button" class="btn btn-default btn-lg">
  <span class="glyphicon glyphicon-shopping-cart"></span>
</button></li>
        <li><a href="register.php">Register</a></li>
        <li class="divider-vertical"></li>
        <?php  if(!$logged_in){  ?>
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                <form action="index.php" method="post"> 
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

<div class="container" >
    
        <div class "row">
            <div class="col-md-6">
                <img src="assets/images/cat01.jpg" class="img-responsive img-thumbnail" alt="Responsive image">
            <div class="col-md-6">
                <label> Cat nr 1</label> 
                <button type="button" class="btn btn-success">Add to cart</button>
            </div>
        </div>
    
        <div class "row" >
            <div class="col-md-6">
                <img src="assets/images/cat02.jpg" class="img-responsive img-thumbnail" alt="Responsive image">
            </div>
            <div class="col-md-6">
                    <label> Cat nr 2</label> 
                    <button type="button" class="btn btn-success">Add to cart</button>
                </div>
        </div>

</div>

</body>
</html>