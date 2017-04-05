<?php
/**
 * Created by PhpStorm.
 * User: niteshkumar
 * Date: 10/03/16
 * Time: 11:41
 */
namespace chat\client\chatConnection;
interface chatConnectionInterface
{
    public function getName();
    public function getConnections();
    public function setName($name);
    public function sendMsg($sender,$msg);
}