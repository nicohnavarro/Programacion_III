<?php    
    include_once "./entidades/vehiculo.php";
    include_once "./acciones/post.php";
    include_once "./acciones/get.php";
    include_once "./entidades/archivos.php";
    include_once "./entidades/servicio.php";
    include_once "./entidades/turnos.php";

    $solicitud = $_SERVER["REQUEST_METHOD"];    

    switch($solicitud){

        case "POST":     
            $caso = isset($_POST["caso"])?$_POST["caso"]:null;
       
            switch($caso){
                case "crearVehiculo":
                    echo Post::CrearVehiculo($_POST);
                    break;
                case "cargarTipoServicio":
                    echo Post::CargarTipoServicio($_POST);
                    break;
                case "sacarTurno":
                    echo Post::SacarTurno($_POST);
                    break;
                default:
                    echo "Error Post entidad.";
                    break;
            }
            break;


        case "GET":             
        $caso = isset($_GET["caso"])?$_GET["caso"]:null;

        switch($caso){
            case "consultarVehiculo":
                if(isset($_GET["consulta"])){                
                    echo Get::GetVehiculoByPatente($_GET["consulta"]);             
                }
                else{
                    echo "Error traerpatente";
                }
                break;
            case "turnos":
                if(file_exists('./turnos.txt'))
                    var_dump(Get::GetTurnos());
                else{
                    echo "Error traerpatente";
                }
                break;
            case "servicio":
                if(isset($_GET["consulta"])){                
                    echo Get::GetServicio($_GET["consulta"]);             
                }
                else{
                    echo "Error traerpatente";
                }
                break;       
            default:
                echo "Error Get entidad.";
                break;
        }                      
        break;
    default:
        echo "Defalut HTTP.";
        break;        
    }
?>