<?php
    class Archivo
    {
        public static function guardarArchivoTemporal($archivo, $destino)
        {

            $origen= $archivo['archivo']->getClientFileName();
            $fecha= new DateTime();

            $extension = pathinfo($archivo['archivo']->getClientFileName(), PATHINFO_EXTENSION);
            $destino = $destino . 'archivo' . $fecha->getTimeStamp() . '.' . $extension;

            $archivo['archivo']->moveTo($destino);
            return $destino;
        }

        public static function leerArchivo($ruta)
        {
            $lista=array();
            if(file_exists($ruta))
            {
                $archivo=fopen($ruta,'r');
                while(!feof($archivo))
                {
                    $objeto= json_decode(fgets($archivo));
                    if($objeto!=null)
                        array_push($lista,$objeto);
                }
                fclose($archivo);
            }
            return $lista;
        }

        public static function guardarObjeto($ruta,$objeto)
        {
            $archivo = fopen($ruta, 'a');
            fwrite($archivo, json_encode($objeto). PHP_EOL);
            fclose($archivo);
        }

        public static function BorrarPersona($ruta, $nroLegajo)
        {
            
            if(file_exists($ruta))
            {
                $lista= Archivo::leerArchivo($ruta);

                if(count($lista)>1)
                {
                    for($i=0; $i< count($lista);$i++)
                    {
                        $objeto = $lista[$i];
                        if($objeto->legajo == $nroLegajo)
                        {
                            unlink($objeto->rutaFoto);
                            unset($objeto); // eliminamos elemento de la lista
                            array_values($lista); // indices correlativos
                            break;
                        }
                    }

                    unlink($ruta); // borro el archivo anterior

                    //Guardamos los datos de nuevo
                    foreach($lista as $objeto)
                    {
                        Archivo::guardarObjeto($ruta,$objeto);
                    }
                }
                else if($lista[0]->legajo == $nroLegajo)
                {
                    unlink($lista[0]->rutaFoto);
                    unlink($ruta);
                }
            }
            else
                echo "Archivo no encontrado <br>";
        }

        public static function modificarObjeto ($ruta,$elementoAModificar)
        {
            if(file_exists($ruta))
            {
                $lista=Archivo::leerArchivo($ruta);
                $fecha= new DateTime(); //TimeStamp para no repetir nombre
                for($i=0;$i<count($lista);$i++)
                {
                    $objeto=$lista[$i];
                    if($objeto->patente==$elementoAModificar->patente)
                    {
                        $extension = pathinfo($objeto->rutaFoto, PATHINFO_EXTENSION);
                        $nombreBackup= "./backupFotos/backup".$fecha->getTimestamp().'.'.$extension;
                        copy($objeto->rutaFoto, $nombreBackup);
                        unlink($objeto->rutaFoto);
                        $lista[$i]=$elementoAModificar;
                        break;
                    }
                }

                unlink($ruta);
                //Guardamos los datos de nuevo
                for($i=0;$i< count($lista);$i++)
                {
                    $objeto=$lista[$i];
                    Archivo::guardarObjeto($ruta,$objeto);
                }
            }
        }
    }
?>