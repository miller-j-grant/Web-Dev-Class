<?php

/* Respond to the form submission from displayProfs2.
   (1) Connect to the database and perform the update
   (2) Redirect back to displayProfs2
*/

require('dbHelper.php');

if (array_key_exists('ilike', $_POST)) {
    $c = connect();
    updateLikes_efficient($c, $_POST['ilike']);
}


# redirect back to the original page;
header("Location: displayProfs2.php");
