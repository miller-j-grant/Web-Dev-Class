<?php
$xmlDoc = new DomDocument();
$xmlDoc->load("events.xml");
$root = $xmlDoc->documentElement;
$events = $root->getElementsByTagName("event");

$title = $_GET['title'];
$month = $_GET['month'];
$day = $_GET['day'];
$year = $_GET['year'];
$start = $_GET['start'];
$stop = $_GET['stop'];
$desc = $_GET['description'];

$id =1;

foreach ($events as $event) {
    $id++;
}

$newEvent = $xmlDoc->createElement("event");
$newID = $xmlDoc->createElement("id");
$newTitle = $xmlDoc->createElement("title");
$newDate = $xmlDoc->createElement("date");
$newStart = $xmlDoc->createElement("start");
$newStop = $xmlDoc->createElement("stop");
$newDescription = $xmlDoc->createElement("description");

$textID=$xmlDoc->createTextNode($id);
$textTitle=$xmlDoc->createTextNode($title);
$textStart=$xmlDoc->createTextNode($start);
$textStop=$xmlDoc->createTextNode($stop);
$textDescription=$xmlDoc->createTextNode($desc);

$newID->appendChild($textID);
$newTitle->appendChild($textTitle);
$newStart->appendChild($textStart);
$newStop->appendChild($textStop);
$newDescription->appendChild($textDescription);

$newDate->setAttribute("month", $month);
$newDate->setAttribute("day", $day);
$newDate->setAttribute("year", $year);

$newEvent->appendChild($newID);
$newEvent->appendChild($newTitle);
$newEvent->appendChild($newDate);
$newEvent->appendChild($newStart);
$newEvent->appendChild($newStop);
$newEvent->appendChild($newDescription);

$xmlDoc->getElementsByTagName("events")[0]->appendChild($newEvent);

$xmlDoc->save('events.xml');

header('Location: index.php');