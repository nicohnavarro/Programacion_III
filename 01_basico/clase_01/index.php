<?php

    require_once './clases/persona.php';
    require_once './clases/alumno.php';
    require_once './clases/alumnoDAO.php';
    //var_dump($_GET);

    //$al=new Alumno($_GET["nombre"],$_GET["edad"]);
    //echo $al->Mostrar();
    
    /*
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
    */


    /*
    if (!isset($_SESSION['alumnos']))
    {
        //var_dump($alumnos);
        $alumnos=array();
        $_SESSION['alumnos']=$alumnos;
    }
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $alumno=new Alumno($_POST['nombre'],$_POST['edad']);
        array_push($_SESSION['alumnos'],$alumno);
        //echo json_encode($_SESSION['alumnos']);
    }
    if($_SERVER['REQUEST_METHOD']=='GET')
    {
        echo json_encode($_SESSION['alumnos']);
        session_unset();
    }
    */
    

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $alumno=new Alumno($_POST['nombre'],$_POST['edad']);
        Guardar($alumno);
    }
    if($_SERVER['REQUEST_METHOD']=='GET')
    {
        TraerListado();
        session_unset();
    }

    

?>