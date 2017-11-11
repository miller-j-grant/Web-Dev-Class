<!-- Shows all the variables that are automatically set up and available
     for your use.  Also demonstrates how the key/value pairs in query
     strings are placed into variables.  Append a query string to the
     URL and see what happens.
-->
<?php
$_SERVER; $_ENV; # This line simply "touches" the $_SERVER superglobal variable to make sure that it gets loaded in $GLOBALS.

# Dump the top two levels of an associative array
function dump_array($the_array)
{
    echo "<ul>";

    foreach ($the_array as $key1 => $value1) {
        echo "<li>$key1";

        # If the value is itself an array, then print that as well.
        if (is_array($value1)) {
            echo "<ul>";
            foreach ($value1 as $key2 => $value2) {
                $pvalue = $value2;
                if (is_array($value2)) {
                    $pvalue = "&lt;an array&gt;";
                }
                echo "<li>($key2, $pvalue)</li>\n";
            } # end inner foreach ($value1 as $key2 => $value2)
            echo "</ul></li>\n";
        } else {
            echo "&nbsp = &nbsp; $value1</li>\n";
        }
    } # end outer foreach ($the_array as $key1 => $value1)
    echo "</ul>\n";
}

?>

<html>
<head>
    <title>Globals</title>
</head>
<body>
<h1>Query String</h1>

<p>Here are the values in the query string (obtained from the <code>$_GET</code> superglobal variable):</p>

<table>
    <tr>
        <th>Key</th>
        <th>Value</th>
    </tr>
    <?php
    $gratuitous = "Hi, everybody!";
    foreach ($_GET as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>\n";
    }
    ?>
</table>
<hr>

<h1>Globals</h1>

<p>A list of global variables. (Notice that <code>$GLOBALS</code> is on this list, as well as the <code>gratuitous</code>
    variable created before the previous loop)</p>

<?php dump_array($GLOBALS); ?>

</ul>

<hr>
<h1><code>var_dump</code></h1>

<p>The <code>var_dump</code> function can be very  helpful for debugging:</p>

<?php var_dump($GLOBALS) ?>

</body>
</html>