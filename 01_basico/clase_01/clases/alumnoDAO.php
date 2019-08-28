<?php

    session_start();
    if (!isset($_SESSION['alumnos']))
    {
        //var_dump($alumnos);
        $alumnos=array();
        $_SESSION['alumnos']=$alumnos;
    }

    function TraerListado()
    {
        echo json_encode($_SESSION['alumnos']);
    }

    function Guardar($alumno)
    {    
        array_push($_SESSION['alumnos'],$alumno);
        echo json_encode($_SESSION['alumnos']);
    }
?>