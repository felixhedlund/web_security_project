<?php
    require("config.php");
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">

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
    <div class="container">
        <h1>All products in the database:</h1>
        <?php
            $result = $db->getProducts();
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
                print "<h3>Pris: {$row['price']}kr</h3>";
                print "</div>";
                print "<div class='product-buy'>";
                print "<button type='button' class='btn btn-success'>Add to cart</button>";
                print "</div>";
                print "</div>"; // End of thumbnail
                print "</div>"; // End of column
                if ($index++ == 3) {
                    print "</div>"; // End of row
                    break;
                }
            }
        ?>
    </div>
</body>
</html>