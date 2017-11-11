<?php
    // Start the session
    session_start();

    if(!isset($_SESSION['login'])){ //if login session variable is not set
        header("Location: loginPage.php");
    }
?>

<!DOCTYPE html>
<?php require('dbHelper.php'); ?>
<html lang="en">
<head>
    <title>Assignment 10</title>
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
            <th>Username</th>
        </tr>

        <?php
        $c = connect();
        foreach (getAllFriends($c) as $row) {
            echo "<tr>";

            $keys = array("fname", "lname", "phone", "age", "username");
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
    <br><br>

</form>

<form action="loginLogout.php" method="post">

    <input type="submit" value="Logout">

</form>

</body>
</html>