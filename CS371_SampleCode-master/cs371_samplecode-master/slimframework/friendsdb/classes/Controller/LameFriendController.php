<?php
/**
 * Created by IntelliJ IDEA.
 * User: kurmasz
 * Date: 5/27/16
 * Time: 10:08 AM
 */

// This controller is "Lame" because it doesn't make proper use of model or view classes.
class LameFriendController
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;

    }

    // Show all friends
    public function index($request, $response) {
        $connection = new mysqli('127.0.0.1', 'kurmasz', 'kurmasz1234', 'kurmasz');

        $result = $connection->query('select * from l1_friends');

        $html = "<html><body>Your friends are:<p><table>";

        foreach ($result as $row) {
            $html .= "<tr><td>". $row[firstname] . "</td><td>" . $row[lastname] . "</td></tr>";
        }

        $html .= "</table></body></html>";

        $response->getBody()->write($html);
        return $response;
    }

    // Show just one friend
    public function show($request, $response, $args) {

        $connection = new mysqli('127.0.0.1', 'kurmasz', 'kurmasz1234', 'kurmasz');

        $result = $connection->query('select * from l1_friends where id=' . $args[id]);

        $html = "<html><body>Friend number $args[id] is ";

        $f = $result->fetch_object();

        $html .= "$f->firstname $f->lastname<br>";
        $html .= "Phone: $f->phone<br>";
        $html .= "Age: $f->age<br>";

        $html .="</body></html>";

        $response->getBody()->write($html);
        return $response;
    }


}