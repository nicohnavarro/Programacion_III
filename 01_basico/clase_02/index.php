<?php
    require_once './guardar.php';
    require_once './leer.php';
    require_once './archivos.php';
    //$objeto=array();
    //array_push($objeto,"Nicolas");
    //$obj=new stdClass();
    //$obj->nombre=$_GET['nombre'];
    //$obj->edad=$_GET['edad'];
    //$informacion=array($_GET['nombre']=>$_GET['edad']);
    //echo json_encode($informacion);
    
    //guardar( json_encode($obj));
    //echo leer();
    //$json= "[".leer()."]";
    //var_dump(json_decode($json));
    //$lectura=leermejorado();
    //var_dump($lectura);
    //leermejorado();

    $obj=new stdClass();
    $obj->nombre=$_POST['nombre'];
    $obj->apellido=$_POST['apellido'];
    echo $obj->nombre . "<br>";
    archivos::guardar(json_encode($obj));

?>