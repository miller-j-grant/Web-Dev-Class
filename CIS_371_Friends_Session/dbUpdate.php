<?php
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);
?>

<?php session_start(); ?>

<?php

/* Respond to the form submission from index.php and loginPage.php
   (1) Connect to the database and perform the update
   (2) Redirect back to index.php
*/

require('dbHelper.php');

if (array_key_exists('firstname', $_POST) &&
    array_key_exists('lastname', $_POST)) {
    $c = connect();

    $sql = "SELECT superuser FROM accounts WHERE username='".$_SESSION['login']."'";
    $result = mysqli_query($c, $sql);
    $row=mysqli_fetch_assoc($result);
    // $value = $result['superuser'];
    if($row["superuser"]==1){
        $postArray = array($_POST['firstname'],$_POST['lastname'],$_POST['phonenumber'],$_POST['age']);
        updateFriends_efficient($c, $postArray);
    }
}

// redirect back to the original page;
    header('Location: index.php');

// INSERT INTO accounts (username, password, superuser) VALUES ('millgran', 'superuser', 1);
// INSERT INTO accounts (username, password, superuser) VALUES ('second', 'superuser2', 1);
// INSERT INTO accounts (username, password, superuser) VALUES ('notsuper', 'normal', 0);
// INSERT INTO info (fname, lname, phone, age, username) VALUES ('HELLO', 'THERE', '111-111-1111', 0, NULL);
// INSERT INTO info (fname, lname, phone, age, username) VALUES ('NOT', 'SUPERUSER', '111-111-1111', 0, NULL);
//.strcmp("1")