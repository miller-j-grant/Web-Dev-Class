<?php

// Connect to the database
function connect()
{
    // Create an mysqli object connected to the database.
    $connection = new mysqli("cis.gvsu.edu", "kurmasz", "kurmasz1234");

    // Complain if the the connection fails.  (This needs to be more graceful
    // in a production environment.)
    if (!$connection || $connection->connect_error) {
        die('Unable to connect to database [' . $connection->connect_error . ']');
    }
    if (!$connection->select_db("kurmasz")) {
        die ("Unable to select database:  [" . $connection->error . "]");
    }
    return $connection;
}

// retrieve all rows
function getAllProfs($c)
{
    $sql = "select * from profs";
    $result = $c->query($sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}


// This "simple" version iterates over all the "liked" professors
// and updates them one at a time.
function updateLikes_simple($c, $profs_liked)
{
    // Iterate over all the selected professors
    foreach ($profs_liked as $id) {

        // Fetch the record for that professor
        $q1 = "select likes from profs where (id='$id')";
        $result = $c->query($q1);
        if (!$result) {
            die ("Problem getting prof: " . $c->error);
        }

        // Compute the new "like" count.
        $newValue = intval($result->fetch_row()[0]) + 1;

        // Update that prof's record.
        // Begin by building a string containing an sql query.
        $q2 = "update profs set likes=$newValue where id=$id";
        // Now, issue that query.
        if (!$c->query($q2)) {
            die ("problem with update: " + $c->error);
        }
    }
}

// This "efficient" version only makes two mySQL requests.
function updateLikes_efficient($c, $profs_liked)
{
    // Fetch the records for all profs to be updated.
    $ids = implode(',', $profs_liked);
    $q1 = "select id, likes from profs where id in ($ids)";
    $result = $c->query($q1);
    if (!$result) {
        die ("Problem getting prof: " . $c->error);
    }

    // Build a single update query to update the chosen profs.
    // The query looks something like this:
    // update profs set likes = case when id=1 then 3 when id=9 then 4 end where id in (1,9)
    $q2 = "update profs set likes = case ";
    foreach ($result as $row) {
        $id = $row['id'];
        $newValue = intval($row['likes']) + 1;
        $q2 .= "when id=$id then $newValue ";
    }
    $q2 .= " end where id in ($ids)";
    if (!$c->query($q2)) {
        die ("problem with update: " . $c->error);
    }
}
?>
