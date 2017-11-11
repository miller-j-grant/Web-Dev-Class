<?php

/* Respond to the form submission from forms.php
   (1) Connect to the database and perform the update
   (2) Redirect back to forms.php
*/

require('dbHelper.php');

if (array_key_exists('firstname', $_POST) &&
    array_key_exists('lastname', $_POST) &&
    array_key_exists('phonenumber', $_POST) &&
    array_key_exists('age', $_POST)) {
    $c = connect();
    $postArray = array($_POST['firstname'],$_POST['lastname'],$_POST['phonenumber'],$_POST['age']);
    updateFriends_efficient($c, $postArray);
}


# redirect back to the original page;
header("Location: forms.php");
