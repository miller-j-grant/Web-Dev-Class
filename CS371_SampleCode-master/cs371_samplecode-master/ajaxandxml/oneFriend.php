<?php
/**
 * Takes a friend's id as a parameter through the query string
 *
 * Loads friends.xml
 *
 * Finds the <friend> element with the requested element
 *
 * Returns the XML for that element only.
 *
 * Created by IntelliJ IDEA.
 * User: kurmasz
 * Date: 3/11/15
 * Time: 1:16 PM
 */
$useXPATH = false;

// Notice that we set the content type to be XML.
// (i.e., we are committing to sending XML data)
header('Content-Type: text/xml');


$xmlDoc = new DomDocument();
$xmlDoc->load("friends.xml");
$desiredID = $_GET["id"];

/////////////////////////////////////////////////////
//
// The "long way": Search the DOM
//
/////////////////////////////////////////////////////

// Use the methods we've been using all semester to 
// search through the DOM for the friend with the requested id.

if (!$useXPATH) {
    $root = $xmlDoc->documentElement;
    $friends = $root->getElementsByTagName("friend");

    foreach ($friends as $friend) {
        $id = $friend->getElementsByTagName("id")->item(0)->firstChild->wholeText;
        if ($id == $desiredID) {
            echo $xmlDoc->saveXML($friend);
        }
    }
} else {
/////////////////////////////////////////////////////
//
// The "short way": Use XPATH
//
/////////////////////////////////////////////////////

// Use XPath to search the DOM for you.
// friend[id=$desiredID] is the XPath syntax for "the friend element whose id is $desiredID"

    $xp = new DOMXPath($xmlDoc);
    echo $xmlDoc->saveXML($xp->evaluate("friend[id=$desiredID]")[0]);
}

?>