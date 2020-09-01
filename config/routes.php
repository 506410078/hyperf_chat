<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

//Router::get('/get', 'App\Controller\IndexController::index');
//Router::get('/get', 'App\Controller\IndexController@get');
//Router::get('/get', [\App\Controller\IndexController::class, 'get']);

Router::addGroup('/index/',function(){
    Router::addRoute(['GET'],'index','App\Controller\IndexController@index');
    Router::addRoute(['GET'],'en','App\Controller\IndexController@en');
});
Router::addGroup('/en/',function(){
    Router::addRoute(['GET','POST'],'index/{id}/[{name}]','App\Controller\EncryptController@index');
});

Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\WebSocketController');
});
