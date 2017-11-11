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
                message = "Please enter in some details (Don't want to completely overwrite your details).";
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
if(!isset($_SESSION['npc'])){ //if session variable is not set
    $_SESSION["npc"] = $_GET["npc"];
}

echo "<h1>NPC Description: ".$_SESSION['npc']."</h1>";

$c = connect();
$detailString = "No details yet ...";
$imageString = "";
foreach (getDetailsFromTableWhereKeyEqualsValue($c, "npcs", "cName", $_SESSION['npc']) as $row) {
    $keys = array("details");
    foreach ($keys as $key) {
        if($key === "details"){
            $detailString = $row[$key];
        }
    }
}

foreach (getImageFromTableWhereKeyEqualsValue($c, "npcs", "cName", $_SESSION['npc']) as $row) {
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
    <input type="hidden" name="detailHidden" value="npc">
    <input type="submit" value="Submit">
</form>

<br>

<?php
    echo "<img src='".$imageString."'>";
?>

<form method="post" action="imageUpload.php" enctype="multipart/form-data">
    <label for="uploadImage">Upload Image:</label>
    <input type="hidden" name="table" value="npcs">
    <input type="file" name="uploadImage">
    <input type="submit" name="submitImage" value="Upload">
</form>

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

<h2><a href="locationDBPage.php">Location:</a></h2>

<?php
$c = connect();
foreach (getAllFromTableWhereLocationEqualsY($c, "locations", $_SESSION['location']) as $row) {
    $string = "";
    $keys = array("lName");
    foreach ($keys as $key) {
        $string = "<li>";
        $string .= "<a href=locationDescPage.php?location=".$row[$key].">".$row[$key]."</a>";
        $string .= "</li>\n";
    }
    echo $string;
}
$c->close();
?>

<h2><a href="organizationDBPage.php">Organization:</a></h2>

<?php
$c = connect();
foreach (getAllFromTableWhereOrganizationEqualsY($c, "organizations", $_SESSION['organization']) as $row) {
    $string = "";
    $keys = array("oName");
    foreach ($keys as $key) {
        $string = "<li>";
        $string .= "<a href=organizationDescPage.php?npc=".$row[$key].">".$row[$key]."</a>";
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