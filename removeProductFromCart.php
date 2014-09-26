<?php 
	require("config.php");
    if(!empty($_POST)){  
        $_SESSION['cart'][$_POST['product_id']]--;
    } 
    header("Location: ".$_SESSION['current_page']); 
    die("Redirecting to: ".$_SESSION['current_page']);
?>