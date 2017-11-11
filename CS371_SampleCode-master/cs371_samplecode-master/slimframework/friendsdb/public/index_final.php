<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

spl_autoload_register(function ($classname) {

    if (preg_match("/Controller$/", $classname)) {
        require(__DIR__ . "/../classes/Controller/" . $classname . ".php");
    } else {
        require(__DIR__ . "/../classes/Model/" . $classname . ".php");
    }
});

$config['displayErrorDetails'] = true;

$config['db']['host'] = "127.0.0.1";
$config['db']['user'] = "kurmasz";
$config['db']['pass'] = "kurmasz1234";
$config['db']['dbname'] = "kurmasz";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();


$container['view'] = new \Slim\Views\PhpRenderer("../templates/");
$container['db'] = function ($config) {
    $db = $config['settings']['db'];
    return new mysqli($db['host'], $db['user'], $db['pass'], $db['dbname']);
};
$container['friend'] = new FriendMapper($container['db']);

$app->map(['GET'], '/friends', 'BestFriendController:index');
$app->map(['GET'], '/friend/{id}', 'BestFriendController:show');


$app->run();

