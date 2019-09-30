<?php
//REMEMBER BEFORE TRYING composer require slim/slim "^3.0"
//TO load folder vendor
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require_once "./entities/archivos.php";
require_once "./entities/vehiculoApi.php";         


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);
//Hasta ACA Siempre
/*
$app->get('[/parametros/{id}]', function (Request $request,Response $response, $args){
    $id=$args['id'];
    $response->getBody()->write("GET => Bienvenido!!!, a SlimFramework parametro id: $id ");
    return $response;
});

$app->post('[/]', function (Request $request,Response $response){
    $response->getBody()->write("POST => Bienvenido!!!, a SlimFramework");
    return $response;
});*/

$app->group('',function()
{
    //Cargar Vehiculo
    $this->post('/vehiculo',\VehiculoApi::class . ':cargarVehiculo');

    //Consultar Vehiculo
    $this->get('/vehiculo/{consulta}',\VehiculoApi::class . ':consultarVehiculo');

    //Guardar Servicio
    $this->post('/servicio', \VehiculoApi::class . ':cargarTipoServicio');

    //Sacar turno
    $this->get('/turnos/{patente}/{fecha}', \VehiculoApi::class . ':sacarTurno');
        
    //Mostrar turnos
    $this->get('/turnos', \VehiculoApi::class . ':mostrarTurnos');

    //Inscripciones
    $this->get('/inscripciones/{filtro}', \VehiculoApi::class . ':inscripciones');

    //Modificar Vehiculo
    $this->put('/modificarvehiculo',\VehiculoApi::class . ':modificarVehiculo');
    //Modificar Vehiculo
    $this->post('/modificarvehiculo/{patente}',\VehiculoApi::class . ':modificarVehiculo');

    $this->get('/vehiculos',\VehiculoApi::class . ':mostrarVehiculos');
});

$app->run();
