<?php
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);
?>

<?php session_start(); ?>

<?php

/* Respond to the form submission from forms.php
   (1) Unset all session variables.
   (2) Destroy current session.
*/
require('dbHelper.php');

if (isset($_SESSION['login'])){
  // remove all session variables
  session_unset(); 

  // destroy the session 
  session_destroy(); 

  // redirect to the login page;
  header('Location: loginPage.php');
}else{

  $c = connect();
  $postArray = array($_POST["username"],$_POST["password"]);
  updateAccounts($c, $postArray);

  // set the login session variable
  $_SESSION["login"] = $_POST['username'];

  // redirect to the index page
  header('Location: index.php');
}