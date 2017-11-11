<?php
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);
?>

<?php session_start(); ?>

<?php

/* Respond to the form submission from index.php and loginPage.php
   (1) Connect to the database and perform the update
   (2) Redirect back to index.php
*/

require('dbHelper.php');

$c = connect();

if(array_key_exists('createName', $_POST)){
    if($_POST['hidden'] === "world"){
        $postArray = array($_POST['createName'], null);
        updateWorlds_efficient($c, $postArray);
        
        // redirect back to the original page;
        header('Location: index.php');
    }
    else if($_POST['hidden'] === "sector"){
        $postArray = array($_POST['createName'], $_SESSION['world'], null);
        updateSectors_efficient($c, $postArray);
        
        // redirect back to the original page;
        header('Location: sectorDBPage.php');
    }
    else if($_POST['hidden'] === "location"){
        $postArray = array($_POST['createName'], $_SESSION['sector'], $_SESSION['world'], null);
        updateLocations_efficient($c, $postArray);
        
        // redirect back to the original page;
        header('Location: locationDBPage.php');
    }
    else if($_POST['hidden'] === "organization"){
        $postArray = array($_POST['createName'], $_SESSION['location'], $_SESSION['sector'], 
            $_SESSION['world'], null);
        updateOrganizations_efficient($c, $postArray);
        
        // redirect back to the original page;
        header('Location: organizationDBPage.php');
    }
    else if($_POST['hidden'] === "npc"){
        $postArray = array($_POST['createName'], $_SESSION['location'], $_SESSION['organization'], 
            $_SESSION['world'], null);
        updateNPCS_efficient($c, $postArray);
        
        // redirect back to the original page;
        header('Location: npcDBPage.php');
    }
    else if($_POST['hidden'] === "pc"){
        $postArray = array($_POST['createName'], $_POST['playerName'], $_SESSION['world'], null);
        updatePCS_efficient($c, $postArray);
        
        // redirect back to the original page;
        header('Location: pcDBPage.php');
    }
}
// else if(array_key_exists('strength', $_POST){
//     echo "made it to the update if";
//     $postArray = array($_POST['strength'], $_POST['dexterity'],  $_POST['constitution'],  $_POST['intelligence'], $_POST['wisdom'],  $_POST['charisma']);
//     updateAttributes_efficient($c, $postArray);

//     // redirect back to the original page;
//     header('Location: pcDescPage.php');
// }
else if(array_key_exists('detailBox', $_POST)){
    if($_POST["detailHidden"] === "world"){
        $postArray = array($_SESSION['world'], $_POST['detailBox']);
        updateWorlds_efficient($c, $postArray);

        // redirect back to the original page;
        header('Location: worldDescPage.php');
    }
    else if($_POST["detailHidden"] === "sector"){
        $postArray = array($_SESSION['sector'], $_SESSION['world'], $_POST['detailBox']);
        updateSectors_efficient($c, $postArray);

        // redirect back to the original page;
        header('Location: sectorDescPage.php');
    }
    else if($_POST["detailHidden"] === "location"){
        $postArray = array($_SESSION['location'], $_SESSION['sector'], $_SESSION['world'], 
            $_POST['detailBox']);
        updateLocations_efficient($c, $postArray);

        // redirect back to the original page;
        header('Location: locationDescPage.php');
    }
    else if($_POST["detailHidden"] === "organization"){
        $postArray = array($_SESSION['organization'], $_SESSION['location'], $_SESSION['sector'], 
            $_SESSION['world'], $_POST['detailBox']);
        updateOrganizations_efficient($c, $postArray);

        // redirect back to the original page;
        header('Location: organizationDescPage.php');
    }
    else if($_POST["detailHidden"] === "npc"){
        $postArray = array($_SESSION['npc'], $_SESSION['location'], $_SESSION['organization'], 
            $_SESSION['world'], $_POST['detailBox']);
        updateNPCS_efficient($c, $postArray);

        // redirect back to the original page;
        header('Location: npcDescPage.php');
    }
    else if($_POST["detailHidden"] === "pc"){
        $postArray = array($_SESSION['pc'], $_SESSION['world'], $_POST['detailBox']);
        updatePCS_efficient($c, $postArray);

        // redirect back to the original page;
        header('Location: pcDescPage.php');
    }
}