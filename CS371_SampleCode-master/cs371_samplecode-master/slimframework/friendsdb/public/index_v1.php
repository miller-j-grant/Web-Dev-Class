<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

spl_autoload_register(function ($classname) {

    if (preg_match("/Controller$/", $classname)) {
        require("../classes/Controller/" . $classname . ".php");
    } else {
        require("../classes/Model" . $classname . ".php");
    }
});

$config['displayErrorDetails'] = true;

$app = new \Slim\App(["settings" => $config]);
$app->run();

