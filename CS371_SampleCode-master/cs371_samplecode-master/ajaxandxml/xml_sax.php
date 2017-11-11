<?php
/**
 * Demonstration of SAX parsing in PHP.
 *
 *
 * User: kurmasz
 * Date: 3/9/15
 * Time: 3:38 PM
 */

function sax_start($sax, $tag, $attr)
{
    echo "Starting -- $tag\n";
    foreach ($attr as $item => $value) {
        echo "\t$item => $value\n";
    }
}

function sax_end($sax, $tag)
{
    echo "Ending -- $tag\n";
}

function sax_cdata($sax, $data) {
    $tdata = trim($data);
    if (strlen($tdata) > 0)
    echo "\t=>$tdata<=\n";
}


$sax = xml_parser_create();
xml_parser_set_option($sax, XML_OPTION_SKIP_WHITE, true);
xml_set_element_handler($sax, 'sax_start', 'sax_end');
xml_set_character_data_handler($sax, 'sax_cdata');

xml_parse($sax, file_get_contents('friends.xml'), true);
xml_parser_free($sax);

