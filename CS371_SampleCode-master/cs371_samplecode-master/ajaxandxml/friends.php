<?php
ini_set('display_errors', 1);
/**
 * Created by IntelliJ IDEA.
 * User: kurmasz
 * Date: 3/11/15
 * Time: 9:26 AM
 */

$xmlDoc = new DomDocument();
$xmlDoc->load("friends.xml");
$root = $xmlDoc->documentElement;
$friends = $root->getElementsByTagName("friend");
?>


<html>
<head>
    <title>Friends List</title>
    <script type="text/javascript" src="friendScript.js"></script>
    <style type="text/css">
        #friendList {
            display: inline-block;
        }

        #friendDetails {
            display: inline-block;
            border: 1px solid black;
            background-color: lightgreen;
            min-width: 200px;
        }
    </style>
</head>

<body>

<h1>My Friends</h1>

<div id="friendList">
    <ul>
        <?php
        foreach ($friends as $friend) {
            $name = $friend->getElementsByTagName("name")->item(0)->firstChild->wholeText;
            $id = $friend->getElementsByTagName("id")->item(0)->firstChild->wholeText;
            $idString = "friend" . $id;

            echo "<li id='$idString' class='friendName'>" . $name . "</li>";
        }
        ?>
    </ul>
</div>
<div id="friendDetails">
        <table>
            <tr>
                <td>Name:</td>
                <td id="friendName"></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td id="friendPhone"></td>
            </tr>
            <tr>
                <td>Hobby:</td>
                <td id="friendHobby"></td>
            </tr>
        </table>
        Note:
        <span id="friendNote"></span>
</div>


</body>

</html>
