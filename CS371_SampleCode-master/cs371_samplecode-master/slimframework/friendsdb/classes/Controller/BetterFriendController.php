<?php
/**
 * Created by IntelliJ IDEA.
 * User: kurmasz
 * Date: 5/27/16
 * Time: 10:08 AM
 */
// This controller is "Better"" because it uses views, but it doesn't use Models.
class BetterFriendController
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;

    }

    // Show all friends
    public function index($request, $response)
    {
        $view = new \Slim\Views\PhpRenderer("../templates/");
        $connection = new mysqli('127.0.0.1', 'kurmasz', 'kurmasz1234', 'kurmasz');

        $result = $connection->query('select * from l1_friends');

        $response = $view->render($response, "allFriends.phtml",
            [friends=>$result]);
        return $response;
    }

    // Show just one friend
    public function show($request, $response, $args)
    {

        $view = new \Slim\Views\PhpRenderer("../templates/");

        $connection = new mysqli('127.0.0.1', 'kurmasz', 'kurmasz1234', 'kurmasz');
        $result = $connection->query('select * from l1_friends where id=' . $args[id]);

        $row = $result->fetch_object();
        $response = $view->render($response, "oneFriend.phtml",
            [id => $args[id], friend=>$row]);
        return $response;
    }


}