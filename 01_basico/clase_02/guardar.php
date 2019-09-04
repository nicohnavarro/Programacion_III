<?php
    function guardar($objeto){
        $archivo=fopen('archivo.txt','a');
        fwrite($archivo,$objeto.','.PHP_EOL);
        echo 'Se guardo el archivo'.PHP_EOL;
        fclose($archivo);
    }


?>