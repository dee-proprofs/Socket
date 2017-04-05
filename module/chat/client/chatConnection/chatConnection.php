<?php
/**
 * Created by PhpStorm.
 * User: niteshkumar
 * Date: 10/03/16
 * Time: 12:13
 */
namespace chat\client\chatConnection;
use chat\client\chatRepository\chatRepositoryInterface;
use Ratchet\ConnectionInterface;
class chatConnection implements chatConnectionInterface
{
    private $connection;
    private $name;
    private $repository;
    public function __construct(ConnectionInterface $conn,chatRepositoryInterface $repository,$name=" ")
    {
        $this->connection=$conn;
        $this->name=$name;
        $this->repository=$repository;
    }
    public function getName()
    {
       return $this->name;
    }
    public function setName($name)
    {
        if($name=="")
            return;
       if($this->repository->getClientsByName($name)!==null) {
            $this->send([
                'action' => 'setname',
                'success' => false,
                'username' => $this->name
            ]);
            return;
        }
        $this->name = $name;
        $this->send([
            'action' => 'setname',
            'success' => true,
            'username' => $this->name
        ]);
    }
    public function sendMsg($sender, $msg)
    {
        $this->send([
            'action'   => 'message',
            'username' => $sender,
            'msg'      => $msg
        ]);
    }
    public function getConnections()
    {
        return $this->connection;
    }
    private function send(array $dat)
    {
        $this->connection->send(json_encode($dat));
    }
}