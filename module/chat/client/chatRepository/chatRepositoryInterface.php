<?php
/**
 * Created by PhpStorm.
 * User: niteshkumar
 * Date: 10/03/16
 * Time: 12:29
 */
namespace chat\client\chatRepository;
use Ratchet\ConnectionInterface;

interface chatRepositoryInterface
{
    public function getClientsByName($name);
    public function getClientsByConnection(ConnectionInterface $conn);
    public function addClient(ConnectionInterface $conn);
    public function removeClient(ConnectionInterface $conn);
    public function getClients();
}