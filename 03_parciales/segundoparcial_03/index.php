<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
include_once './API/MediaAPI.php';
include_once './API/TokenAPI.php';
include_once './API/VentaAPI.php';
include_once './Middleware/TokenMiddleware.php';
include_once './Middleware/ListadoMiddleware.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->group('/usuario',function()
{   
    $this->post('/login[/]', \TokenAPI::class . ':GenerarToken');  
    $this->get('[/]', \TokenAPI::class . ':ListaUsuarios')
    ->add(\TokenMiddleware::class . ':ValidarToken');  
});

$app->group('/media',function()
{   
    $this->get('[/]', \MediaAPI::class . ':TraerTodos')
        ->add(\ListadoMiddleware::class . ':ReducirLista');
    $this->post('/alta[/]', \MediaAPI::class . ':Cargar');
    $this->delete('/baja/{id}[/]', \MediaAPI::class . ':Borrar')
    ->add(\TokenMiddleware::class . ':ValidarDuenio')
    ->add(\TokenMiddleware::class . ':ValidarToken');  
});

$app->group('/venta',function()
{   
    $this->post('[/]', \VentaAPI::class . ':Cargar')    
    ->add(\TokenMiddleware::class . ':ValidarEmpleadoOEncargado')
    ->add(\TokenMiddleware::class . ':ValidarToken');  
    $this->post('/modificar[/]', \VentaAPI::class . ':Cambiar')
    ->add(\TokenMiddleware::class . ':ValidarEncargado')
    ->add(\TokenMiddleware::class . ':ValidarToken'); 
});



$app->run();