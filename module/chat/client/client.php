<?php
/**
 * Created by PhpStorm.
 * User: niteshkumar
 * Date: 10/03/16
 * Time: 11:35
 */
namespace chat\client;
use Ratchet\ConnectionInterface;
use chat\client\chatRepository\chatRepository;
use Ratchet\MessageComponentInterface;

class client implements MessageComponentInterface
{
    private $repository;
    public function __construct()
    {
        $this->repository=new chatRepository();
    }
    public function onOpen(ConnectionInterface $conn)
    {
        $this->repository->addClient($conn);
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data=$this->parseMessage($msg);
        $client=$this->repository->getClientsByConnection($from);
        if($data->action=="message")
        {
            if($client->getName()==null)
                return;
            foreach($this->repository->getClients() as $clients)
            {
            if($client->getName()!==$clients->getName())
            {
            $clients->sendMsg($client->getName(),$data->msg);
            }
            }
        }
        elseif($data->action=="setname")
        {
            $client->setName($data->username);
        }
    }
    public function onClose(ConnectionInterface $conn)
    {
        $this->repository->removeClient($conn);
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error had occured ".$e->getMessage();
        $client=$this->repository->getClientsByConnection($conn);
        if($client!==null) {
            $client->getConnections()->close();
            $this->repository->removeClient($conn);
        }
    }
    private function parseMessage($msg)
    {
        return json_decode($msg);
    }
}