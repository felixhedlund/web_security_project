<?php 
	require("config.php");
    unset($_SESSION['customer']);
    unset($_POST);
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>