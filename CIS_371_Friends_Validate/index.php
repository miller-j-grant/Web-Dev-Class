<?php
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);
?>

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
    <title>Assignment 13</title>
</head>
<body>

<h1>Friends Database</h1>

<form name="dbForm" action="dbUpdate.php" onsubmit="return validateForm()" method="post">

    <table id="friends">
        <tr>
            <th><button onclick="sortFunction(0)">First Name</button></th>
            <th><button onclick="sortFunction(1)">Last Name</button></th>
            <th><button onclick="sortFunction(2)">Phone Number</button></th>
            <th><button onclick="sortFunction(3)">Age</button></th>
            <th><button onclick="sortFunction(4)">Username</button></th>
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

<script type="text/javascript">
        function validateForm() {
            var fname = document.forms["dbForm"]["firstname"].value;
            var lname = document.forms["dbForm"]["lastname"].value;
            var phone = document.forms["dbForm"]["phonenumber"].value;
            var age = document.forms["dbForm"]["age"].value;

            var message = "Success";
            var newItem = document.createElement("div");
            newItem.innerHTML = message;
            newItem.style.display = "inline-block";
            newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
            newItem.style.padding = "15px";
            
            if (fname === "" || lname === "") {
                message = "Both the first name and last name is required for database entry.";
                newItem.innerHTML = message;
                newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
                document.getElementsByTagName("body")[0].appendChild(newItem);
                return false;
            }
            if(phone.length < 10 || phone.length > 13){
                message = "Keep the phone number to 10 digits please.";
                newItem.innerHTML = message;
                newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
                document.getElementsByTagName("body")[0].appendChild(newItem);
                return false;
            }
            if(age<1 || age>120){
                message = "You must enter an age between 1 and 120 years.";
                newItem.innerHTML = message;
                newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
                document.getElementsByTagName("body")[0].appendChild(newItem);
                return false;
            }

            document.getElementsByTagName("body")[0].appendChild(newItem);
        }

        function sortFunction(column){
            var rows = document.getElementById("friends").getElementsByTagName("tr");
            var sortValues = [];

            for(var i = 1; i < rows.length; i++){
                var cells = rows[i].getElementsByTagName("td");
                sortValues[i] = cells[column].innerText;
            }

            var bool = true;
            var tempStr;
            var tempRow;

            while(bool){
                bool = false;
                for(var i = 1; i < sortValues.length-1; i++){
                    if(sortValues[i] > sortValues[i+1]){
                        tempStr = sortValues[i];
                        sortValues[i] = sortValues[i+1];
                        sortValues[i+1] = tempStr;

                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        bool = true;
                    }
                }
            }

            console.log(column);
            console.log(rows);
            console.log(sortValues);
        }
    </script>

</body>
</html>