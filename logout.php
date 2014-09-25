<?php 
	require("config.php");
    unset($_SESSION['customer']);
    header("Location: ".$_SESSION['current_page']); 
    session_unset();
    die("Redirecting to: index.php");
?>