<?php
    class ListadoMiddleware{
        public static function ReducirLista($request,$response,$next){
            $respuesta = $next($request,$response);
            $json = $respuesta->getBody()->__toString();
            $array = json_decode($json);
            foreach($array as $media){
                foreach($media as $key => $value )
                {
                    unset($media->id);
                    unset($media->precio);
                }
            }
            $newResponse = $response->withJson($array,200);
            return $newResponse;
        }
    }
?>