<?php 
	require("config.php");
    unset($_SESSION['customer']);
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>