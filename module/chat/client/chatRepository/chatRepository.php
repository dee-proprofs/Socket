<?php
/**
 * Created by PhpStorm.
 * User: niteshkumar
 * Date: 10/03/16
 * Time: 13:19
 */
namespace chat\client\chatRepository;
use Ratchet\ConnectionInterface;
use chat\client\chatConnection\chatConnection;

class chatRepository implements chatRepositoryInterface
{
    private $clients;
    public function __construct()
    {
        $this->clients=new \SplObjectStorage;
    }
    public function addClient(ConnectionInterface $conn)
    {
        $this->clients->attach(new chatConnection($conn,$this));
    }
    public function removeClient(ConnectionInterface $conn)
    {
        $client=$this->getClientsByConnection($conn);
        if($client!==null)
          $this->clients->detach($client);
    }
    public function getClientsByName($name)
    {
        foreach($this->clients as $client)
        {
        if($client->getName()===$name)
        return $client;
        }
        return null;
    }
    public function getClientsByConnection(ConnectionInterface $conn)
    {
        foreach($this->clients as $client)
        {
            if($client->getConnections() === $conn)
                return $client;
        }
        return null;
    }
    public function getClients()
    {
        return $this->clients;
    }
}