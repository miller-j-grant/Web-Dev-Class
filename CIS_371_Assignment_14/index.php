<?php
ini_set('display_errors', 1);

$xmlDoc = new DomDocument();
$xmlDoc->load("events.xml");
$root = $xmlDoc->documentElement;
$events = $root->getElementsByTagName("event");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style2.css" type="text/css"/>
    <title>Assignment 14</title>
    <script type="text/javascript" src="eventScript.js"></script>
</head>

<?php require('calendar.php'); ?>

<body>

<h1>Assignment 14 - Calendar Events</h1>

<?php
if(array_key_exists("month",$_GET)){
    $month = $_GET['month'];
}else{
    $month = date('n');
}

if(array_key_exists("year",$_GET)){
    $year = $_GET['year'];
}else{
    $year = date('Y');
}

echo date('M', mktime(0,0,0,$month,1,$year));
echo ' ';
echo $year;

$eventArr = array();
$IDArr = array();

foreach ($events as $event) {
    $title = $event->getElementsByTagName("title")->item(0)->firstChild->wholeText;
    $id = $event->getElementsByTagName("id")->item(0)->firstChild->wholeText;
    $day = $event->getElementsByTagName("date")->item(0)->getAttribute('day');
    $idString = "event" . $id;

    $eventArr[$day] = $title;
    $IDArr[$title] = $idString;
}

createCalendar($month, $year, $eventArr, $IDArr);
?>

<div id="eventDetails">
    <table>
        <tr>
            <td>Title:</td>
            <td id="eventTitle"></td>
        </tr>
        <tr>
            <td>Date:</td>
            <td id="eventDate"></td>
        </tr>
        <tr>
            <td>Start Time:</td>
            <td id="eventStart"></td>
        </tr>
        <tr>
            <td>Stop Time:</td>
            <td id="eventStop"></td>
        </tr>
    </table>
    Description:
    <span id="eventDescription"></span>
</div>

<form name="xmlForm" action="xmlAppending.php" method="get">

    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title">
    <br>
    <label for="month">Date (Month):</label><br>
    <input type="text" name="month" id="month">
    <br>
    <label for="day">Date (Day):</label><br>
    <input type="text" name="day" id="day">
    <br>
    <label for="year">Date (Year):</label><br>
    <input type="text" name="year" id="year">
    <br>
    <label for="start">Start:</label><br>
    <input type="text" name="start" id="start">
    <br>
    <label for="stop">Stop:</label><br>
    <input type="text" name="stop" id="stop">
    <br>
    <label for="description">Description:</label><br>
    <input type="text" name="description" id="description">
    <br><br>
    <input type="submit" value="Submit">
    <br><br>

</form>

</body>
</html>