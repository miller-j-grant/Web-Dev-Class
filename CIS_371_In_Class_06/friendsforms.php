<!DOCTYPE html>
<html>
<body>

<?php
    // Open the text file
    $f = fopen("friends.txt", "a") or die("Unable to open file!");

    $text = $_GET["firstname"];
    $text.= ",";
    $text.= $_GET["lastname"];
    $text.= ",";
    $text.= $_GET["phonenumber"];
    $text.= ",";
    $text.= $_GET["age"];
    $text.= PHP_EOL;

    // Write text line
    fwrite($f, $text);

    // Close the text file
    fclose($f);
?>

</body>
</html>
