<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioApi;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/usuarioControler.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/usuarioORM', function () {   
        $this->post('/usuarios', usuarioControler::class . ':CargarUno');

        $this->get('/', function ($request, $response, $args) {
          //return cd::all()->toJson();
          //$todosLosCds=cd::all();
          $newResponse = $response->withJson($todosLosCds, 200);  
          return $newResponse;
        });
    });


     $app->group('/cdORM2', function () {   

        $this->get('/',cdApi::class . ':traerTodos');
   
    });

};