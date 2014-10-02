<?php
	require("config.php");
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    if(!empty($_POST)){

        if($db->loginCustomerUnsafe($_POST['username'], $_POST['password'])){
            $logged_in = true;
        }else{
            $logged_in = false;
        }

    }
    header("Location: ".$_SESSION['current_page']);
    die();
?>