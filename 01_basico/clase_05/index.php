<?php
//REMEMBER BEFORE TRYING 
// composer require slim/slim "^3.0"
//composer require firebase/php-jwt
//TO load folder vendor
//https://github.com/firebase/php-jwt
require_once "./middleware.php";
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';    
use \Firebase\JWT\JWT;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('[/login]', function (Request $request,Response $response){
    $args= $request->getParsedBody();

    $key = "login";
    $token = array(
        "usuario" => $args['usuario'],
        "pass" => $args['pass'],
        "iat" => 1356999524,
        "nbf" => 1357000000 
    );
    $jwt = JWT::encode($token, $key);
    $response->getBody()->write($jwt);

    $decoded = JWT::decode($jwt, $key, array('HS256'));
    print_r($decoded);

    $decoded_array = (array) $decoded;

    JWT::$leeway = 60; // $leeway in seconds
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    return $response;
});

$app->get('[/usuario]', function (Request $request,Response $response, $args){
    $args = $request->getHeaders();
    $token=$args["HTTP_TOKEN"][0];
    $key = "login";
    
    

    $response->getBody()->write($token);
    return $response;
});

$app->run();
?>