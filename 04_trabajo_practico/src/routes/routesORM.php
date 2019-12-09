<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioController;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/usuarioController.php';
include_once __DIR__ . '/../../src/middleware/middlewareRoutes.php';

return function (App $app) {
    $container = $app->getContainer();

      $app->group('/usuarios',function(){

        $this->get('/',function($req,$res,$args){
          $newResponse = $res->withJson('bienvenidos a la comanda',200);
          return $newResponse;
        });
        

        $this->post('/cargarUsuario',usuarioController::class . ':CargarUsuario')->add(Middleware::class . ':ValidarAdmin'); //Administrador
      })->add(Middleware::class . ':ValidarRuta');

      

      $app->post('/login',usuarioController::class . ':UsuarioLogin');

};