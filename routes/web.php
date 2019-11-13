<?php

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

$router->get('/version', function () use ($router) {
    return $router->app->version();
});
$router->get('/', function () {
    return response()->json(['status' => 'OK']);

});
// $router->get('/pdf/{id}', 'ControllerPdf@ver');
$router->get('/getPdf/{id}', 'ControllerPdf@descargar');
$router->get('/documentos', function () {
    return response()->json(['1' => 'documento.pdf', '2' => 'prueba.pdf', '3' => 'lista.pdf']);
});

$router->post('/createPdf', 'ControllerPdf@createPdf');