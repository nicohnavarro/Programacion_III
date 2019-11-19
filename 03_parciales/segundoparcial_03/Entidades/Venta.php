<?php
    include_once("DB/AccesoDatos.php");
    include_once("Entidades/Media.php");
    class Venta{
        public static function Insertar($id_media,$nombreCliente)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();            

            $consultaMedia = $objetoAccesoDato->RetornarConsulta("SELECT * FROM media WHERE id = :id_media");
            $consultaMedia->bindValue(':id_media', $id_media, PDO::PARAM_INT);
            $consultaMedia->execute();
            $media = $consultaMedia->fetchAll(PDO::FETCH_CLASS,"Media");
            $precio = $media[0]->precio;
            $foto = $media[0]->foto;
            $fechaActual = new DateTime("now");
            $fechaActualString = $fechaActual->format('Y-m-d');

            $ext = array_reverse(explode(".",$foto));
            $nuevoNombreFoto = $id_media."_".$nombreCliente."_".$fechaActualString.".".$ext[0];

            //Hago una copia de la foto en la carpeta de fotos ventas. 
            copy("./Fotos/FotoMedias/$foto","./Fotos/FotosVentas/$nuevoNombreFoto");            
            
            $consultaVenta = $objetoAccesoDato->RetornarConsulta("INSERT INTO venta_media (id_media, nombreCliente, fecha, importe, foto)
                                                            VALUES(:id_media, :nombreCliente, :fecha, :precio, :foto)");
            
            $consultaVenta->bindValue(':nombreCliente', $nombreCliente, PDO::PARAM_STR);
            $consultaVenta->bindValue(':id_media', $id_media, PDO::PARAM_INT);
            $consultaVenta->bindValue(':fecha', $fechaActualString, PDO::PARAM_STR);
            $consultaVenta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consultaVenta->bindValue(':foto', $foto, PDO::PARAM_STR);

            $consultaVenta->execute();   
        }
        
        public static function Modificar($id_venta, $nombreCliente, $id_media, $fecha, $importe,$foto)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consultaVenta = $objetoAccesoDato->RetornarConsulta("SELECT foto FROM venta_media WHERE id_venta = :id_venta");
            $consultaVenta->bindValue(':id_venta', $id_venta, PDO::PARAM_INT);
            $consultaVenta->execute();
            $foto = $consultaVenta->fetch()["foto"];

            //Hago una copia de la foto en la carpeta de backup. 
            copy("./Fotos/FotosVentas/$foto","./Fotos/FotosVentas/Backup/$foto");
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE venta_media SET nombreCliente = :nombreCliente, id_media = :id_media, 
                                                            fecha = :fecha, importe = :importe, foto = :foto WHERE id_venta = :id_venta");
            
            $consulta->bindValue(':id_venta', $id_venta, PDO::PARAM_INT);
            $consulta->bindValue(':nombreCliente', $nombreCliente, PDO::PARAM_STR);
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $consulta->bindValue(':importe', $importe, PDO::PARAM_INT);
            $consulta->bindValue(':id_media', $id_media, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);

            return $consulta->execute();
        }

    }
?>