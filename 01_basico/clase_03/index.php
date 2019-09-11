<?php
    require_once './clases/persona.php';
    require_once './clases/alumno.php';
    /*
    $_FILES['fichero_usuario'];
    var_dump($_FILES);
    $origen=$_FILES['fichero_usuario']['tmp_name'];
    $destino='miImagen.jpg';
    move_uploaded_file($origen,$destino);

    echo $_FILES['fichero_usuario']['type'];

    $extension=explode(".",$destino);
    var_dump($extension);
    */
    $alumno=new Alumno($_POST['nombre'],$_POST['apellido'],$_POST['legajo'],$_FILES['imagen']['tmp_name']); 
    
    var_dump($alumno->MostrarDatos());
    
?>
