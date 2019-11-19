<?php
include_once("Entidades/Media.php");
include_once("Entidades/Foto.php");

class MediaAPI extends Media{
    public function TraerTodos($request, $response, $args){
        $todos = Media::ConsultarTodos();
        $newResponse = $response->withJson($todos, 200);
        return $newResponse;
    }

    public function Cargar($request, $response, $args){
        $parametros = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $color = $parametros["color"];
        $marca = $parametros["marca"];
        $precio = $parametros["precio"];
        $talle = $parametros["talle"];
        $foto = $files["foto"];
 
        //Consigo la extensión de la foto.  
        $ext = Foto::ObtenerExtension($foto);
        if($ext != "ERROR"){
            //Genero el nombre de la foto.
            $nombreFoto = $marca."_".$color."_".$talle.$ext;  

            //Guardo la foto.
            $rutaFoto = "./Fotos/FotoMedias/".$nombreFoto;
            Foto::GuardarFoto($foto,$rutaFoto);
    
            $respuesta = "Insertado Correctamente.";
            Media::Insertar($color,$marca,$precio,$talle,$nombreFoto);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }
        else{
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }        
    }

    public function Borrar($request, $response, $args){
        $id = $args["id"];
        $cantEliminados = Media::Eliminar($id);
        if($cantEliminados == 0){
            $respuesta = "ERROR: No se encontraron coincidencias para eliminar.";
        }
        else{
            $respuesta = "Eliminado correctamente.";
        }
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }
}


?>