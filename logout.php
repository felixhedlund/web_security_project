<?php 
	require("config.php");
    unset($_SESSION['customer']);
    header("Location: ".$_SESSION['current_page']); 
    die("Redirecting to: index.php");
?>