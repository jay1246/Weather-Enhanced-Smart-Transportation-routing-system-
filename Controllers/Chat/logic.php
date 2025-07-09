<?php

namespace App\Controllers\Chat;

use App\Controllers\BaseController;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Chat;


class Logic extends BaseController
{
    public function index(){
        // exit;
        if(!is_cli()){
            die("Not a shell");
        }
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );
    
        $server->run();
    }
    
}
