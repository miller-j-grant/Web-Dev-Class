<!-- This file demonstrates
   (1) how to separate the database code from the page view.
   (2) how to update the database.
   -->
<?php require('dbHelper.php'); ?>
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

<P>(Notice that this page uses a "helper" php script called <code>dbHelper</code> to avoid re-writing the same code in
    multiple files.)</P>

<form action="profsSubmit.php" method="post">
    <table>
        <tr>
            <th colspan="2">Likes</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Rank</th>
            <th>School</th>
        </tr>

        <?php
        $c = connect();
        foreach (getAllProfs($c) as $row) {
            echo "<tr>";
            $id = $row['id'];
            echo "<td><input type='checkbox' name='ilike[]' value='$id'/>";

            $keys = array("likes", "fname", "lname", "rank", "school");
            foreach ($keys as $key) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>\n";
        }
        $c->close();
        ?>
    </table>
    <input type="submit" value="submit"/>
</form>
<hr>

</body>
</html>

