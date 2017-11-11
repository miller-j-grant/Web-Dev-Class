<?php
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);
?>

<?php session_start(); ?>

<?php
require('dbHelper.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploadImage"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submitImage"])) {
    $check = getimagesize($_FILES["uploadImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["uploadImage"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["uploadImage"]["name"]). " has been uploaded.";
    } else {
        echo $_FILES;
        die ("Error uploading image:  [" . $_FILES['uploadImage']['error'] . "]");
        //echo "Sorry, there was an error uploading your file.";
    }
}

$c = connect();
insertImageNameToDB($c, $target_file, $_POST["table"]);

if($_POST["table"]==="worlds"){
  header('Location: worldDescPage.php');
}

// header('Location: worldDescPage.php');
?>