<?php
/**
 * Created by IntelliJ IDEA.
 * User: kurmasz
 * Date: 5/27/16
 * Time: 10:08 AM
 */
// This controller is "Lame" because it doesn't make proper use of model or view classes.
class BestFriendController
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    // Show all friends
    public function index($request, $response)
    {
        $view = $this->container->view;
        $model = $this->container->friend;

        $response = $view->render($response, "allFriends.phtml",
            ['friends' => $model->getFriends()]);
        return $response;
    }

    // Show just one friend
    public function show($request, $response, $args)
    {
        $args[id]
        $view = $this->container->view;
        $model = $this->container->friend;

        $response = $view->render($response, "oneFriend.phtml",
            ['id'=> $args['id'], 'friend' => $model->getFriend($args['id'])]);
        return $response;
    }
}