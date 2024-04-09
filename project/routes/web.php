<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/users/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
$router->post('/api/users/register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);
$router->get('/api/lottery_games', ['as' => 'lottery.matches', 'uses' => 'LotteryController@games']);
$router->get('/api/lottery_game_matchs', ['as' => 'lottery.match', 'uses' => 'LotteryController@show']);

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->post('/api/lottery_game_match_users', ['as' => 'lottery.add.user','uses' => 'LotteryController@addUser']);
    $router->put('/api/users/{id}', [ 'as' => 'user.update',  'uses' => 'UserController@update']);
    $router->put('/api/users/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);

    $router->group(['middleware' => 'is.admin'], function () use ($router) {
        $router->post('/api/lottery_game_matchs', ['as' => 'lottery.add.match', 'uses' => 'LotteryController@create']);
        $router->put('/api/lottery_game_matchs', ['as' => 'lottery.end.match', 'uses' => 'LotteryController@update']);
        $router->get('/api/users', ['as' => 'users.all', 'uses' => 'UserController@index']);
});

});
