<?php 
    require_once('database.inc.php');
    // These variables define the connection information for your MySQL database 
    $username = "admin"; 
    $password = "admin123"; 
    $host = "localhost"; 
    $dbname = "web_security_database";

    
    $db = new Database($host, $username, $password, $dbname);
    $db->openConnection();
    if (!$db->isConnected()) {
        header("Location: cannotConnect.html");
        exit();
    }
    $db->closeConnection();
    
    session_start();
    $_SESSION['db_username'] = $username;
    $_SESSION['db_password'] = $password;
    $_SESSION['db_host'] = $host;
    $_SESSION['db_dbname'] = $dbname;
?>