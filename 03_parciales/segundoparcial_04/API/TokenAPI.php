<?php
include_once("Entidades/Token.php");
include_once("Entidades/Usuario.php");

class TokenApi extends Token{
    public function GenerarToken($request, $response, $args){
        $parametros = $request->getParsedBody();
        $user = $parametros["nombre"];
        $password  = $parametros["clave"];
        $usuario = Usuario::Login($user,$password)[0];
        if($usuario->tipo_usuario != ""){
            $token = Token::CodificarToken($user,$usuario->tipo_usuario,$usuario->id);
            $respuesta = array("Estado" => "OK", "Mensaje" => "OK", "Token" => $token);
            
        }
        else{
            $respuesta = array("Estado" => "ERROR", "Mensaje" => "Usuario o clave invalidos.");
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    public function CrearUsuario($request, $response, $args){
        $parametros = $request->getParsedBody();
        $user = $parametros["nombre"];
        $password  = $parametros["clave"];
        $nivel = $parametros["nivel"];

        Usuario::Insertar($user,$password,$nivel);
        $respuesta = "Insertado Correctamente.";
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}