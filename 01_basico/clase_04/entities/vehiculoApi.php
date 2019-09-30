<?php
    require_once './entities/vehiculo.php';
    require_once './entities/IApiUsable.php';
    require_once './entities/archivos.php';
    require_once './entities/turno.php';
    require_once './entities/servicio.php';

    class VehiculoApi
    {
        public function __construct()
        {
        }

        public static function consultarVehiculo($request, $response, $args)
        {
            $ruta='./vehiculos.txt';
            $muestroVehiculo= false;
            $encontro= false;
            $consulta= strtolower($args['consulta']);
            $datos=array();
            $listaVehiculos=Vehiculo::traerVehiculos($ruta);
            //var_dump($listaVehiculos);
            //echo $consulta;
            foreach ($listaVehiculos as $auxVehiculo) {
                if ($auxVehiculo->marca == $consulta || $auxVehiculo->modelo== $consulta || $auxVehiculo->patente==$consulta) {
                    $muestroVehiculo=true;
                }
                if ($muestroVehiculo) {
                    $encontro=true;
                    array_push($datos, $auxVehiculo);
                }
                $muestroVehiculo=false;
            }
            if (!$encontro) {
                $datos="No encontro $consulta";
            }
            
            $newresponse=$response->withJson($datos, 200); //Codigo de respuesta
            return $newresponse; //Devolver siempre Json
        }

        public static function cargarVehiculo($request, $response) //No paso args porque los tomo del body por POST
        {
            $ruta='./vehiculos.txt';
            $vehiculoRepetido=false;
            $mensaje='Error';
            $args= $request->getParsedBody();

            $vehiculo= new Vehiculo(
                strtolower($args['marca']),
                strtolower($args['modelo']),
                strtolower($args['patente']),
                strtolower($args['precio'])
            );

            if (file_exists($ruta)) {
                $listaVehiculos = Vehiculo::traerVehiculos($ruta);
                /*
                foreach ($listaVehiculos as $auxVehiculo) {
                    if ($auxVehiculo->patente == $vehiculo->patente) {
                        $vehiculoRepetido=true;
                    }
                }
                */

                for ($i=0;$i<count($listaVehiculos);$i++) {
                    //echo "patente:" .$listaVehiculos[$i]->patente . "<br>";
                    if ($listaVehiculos[$i]!=null) {
                        if ($listaVehiculos[$i]->patente == $vehiculo->patente) {
                            $vehiculoRepetido=true;
                        }
                    }
                }
            }
            if (!$vehiculoRepetido) {
                Archivo::guardarObjeto($ruta, $vehiculo);
                $mensaje='Vehiculo Guardado';
            } else {
                $mensaje='Vehiculo REPETIDO';
            }

            return $response->getBody()->write($mensaje);
        }

        public static function cargarTipoServicio($request, $response) //NO paso Args
        {
            $ruta='./tipoServicio.txt';
            $args=$request->getParsedBody();
            //comprobar que el tipo sea correcto
            $servicio = new Servicio(
                strtolower($args['id']),
                strtolower($args['tipo']),
                strtolower($args['precio']),
                strtolower($args['demora'])
            );
            //ver id repetido
            //code...

            Archivo::guardarObjeto($ruta, $servicio);
            $listaServicios= Servicio::traerServicios($ruta);
            $newresponse= $response->withJson($listaServicios, 200);
            return $newresponse;
        }

        public static function sacarTurno($request, $response, $args)
        {
            $ruta='./turnos.txt';
            $rutaVehiculos='./vehiculos.txt';
            $rutaServicios='./tipoServicio.txt';
            $muestroVehiculo=false;
            $patente=strtolower($args['patente']);
            $fecha=strtolower($args['fecha']);
            $datos=array();
            $vehiculo=null;
            $mensaje='error';

            $listaServicios= Servicio::traerServicios($rutaServicios);
            if (file_exists($rutaVehiculos)) {
                $listaVehiculos= Vehiculo::traerVehiculos($rutaVehiculos);
                foreach ($listaVehiculos as $auxVehiculo) {
                    if ($auxVehiculo->patente==$patente) {
                        $vehiculo=$auxVehiculo;
                        $mensaje='Encontrado!';
                        break;
                    }
                }
                if ($vehiculo==null) {
                    $mensaje='No se encontro vehiculo con patente '.$patente;
                }
            }

            if ($vehiculo!=null) {
                $turno=new Turno(
                    $fecha,
                    $patente,
                    $vehiculo->marca,
                    $vehiculo->modelo,
                    $listaVehiculos[0]->precio,
                    $listaServicios[0]->tipo
                );
                Archivo::guardarObjeto($ruta, $turno);
                Turno::traerTurnos($ruta);
            }

            $newresponse=$response->getBody()->write($mensaje);
        }

        public static function mostrarTurnos($request, $response, $args)
        {
            $ruta='./turnos.txt';
            $listaTurnos=Turno::traerTurnos($ruta);
            $newresponse= $response->withJson($listaTurnos, 200);
            return $newresponse;
        }

        public static function inscripciones($request, $response, $args)
        {
            $ruta='./turnos.txt';
            $listaTurnos= Turno::traerTurnos($ruta);

            $newresponse=$response->withJson($listaTurnos, 200);
            return $newresponse;
        }

        public static function modificarVehiculo($request, $response, $args)
        {
            $destino='./images/';
            $rutaVehiculos='./vehiculos.txt';
            $archivo= $request->getUploadedFiles();
            //var_dump($archivo);
            $nombreAnterior=$archivo['foto']->getClientFilename();
            $patente=$args['patente'];
            $args=$request->getParsedBody();
            $marca=$args['marca'];
            $precio=$args['precio'];
            $modelo=$args['modelo'];
            $fecha=new DateTime('today');
            $vehiculoAmodificar=null;
            $listaVehiculos= Vehiculo::traerVehiculos($rutaVehiculos);

            

            foreach ($listaVehiculos as $auxVehiculo) {
                echo  "aux".$auxVehiculo->patente."<br>";
                if ($auxVehiculo->patente==$patente) {
                    $vehiculoAmodificar=$auxVehiculo;
                    unset($auxVehiculo);
                    break;
                }
            }
            if ($vehiculoAmodificar!=null) {
                $vehiculoAmodificar->marca=$marca;
                $vehiculoAmodificar->precio=$precio;
                $vehiculoAmodificar->modelo=$modelo;
                
                if ($vehiculoAmodificar->imagen==null) {
                    $extension=explode('.', $nombreAnterior);
                    //var_dump($nombreAnterior);
                    $extension=array_reverse($extension);
                    $archivo['foto']->moveTo($destino.$patente.'-'.$fecha->format('Y-m-d').'.'.$extension[0]);
                    $response->getBody()->write("Nueva foto<br>");
                    $vehiculoAmodificar->imagen=$archivo['foto'];
                    var_dump($vehiculoAmodificar);
                } else {
                    $extension=explode('.', $nombreAnterior);
                    //var_dump($nombreAnterior);
                    $extension=array_reverse($extension);
                    //$vehiculoAmodificar->imagen->moveTo('./temp/'.$fecha->format('Y-m.d').'.'.$extension[0]);
                    copy($destino.$patente.'-'.$fecha->format('Y-m-d').'.'.$extension[0],'./temp/'.$patente.'-'.$fecha->format('Y-m-d').'.'.$extension[0]);
                    $archivo['foto']->moveTo($destino.$patente.'-'.$fecha->format('Y-m-d').'.'.$extension[0]);
                    $response->getBody()->write("Modificada foto");
                }
            }
            var_dump($vehiculoAmodificar);
            //array_push($listaVehiculos, $vehiculoAmodificar);
            unlink($rutaVehiculos);
            //Guardamos los datos de nuevo
            for ($i=0;$i< count($listaVehiculos);$i++) {
                $objeto=$listaVehiculos[$i];
                Archivo::guardarObjeto($rutaVehiculos, $objeto);
            }
        }

        public static function mostrarVehiculos($request, $response, $args)
        {
            $ruta='./vehiculos.txt';
            $listaVehiculos=Vehiculo::traerVehiculos($ruta);
            $newresponse= $response->withJson($listaVehiculos, 200);
            return $newresponse;
        }
    }
