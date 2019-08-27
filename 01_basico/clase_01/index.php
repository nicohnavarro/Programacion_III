<?php
    require_once './clases/persona.php';
    require_once './clases/alumno.php';
    var_dump($_GET);

    
    $al=new Alumno($_GET["nombre"],$_GET["edad"]);
    $al->Mostrar();
    
?>