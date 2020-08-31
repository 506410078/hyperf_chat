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

//Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\WebSocketController');
});
