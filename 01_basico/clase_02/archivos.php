<?php 
    class Archivos{

        public static function guardar($objeto)
        {
            $archivo=fopen('Personas.txt','a');
            fwrite($archivo,$objeto.','.PHP_EOL);
            echo 'Se guardo el archivo Personas'.PHP_EOL;
            fclose($archivo);
        }
    }

?>