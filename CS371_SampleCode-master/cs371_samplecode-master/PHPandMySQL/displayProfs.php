<?php

// Demonstrates how to connect to a database and display all the rows of a table.
// This file contains all necessary code; however, a better design would be to
// place the database code in a separate file.

function connect()
{
    // Create an mysqli object connected to the database.
    $connection = new mysqli("cis.gvsu.edu", "kurmasz", "kurmasz1234");

    // Complain if the the connection fails.  (This would have to be more graceful
    // in a production environment)
    if (!$connection || $connection->connect_error) {
        die('Unable to connect to database [' . $connection->connect_error . ']');
    }
    if (!$connection->select_db("kurmasz")) {
        die ("Unable to select database:  [" . $connection->error . "]");
    }
    return $connection;
}

function makeTable($c) {
    $make_table = "CREATE TABLE profs (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, lname VARCHAR(20), fname VARCHAR(20), rank VARCHAR(20), school VARCHAR(20), likes INT)";
    $result = $c->query($make_table);
    if (!$result) {
        die ("Unable to create table: [" . $c->errno . "; ". $c->error . "]");
    }
    $cmd = "insert into profs (fname, lname, rank, school) values ( 'Scott', 'Grissom', 'Full', 'Ohio State')";
    $c->query($cmd);
    return $result;
}


// Return an array of objects representing the rows of the table.
function getAllProfs($c) {
    $sql = "select * from profs";
    $result = $c->query($sql);
    if (!$result) {

        // If the table doesn't exist, then create it
        if ($c->errno == 1146) {
            makeTable($c);
            return getAllProfs($c);
        } else {
            die ("Query was unsuccessful: [" . $c->errno . "; " . $c->error . "]");
        }
    }  
    return $result;    
}
?>

<html>
<head>
    <title>mysqli Demo</title>
    <style>
        code {
            white-space: nowrap;
        }

        .sample {
            background-color: lightgreen;
        }
        th {
            text-align: left;
        }
        th, td {
            padding-right: 18px;
        }
    </style>
</head>
<body>
<h1>GVSU CIS Professors</h1>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Rank</th>
        <th>School</th>
    </tr>

    <?php
    $c = connect();
    $result = getAllProfs($c);

    // iterate over each record in the result.
    // (Each record will be one row in the table, beginning with <tr> and ending with </tr>
    foreach ($result as $row) {
        echo "<tr>";
        $keys = array("fname", "lname", "rank", "school");

        // iterate over all the columns.  Each column is a <td> element.
        foreach ($keys as $key) {
            echo "<td>" . $row[$key] . "</td>";
        }
        echo "</tr>\n";
    }
    $c->close();
    ?>
</table>

<hr>

<h1><code>mysqli</code></h1>

<p><code>mysqli</code> is a set of PHP classes that provides access to a MySQL database.</p>
<ul>
    <li>The <a href="http://php.net/manual/en/class.mysqli.php"><code>mysqli</code></a> class represents a connection
        between PHP and a MySQL database.
        Creating a <code>mysqli</code> object makes the connection: <code class="sample">$connection = new
            mysqli("127.0.0.1", "uname", "passwd");</code>
    </li>
    <li>Call <a href="http://php.net/manual/en/mysqli.select-db.php"><code>mysqli::select_db</code></a> to select a
        database: <code class="sample">$connection->select_db("my_db_name");</code>
    </li>
    <li>Call <a href="http://php.net/manual/en/mysqli.query.php"><code>mysqli::query</code></a> to issue a query (or
        other command) to mysql.
    </li>
    <li>A successful SELECT, SHOW, DESCRIBE, or EXPLAIN query will return a <a
            href="http://php.net/manual/en/class.mysqli-result.php"><code>mysqli_result</code></a> object.
    </li>
    <li>A successful INSERT query will simply return <code>true</code>.</li>
    <li>An unsuccessful query will return <code>false</code>.</li>
    <li>A <code>mysqli_result</code> object contains the rows returned. There are several ways to access the rows.
        Perhaps the easiest is with a <code>foreach</code> loop: <code class="sample">foreach ($result as $row)</code>.
        In this case,
        <code>row</code> is simply an array of strings corresponding to each column requested.
    </li>
    <li>To create a table, just build a string containing a "create table" sql statement, then call the
        <code>query</code> method.
    </li>
    <li>Similarly, to insert an item into a table, build a string containing an "insert into" query, then call the
        <code>query</code> method.<br> <code class="sample"> $cmd = "insert into profs (fname, lname, rank, school)
            values ( 'Scott', 'Grissom', 'Full', 'Ohio State')";<br/> $result = $connection->query($cmd); </code></li>
</ul>

</body>
</html>

