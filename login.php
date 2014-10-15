<?php
	require("config.php");
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    if(!empty($_POST)){

    if(!$db->confirmIPAddress($_SERVER['REMOTE_ADDR'])){
        if($db->loginCustomerUnsafe($_POST['username'], $_POST['password'])){
                $logged_in = true;
                $_SESSION['login_denied'] = false;
                $db->clearLoginAttempts($_SERVER['REMOTE_ADDR']);
        }else{
            $logged_in = false;
            $db->addLoginAttempt($_SERVER['REMOTE_ADDR']);
        }
    
    }else{
            $logged_in = false;
            $db->addLoginAttempt($_SERVER['REMOTE_ADDR']);
            $_SESSION['login_denied'] = true;
        }

    }
    header("Location: ".$_SESSION['current_page']);
    die();
?>