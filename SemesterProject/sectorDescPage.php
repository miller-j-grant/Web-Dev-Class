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
if(!isset($_SESSION['sector'])){ //if session variable is not set
    $_SESSION["sector"] = $_GET["sector"];
}

echo "<h1>Sector Description: ".$_SESSION['sector']."</h1>";

$c = connect();
$detailString = "No details yet ...";
$imageString = "";
foreach (getDetailsFromTableWhereKeyEqualsValue($c, "sectors", "sName", $_SESSION['sector']) as $row) {
    $keys = array("details");
    foreach ($keys as $key) {
        if($key === "details"){
            $detailString = $row[$key];
        }
    }
}

foreach (getImageFromTableWhereKeyEqualsValue($c, "sectors", "sName", $_SESSION['sector']) as $row) {
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
    <input type="hidden" name="detailHidden" value="sector">
    <input type="submit" value="Submit">
</form>

<br>

<?php
    echo "<img src='".$imageString."'>";
?>

<form method="post" action="imageUpload.php" enctype="multipart/form-data">
    <label for="uploadImage">Upload Image:</label>
    <input type="hidden" name="table" value="sectors">
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

<h2><a href="locationDBPage.php">Locations:</a></h2>

<?php
$c = connect();
foreach (getAllFromTableWhereSectorEqualsY($c, "locations", $_SESSION['sector']) as $row) {
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

<h2><a href="organizationDBPage.php">Organizations:</a></h2>

<?php
$c = connect();
foreach (getAllFromTableWhereSectorEqualsY($c, "organizations", $_SESSION['sector']) as $row) {
    $string = "";
    $keys = array("oName");
    foreach ($keys as $key) {
        $string = "<li>";
        $string .= "<a href=organizationDescPage.php?organization=".$row[$key].">".$row[$key]."</a>";
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