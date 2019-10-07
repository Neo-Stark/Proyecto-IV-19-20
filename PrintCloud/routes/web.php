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

use Dompdf\Dompdf;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/categories', 'CategoriesController@index');
$router->get('/categories/{id}', 'CategoriesController@getCategories');
$router->post('/categories', 'CategoriesController@createCategories');
$router->put('/categories/{id}', 'CategoriesController@updateCategories');
$router->delete('/categories/{id}', 'CategoriesController@destroyCategories');
$router->get('/pdf', function () use ($router) {

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($router->app->version());

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    // $dompdf->stream();
});
