<!--  Running this code will make sure that your PHP environment is properly configured. In particular,
      it will verify that the server will display errors when they occur. It is common to suppress error
      messages in a production environment; but, you definitely want to see them when learning PHP.
-->


<?php
// This line of code can be used to override the value in php.ini and/or .htaccess
/* ini_set('display_errors', 1); */
?>
<html>
<head>
    <title>Bug!</title>
</head>
<body>

<h1>BUG!</h1>

<p>The php code below this paragraph contains a bug. If you don't see any error messages, then I suggest adding
    "<code>php_flag display_errors on</code>" to your
    <code>.htaccess</code> file so that the web server displays PHP errors.</p>

<?php calling_no_such_method("foo", "bar"); ?>

<p>(If you see this message, then the error in the php script above got messed up:)</p>

</body>

</html>
