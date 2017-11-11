<?php

/* This illustrates how you can pass a script as a parameter to "php -S" to do custom routing. */

$theURL = $_SERVER['REQUEST_URI'];

// If the "file" requested ends in .php or .html, then return false and handle the file normally.

if (preg_match("/\.(html|php|txt)(\?.*)?$/", $theURL)) {
    return false;
}


// If the "file" is of the form /sayHi/some_name, then say hello.
if (preg_match("/\/sayHi\/(.*)/", $theURL, $matches)) {
    $name = $matches[1];
    echo "Well, Hello, $name.  It's good to see you.";
} else {

    // Otherwise, display a default message.
    echo "Oops.  I don't handle that type of file.";
}