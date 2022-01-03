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
    return ["Hello Hai..!!!"];
});

$router->post('cari_pengajian', 'PengajianController@index');
$router->post('daftar_pengajian', 'PengajianController@detail');

$router->get('/pengajian', function () use ($router) {
    $results = app('db')->select("SELECT * FROM pengajian INNER JOIN masjid ON pengajian.id_masjid=masjid.id_masjid");
    return response()->json($results);
});

$router->get('/profil', function () use ($router) {
    $results = app('db')->select("SELECT * FROM users");
    return response()->json($results);
});

// $router->get('/profil/detail', function () use ($router) {
//     $results = app('db')->select("SELECT * FROM users");
//     return response()->json($results);
// });

$router->post('register', 'UserController@register');
$router->post('login','AuthController@login');
$router->put('update-user/{id}','AuthController@update');

// $router->get('/profil','UserController@getUser');
// $router->post('/profil/detail','UserController@getUser');

$router->group(['middleware' => 'auth'], function() use ($router){
    $router->post('/logout', 'AuthController@logout');
});
