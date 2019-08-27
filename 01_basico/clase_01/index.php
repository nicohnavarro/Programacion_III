<?php
    require_once './clases/persona.php';
    require_once './clases/alumno.php';
    //var_dump($_GET);

    //$al=new Alumno($_GET["nombre"],$_GET["edad"]);
    //echo $al->Mostrar();
    
    $alumnos=array();
    $i=0;
    $cantidad=$_POST["cantidad"];
    echo $cantidad;
    while($i<(int)$cantidad){
        $alumno=new Alumno("nicolas",rand(18,26));
        $i++;
        array_push($alumnos,$alumno);
    }
    //var_dump($alumnos);
    echo json_encode($alumnos);

    

?>