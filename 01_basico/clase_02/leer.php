<?php
    function leer(){
        $archivo=fopen('archivo.txt','r');
        $lectura=fread($archivo,filesize('archivo.txt'));
        fclose($archivo);

        return $lectura;
    }

    function leermejorado(){
        $archivo=fopen('archivo.txt','r');
        $arraylectura=array();
        while(!feof($archivo)){
            $linea=fgets($archivo);
            array_push($arraylectura,$linea);
            //echo fgets($archivo),'<br>';
        }
        fclose($archivo);
        return $arraylectura;
    }
?>