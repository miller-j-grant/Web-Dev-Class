<?php

// Connect to the database
function connect()
{
    // Create an mysqli object connected to the database.
    $connection = new mysqli("cis.gvsu.edu", "millgran", "millgran");

    // Complain if the the connection fails.  (This needs to be more graceful
    // in a production environment.)
    if (!$connection || $connection->connect_error) {
        die('Unable to connect to database [' . $connection->connect_error . ']');
    }
    if (!$connection->select_db("millgran")) {
        die ("Unable to select database:  [" . $connection->error . "]");
    }
    return $connection;
}

// retrieve all rows
function getAllFriends($c)
{
    $sql = "SELECT * FROM info";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

// This "efficient" version only makes two mySQL requests.
function updateFriends_efficient($c, $postArray)
{
    // Fetch the records for all friends to be updated.
    //$impArray = implode(',', $postArray);
    $q1 = "SELECT * FROM info WHERE fname AND lname IN ($postArray)";
    $result = mysqli_query($c, $q1);
    $qUpdate = "INSERT INTO info
  		(fname, lname, phone, age)
		VALUES
  		('".$postArray[0]."', '".$postArray[1]."', '".$postArray[2]."', ".$postArray[3].")
		ON DUPLICATE KEY UPDATE 
		phone = '".$postArray[2]."', 
		age = ".$postArray[3]."";
    if (!mysqli_query($c, $qUpdate)) {
            die ("problem with update: " . $c->error);
        }
}
?>
