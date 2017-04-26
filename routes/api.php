<?php
/**
 * É importante definir um alias para a rota, para caso seja necessário
 * retornar uma URL para uma rota ou manipular a roda de alguma forma.
 */
$api = $app->make(Dingo\Api\Routing\Router::class);

$api->version('v1.0', function ($api) {
    $api->get('/', [
        'uses' => 'App\Http\Controllers\APIController@getIndex',
        'as' => 'api.index'
    ]);

    $api->post('/login', [
        'as' => 'api.user.login',
        'uses' => 'App\Http\Controllers\Auth\UserController@login',
    ]);

    $api->post('/user/register', [
        'uses' => 'App\Http\Controllers\Auth\UserController@register',
        'as' => 'api.user.register'
    ]);

    $api->group([
        'middleware' => 'api.auth',
    ], function ($api) {
        $api->get('/users', [
            'uses' => 'App\Http\Controllers\Auth\UserController@users',
            'as' => 'api.user.index'
        ]);
        $api->get('/user/{id}', [
            'uses' => 'App\Http\Controllers\Auth\UserController@getUser',
            'as' => 'api.user.item'
        ]);
        $api->get('/me', [
            'uses' => 'App\Http\Controllers\Auth\UserController@authenticatedUser',
            'as' => 'api.user.me'
        ]);
        $api->patch('/user/refresh', [
            'uses' => 'App\Http\Controllers\Auth\UserController@refresh',
            'as' => 'api.user.refresh'
        ]);
        $api->delete('/user/invalidate', [
            'uses' => 'App\Http\Controllers\Auth\UserController@deleteInvalidate',
            'as' => 'api.user.invalidate'
        ]);
        $api->delete('/user/delete/{id}', [
            'uses' => 'App\Http\Controllers\Auth\UserController@deleteUser',
            'as' => 'api.user.delete'
        ]);
    });
});