<?php
include_once("Entidades/Venta.php");
include_once("Entidades/Foto.php");

class VentaAPI extends Venta{
    public function Cargar($request, $response, $args){
        $parametros = $request->getParsedBody();
        $id_media = $parametros["id_media"];
        $nombreCliente = $parametros["nombreCliente"];
 
        Venta::Insertar($id_media,$nombreCliente);
        $respuesta = "Venta exitosa.";
        $newResponse = $response->withJson($respuesta,200);
        return $newResponse;
    }

    public function Cambiar($request, $response, $args){
        $parametros = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $id_venta = $parametros["id_venta"];
        $id_media = $parametros["id_media"];
        $nombreCliente = $parametros["nombreCliente"];
        $fecha = $parametros["fecha"];
        $importe = $parametros["importe"];
        $foto = $files["foto"];

        $ext = Foto::ObtenerExtension($foto);
        if($ext != "ERROR"){
            //Genero el nombre de la foto.
            $nombreFoto = $id_media."_".$nombreCliente."_".$fecha.$ext;  

            //Guardo la foto.
            $rutaFoto = "./Fotos/FotosVentas/".$nombreFoto;
            Foto::GuardarFoto($foto,$rutaFoto);
    
            $respuesta = "Modificado Correctamente.";
            Venta::Modificar($id_venta,$nombreCliente,$id_media,$fecha,$importe,$foto);
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }
        else{
            $respuesta = "Ocurrio un error.";
            $newResponse = $response->withJson($respuesta,200);
            return $newResponse;
        }

        //$parametros = json_decode($args["param"]);
    }
}


?>