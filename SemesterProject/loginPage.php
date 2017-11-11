<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Semester Project Login</title>
</head>
<body>

<h1>Friends Database Login</h1>

<form name="loginForm" action="loginLogout.php" onsubmit="return validateForm()" method="post">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username">
    <br>
    <label for="password">Password:</label><br>
    <input type="text" name="password" id="password">
    <br><br>
    <input type="submit" value="Submit">
</form>

<script type="text/javascript">
        function validateForm() {
            var name = document.forms["loginForm"]["username"].value;
            var pass = document.forms["loginForm"]["password"].value;
            
            var message = "Success";
            var newItem = document.createElement("div");
            newItem.innerHTML = message;
            newItem.style.display = "inline-block";
            newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
            newItem.style.padding = "15px";

            if (name === "" || pass === "") {
            message = "Please enter your username and password.";
            newItem.innerHTML = message;
            newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
            document.getElementsByTagName("body")[0].appendChild(newItem);
            return false;
        }
            
            document.getElementsByTagName("body")[0].appendChild(newItem);
        }
    </script>

</body>
</html>