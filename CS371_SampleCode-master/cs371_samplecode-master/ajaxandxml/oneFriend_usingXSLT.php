<?php
/**
 * Takes the id of a friend as a parameter from the query string
 *
 * Use XSLT to transform that friend record from XML to HTML.
 *
 * Return the HTML.
 *
 *
 * Created by IntelliJ IDEA.
 * User: kurmasz
 * Date: 3/16/15
 * Time: 1:36 PM
 */

header('Content-Type: text/xml');

$desiredID = $_GET["id"];
$xmlDoc = new DomDocument();
$xmlDoc->load("friends.xml");

$xsl = new DomDocument();
$xsl->load("displayOneFriend.xsl");

$proc = new XSLTProcessor();
$proc->importStyleSheet($xsl);
$proc->setParameter('', 'theId', $desiredID);
echo $proc->transformToXML($xmlDoc);


