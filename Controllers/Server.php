<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Chat;


class Server extends BaseController
{
    public function index(){
        // exit;
        if(!is_cli()){
            die("Not a shell");
        }
        require 'vendor/autoload.php';
        
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8000
        );
    
        $server->run();
    }
    
    public function test_page(){
        return view("test_page");
    }
}
