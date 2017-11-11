<?php

// Connect to the database
function connect()
{
    // Create an mysqli object connected to the database.
    $connection = new mysqli("localhost", "root", "crispy523094", "friends");

    // Complain if the the connection fails.  (This needs to be more graceful
    // in a production environment.)
    if (!$connection || $connection->connect_error) {
        die('Unable to connect to database [' . $connection->connect_error . ']');
    }
    if (!$connection->select_db("friends")) {
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
    $impArray = implode(',', $postArray);
    $q1 = "SELECT * FROM info WHERE fname AND lname IN ($impArray)";
    $result = mysqli_query($c, $q1);
    if (mysqli_num_rows($result)>0) {
        $qUpdate = "UPDATE info 
                    SET phone=".$postArray[2].", age=".$postArray[3]." 
                    WHERE fname=".$postArray[0]." AND lname=".$postArray[1];
        if (!mysqli_query($c, $qUpdate)) {
            die ("problem with update: " . $c->error);
        }
    }else{
        $qInsert = "INSERT INTO info 
                    (fname, lname, phone, age)
                    VALUES 
                    (".$postArray[0].", ".$postArray[1].", ".$postArray[2].", ".$postArray[3].")";
        if (!mysqli_query($c, $qInsert)) {
            die ("problem with insert: " . $c->error);
        }
    }
}
?>
