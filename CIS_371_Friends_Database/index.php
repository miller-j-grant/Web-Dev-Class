<!DOCTYPE html>
<?php require('dbHelper.php'); ?>
<html lang="en">
<head>
    <title>In-Class-7</title>
</head>
<body>

<h1>Friends Database</h1>

<form action="dbUpdate.php" method="post">

    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Age</th>
        </tr>

        <?php
        $c = connect();
        foreach (getAllFriends($c) as $row) {
            echo "<tr>";
//        $id = $row['id'];
//        echo "<td><input type='checkbox' name='ilike[]' value='$id'/>";

            $keys = array("fname", "lname", "phone", "age");
            foreach ($keys as $key) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>\n";
        }
        $c->close();
        ?>
    </table>

    <label for="firstname">First name:</label><br>
    <input type="text" name="firstname" id="firstname">
    <br>
    <label for="lastname">Last name:</label><br>
    <input type="text" name="lastname" id="lastname">
    <br>
    <label for="phonenumber">Phone number:</label><br>
    <input type="text" name="phonenumber" id="phonenumber">
    <br>
    <label for="age">Age:</label><br>
    <input type="text" name="age" id="age">
    <br><br>
    <input type="submit" value="Submit">

</form>


</body>
</html>