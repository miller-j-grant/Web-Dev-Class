<?php

class FriendMapper
{
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function getFriends()
    {
        $sql = "select * from l1_friends";
        $result = $this->connection->query($sql);
        return $result;
    }

    public function getFriend($id) {
        $sql = "select * from l1_friends where id=" . $id;
        $result = $this->connection->query($sql);
        return $result->fetch_object();
    }

}