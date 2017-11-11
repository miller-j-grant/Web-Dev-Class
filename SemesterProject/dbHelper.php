<?php

session_start();

// Connect to the database
function connect()
{
    // Create an mysqli object connected to the database.
    $connection = new mysqli("cis.gvsu.edu", "millgran", "millgran");

    // Complain if the the connection fails.  (This needs to be more graceful
    // in a production environment.)
    if (!$connection || $connection->connect_error) {
        die('Unable to connect to database [' . $connection->connect_error . ']');
    }
    if (!$connection->select_db("millgran")) {
        die ("Unable to select database:  [" . $connection->error . "]");
    }
    return $connection;
}

// retrieve all rows
function getAllFromTableWhereUsername($c, $table)
{
    $sql = "SELECT * FROM ".$table." WHERE username='".$_SESSION['login']."' OR username IS NULL";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getAllFromAttributesWhereCName($c, $cName){
    $sql = "SELECT * FROM attributes WHERE cName='".$cName."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getAllFromTableWhereWorldEqualsY($c, $table, $world){
    $sql = "SELECT * FROM ".$table." WHERE wName='".$world."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getAllFromTableWhereSectorEqualsY($c, $table, $sector){
    $sql = "SELECT * FROM ".$table." WHERE sName='".$sector."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getAllFromTableWhereLocationEqualsY($c, $table, $location){
    $sql = "SELECT * FROM ".$table." WHERE lName='".$location."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getAllFromTableWhereOrganizationEqualsY($c, $table, $organization){
    $sql = "SELECT * FROM ".$table." WHERE oName='".$organization."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getDetailsFromTableWhereKeyEqualsValue($c, $table, $key, $value){
    $sql = "SELECT details FROM ".$table." WHERE ".$key."='".$value."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getImageFromTableWhereKeyEqualsValue($c, $table, $key, $value){
    $sql = "SELECT image FROM ".$table." WHERE ".$key."='".$value."'";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function getAllUsernamesAndPasswords($c){
    $sql = "SELECT * FROM accounts";
    $result = mysqli_query($c, $sql);
    if (!$result) {
        die ("Query was unsuccessful: [" . $c->error . "]");
    }
    return $result;
}

function updateWorlds_efficient($c, $postArray){

    $qUpdate = "INSERT INTO worlds
  		(wName, details, username)
		VALUES
  		('".$postArray[0]."', '".$postArray[1]."', '".$_SESSION['login']."')
		ON DUPLICATE KEY UPDATE
		wName = wName,
		details = '".$postArray[1]."',
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updateSectors_efficient($c, $postArray){

    $qUpdate = "INSERT INTO sectors
        (sName, wName, details, username)
        VALUES
        ('".$postArray[0]."', '".$postArray[1]."', '".$postArray[2]."', '".$_SESSION['login']."')
        ON DUPLICATE KEY UPDATE
        sName = sName,
        wName = wName,
        details = '".$postArray[2]."',
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updateLocations_efficient($c, $postArray){

    $qUpdate = "INSERT INTO locations
        (lName, sName, wName, details, username)
        VALUES
        ('".$postArray[0]."', '".$postArray[1]."', '".$postArray[2]."', '".$postArray[3]."', 
            '".$_SESSION['login']."')
        ON DUPLICATE KEY UPDATE
        lName = lName,
        sName = sName,
        wName = wName,
        details = '".$postArray[3]."',
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updateOrganizations_efficient($c, $postArray){

    $qUpdate = "INSERT INTO organizations
        (oName, lName, sName, wName, details, username)
        VALUES
        ('".$postArray[0]."', '".$postArray[1]."', '".$postArray[2]."', '".$postArray[3]."', 
            '".$postArray[4]."', '".$_SESSION['login']."')
        ON DUPLICATE KEY UPDATE
        oName = oName,
        lName = lName,
        sName = sName,
        wName = wName,
        details = '".$postArray[4]."',
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updateNPCS_efficient($c, $postArray){

    $qUpdate = "INSERT INTO npcs
        (cName, lName, oName, wName, details, username)
        VALUES
        ('".$postArray[0]."', '".$postArray[1]."', '".$postArray[2]."', '".$postArray[3]."', 
            '".$postArray[4]."', '".$_SESSION['login']."')
        ON DUPLICATE KEY UPDATE
        cName = cName,
        lName = lName,
        oName = oName,
        wName = wName,
        details = '".$postArray[4]."',
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updatePCS_efficient($c, $postArray){

    $qUpdate = "INSERT INTO pcs
        (cName, pName, wName, details, username)
        VALUES
        ('".$postArray[0]."', '".$postArray[1]."', '".$postArray[2]."', '".$postArray[3]."', 
             '".$_SESSION['login']."')
        ON DUPLICATE KEY UPDATE
        cName = cName,
        lName = lName,
        oName = oName,
        wName = wName,
        details = '".$postArray[3]."',
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updateAttributes_efficient($c, $postArray){

    $qUpdate = "INSERT INTO attributes
        (cName, strength, dexterity, constitution, intelligence, wisdom, charisma, username)
        VALUES
        ('".$_SESSION['pc']."', ".$postArray[0].", ".$postArray[1].", ".$postArray[2].", ".$postArray[3].",  
            ".$postArray[4].", ".$postArray[5].", '".$_SESSION['login']."')
        ON DUPLICATE KEY UPDATE
        cName = cName,
        strength = ".$postArray[0].",
        dexterity = ".$postArray[1].",
        constitution = ".$postArray[2].",
        intelligence = ".$postArray[3].",
        wisdom = ".$postArray[4].",
        charisma = ".$postArray[5].",
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function updateAccounts($c, $postArray){

    $qUpdate = "INSERT INTO accounts
        (username, password)
        VALUES
        ('".$postArray[0]."', '".$postArray[1]."')
        ON DUPLICATE KEY UPDATE 
        username = username";
    if (!mysqli_query($c, $qUpdate)) {
        die ("problem with update: " . $c->error);
    }
}

function insertImageNameToDB($c, $imageName, $table){
    if($table==="worlds"){
        echo $_SESSION['world'];
        $sql = "INSERT INTO ".$table." 
        (wName, image) 
        VALUES ('".$_SESSION['world']."', '".$imageName."')
        ON DUPLICATE KEY UPDATE
        wName=wName,
        image='".$imageName."'";
    }
    elseif($table==="sectors"){
        echo $_SESSION['sector'];
        $sql = "INSERT INTO ".$table." 
        (sName, image) 
        VALUES ('".$_SESSION['sector']."', '".$imageName."')
        ON DUPLICATE KEY UPDATE
        sName=sName,
        image='".$imageName."'";
    }
    elseif($table==="locations"){
        echo $_SESSION['location'];
        $sql = "INSERT INTO ".$table." 
        (lName, image) 
        VALUES ('".$_SESSION['location']."', '".$imageName."')
        ON DUPLICATE KEY UPDATE
        lName=lName,
        image='".$imageName."'";
    }
    elseif($table==="organizations"){
        echo $_SESSION['organization'];
        $sql = "INSERT INTO ".$table." 
        (oName, image) 
        VALUES ('".$_SESSION['organization']."', '".$imageName."')
        ON DUPLICATE KEY UPDATE
        oName=oName,
        image='".$imageName."'";
    }
    elseif($table==="npcs"){
        echo $_SESSION['npc'];
        $sql = "INSERT INTO ".$table." 
        (cName, image) 
        VALUES ('".$_SESSION['npc']."', '".$imageName."')
        ON DUPLICATE KEY UPDATE
        cName=cName,
        image='".$imageName."'";
    }
    elseif($table==="pcs"){
        echo $_SESSION['pc'];
        $sql = "INSERT INTO ".$table." 
        (cName, image) 
        VALUES ('".$_SESSION['pc']."', '".$imageName."')
        ON DUPLICATE KEY UPDATE
        cName=cName,
        image='".$imageName."'";
    }
    if (!mysqli_query($c, $sql)) {
        die ("problem with update: " . $c->error);
    }
}
?>
