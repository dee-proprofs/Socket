<?php
/**
 * Created by PhpStorm.
 * User: niteshkumar
 * Date: 10/03/16
 * Time: 11:35
 */
namespace chat\server;
require_once '../../../vendor/autoload.php';
use chat\client\client;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(new HttpServer(new WsServer(new client())),3000);
$server->run();