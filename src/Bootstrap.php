<?php
namespace Yapf;
use Yapf\Route;
use Yapf\Request;

class Bootstrap{
    public function run():void{
        $request = Request::getInstance();
        $uri = $request->getServerVar('request_uri');
        $uri = explode('?',$uri);

        $route = Route::getInstance();
        $action = $route->findEntry($uri[0]);
        $class = $action[0];
        $method = $action[1];
        call_user_func(array(new $class,$method));
    }
}
