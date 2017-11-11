<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assignment 10 Login</title>
</head>
<body>

<h1>Friends Database Login</h1>

<form action="loginLogout.php" method="post">

  <label for="username">Username:</label><br>
  <input type="text" name="username" id="username">
  <br>
  <label for="password">Password:</label><br>
  <input type="text" name="password" id="password">
  <br><br>
  <input type="submit" value="Submit">

</form>

</body>
</html>