<?php
    class TokenMiddleware{
        public static function ValidarToken($request,$response,$next){
            $token = $request->getHeader("token");
            $validacionToken = Token::DecodificarToken($token[0]);
            if($validacionToken["Estado"] == "OK"){
                $request = $request->withAttribute("payload", $validacionToken);
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson($validacionToken,200);
                return $newResponse;
            }
        }

        public static function ValidarDuenio($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];

            if($payload->tipoUser->tipo_usuario == "Dueño"){
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson("ERROR: No tienes permiso para realizar esta accion (Solo categoria duenio).",200);
                return $newResponse;
            }
        }

        public static function ValidarEncargado($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];
            
            if($payload->tipoUser->tipo_usuario == "Encargado"){
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson("ERROR: No tienes permiso para realizar esta accion (Solo categoria encargado).",200);
                return $newResponse;
            }
        }

        public static function ValidarEmpleadoOEncargado($request,$response,$next){
            $payload = $request->getAttribute("payload")["Payload"];
            
            if($payload->tipoUser->tipo_usuario == "Empleado" || $payload->tipoUser->tipo_usuario == "Encargado"){
                return $next($request,$response);
            }
            else{
                $newResponse = $response->withJson("ERROR: No tienes permiso para realizar esta accion (Solo categoria empleado o encargado).",200);
                return $newResponse;
            }
        }
    }
?>