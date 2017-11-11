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
    <link rel="stylesheet" href="descPageCSS.css" type="text/css"/>
    <script type="text/javascript">
        function validateForm() {
            var details = document.forms["detailForm"]["detailBox"].value;

            var message = "Success";
            var newItem = document.createElement("div");
            newItem.innerHTML = message;
            newItem.style.display = "inline-block";
            newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
            newItem.style.padding = "15px";
            
            if (details === "") {
                message = "Please enter in all fields.";
                newItem.innerHTML = message;
                newItem.style.backgroundColor = message === "Success" ? "lightgreen" : "red";
                document.getElementsByTagName("body")[0].appendChild(newItem);
                return false;
            }

            document.getElementsByTagName("body")[0].appendChild(newItem);
        }
    </script>
    <title>Semester Project</title>
</head>
<body>

<?php
if(!isset($_SESSION['pc'])){ //if session variable is not set
    $_SESSION["pc"] = $_GET["pc"];
}

echo "<h1>PC Description: ".$_SESSION['pc']."</h1>";

$c = connect();
$detailString = "No details yet ...";
$imageString = "";
foreach (getDetailsFromTableWhereKeyEqualsValue($c, "pcs", "cName", $_SESSION['pc']) as $row) {
    $keys = array("details");
    foreach ($keys as $key) {
        if($key === "details"){
            $detailString = $row[$key];
        }
    }
}

foreach (getImageFromTableWhereKeyEqualsValue($c, "pcs", "cName", $_SESSION['pc']) as $row) {
    $keys = array("image");
    foreach ($keys as $key) {
        if($key === "image"){
            $imageString = $row[$key];
        }
    }
}

$c->close();

echo "<label for='detailBox'>Details:</label><br>";
echo "<textarea name='detailBox' id='detailBox' form='detailForm'>".$detailString."</textarea>";
?>

<br>

<form id="detailForm" action="dbUpdate.php" onsubmit="return validateForm()" method="post">
    <input type="hidden" name="detailHidden" value="pc">
    <input type="submit" value="Submit">
</form>

<br>

<?php
    echo "<img src='".$imageString."'>";
?>

<form method="post" action="imageUpload.php" enctype="multipart/form-data">
    <label for="uploadImage">Upload Image:</label>
    <input type="hidden" name="table" value="pcs">
    <input type="file" name="uploadImage">
    <input type="submit" name="submitImage" value="Upload">
</form>

<h2><a href="attributeDBPage.php">Attributes:</a></h2>

<table id="attributes">
    <tr>
        <th>Strength</th>
        <th>Dexterity</th>
        <th>Constitution</th>
        <th>Intelligence</th>
        <th>Wisdom</th>
        <th>Charisma</th>
    </tr>

    <?php
        $c = connect();
        foreach (getAllFromAttributesWhereCName($c, $_SESSION['pc']) as $row) {
            echo "<tr>";

            $keys = array("strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma");
            foreach ($keys as $key) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>\n";
        }
        $c->close();
    ?>
</table>

<!-- <form id="createForm" action="dbUpdate.php" onsubmit="return validateForm()" method="post">
    <label for="strength">Create Strength for PC:</label><br>
    <input type="number" name="strength" id="strength"><br>
    <label for="dexterity">Create Dexterity for PC:</label><br>
    <input type="number" name="dexterity" id="dexterity"><br>
    <label for="constitution">Create Constitution for PC:</label><br>
    <input type="number" name="constitution" id="constitution"><br>
    <label for="intelligence">Create Intelligence for PC:</label><br>
    <input type="number" name="intelligence" id="intelligence"><br>
    <label for="wisdom">Create Wisdom for PC:</label><br>
    <input type="number" name="wisdom" id="wisdom"><br>
    <label for="charisma">Create Charisma for PC:</label><br>
    <input type="number" name="charisma" id="charisma">
    <br><br>
    <input type="submit" value="Submit">
    <br><br>
</form> -->

<h2><a href="index.php">World:</a></h2>

<?php
$c = connect();
foreach (getAllFromTableWhereWorldEqualsY($c, "worlds", $_SESSION['world']) as $row) {
    $string = "";
    $keys = array("wName");
    foreach ($keys as $key) {
        $string = "<li>";
        $string .= "<a href=worldDescPage.php?world=".$row[$key].">".$row[$key]."</a>";
        $string .= "</li>\n";
    }
    echo $string;
}
$c->close();
?>

    <form action="loginLogout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>