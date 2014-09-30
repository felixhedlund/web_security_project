<?php
  require("config.php");
  if(!empty($_POST)) {
    $db = new Database($_SESSION['db_host'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_dbname']);
    $db->openConnection();
    $db->addReview($_POST['message'], $_SESSION['customer'], $_POST['product_id']);
    $db->closeConnection();
  }
  header("Location: ".$_SESSION['current_page']);
  die("Redirecting to: ".$_SESSION['current_page']);
?>