<?php
    require_once './clases/persona.php';
    require_once './clases/alumno.php';
    require_once './funciones/functions.php';
    /*
    $_FILES['fichero_usuario'];
    var_dump($_FILES);
    $origen=$_FILES['fichero_usuario']['tmp_name'];
    $destino='miImagen.jpg';
    move_uploaded_file($origen,$destino);

    echo $_FILES['fichero_usuario']['type'];

    $extension=explode(".",$destino);
    var_dump($extension);
    
    $alumno=new Alumno($_POST['nombre'],$_POST['apellido'],$_POST['legajo'],$_FILES['imagen']['tmp_name']); 
    
    var_dump($alumno->MostrarDatos());
    */

    $pathjson= './alumnos.json';
    $archivoTmp= $_FILES['imagen']['tmp_name'];
    $extensionTmp = explode('/',$_FILES['imagen']['type']);
    $imagen = './temp/'. $_POST['legajo'] . '.'. $extensionTmp[1];

    switch ($_POST['opcion']){
        case 'alta':
            if($extensionTmp[0]!='image'){
                echo 'Debe ingresar una imagen valida';
                break;
            }
            $respuesta=move_uploaded_file($archivoTmp, $imagen);
            if($respuesta){
                $alumno= new alumno($_POST['nombre'],$_POST['apellido'],$_POST['legajo'],$imagen);
                if(Alta($alumno, $pathjson))
                    echo 'Alta exitosa';
            }
            break;
        
        case 'baja':
            $alumno=new alumno($_POST['nombre'],$_POST['apellido'],$_POST['legajo'],$imagen);
            if(Delete($alumno,$pathjson))
                echo 'Persona eliminada';
            else
                echo 'No existe esa persona';
            break;

        case 'modificacion':
            $alumno= new alumno($_POST['nombre'],$_POST['apellido'],$_POST['legajo'],$imagen);
            Modificar ($alumno,$pathjson);
            break;
            
        case 'backup':
            if($extensionTmp[0] != 'image'){
                echo 'Debe ingresar una imagen valida';
                break;
            }
            $respuesta= Backup($_POST['legajo'],$pathjson);
            if($respuesta && move_uploaded_file($archivoTmp,$imagen)){
                $alumno= new alumno($_POST['nombre'],$_POST['apellido'],$_POST['legajo'],$imagen);
                Modificar($alumno,$pathjson);
                echo 'Imagen modificada';
            }
            else{
                echo 'No se pudo modificar la imagen';
            }
            break;

        case 'mostrar':
            Show($pathjson);
            break;
        
        default:
            echo 'opcion invalida';
            break;
    }

?>
