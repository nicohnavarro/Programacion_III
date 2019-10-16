<?php
    class Turno
    {
        public $fecha;
        public $patente;
        public $precio;
        public $tipoServicio;
        public function __construct($fecha, $patente,$precio, $tipoServicio)
        {
            $this->fecha = $fecha;
            $this->patente = $patente;
            $this->precio = $precio;
            $this->tipoServicio = $tipoServicio;
            
        }
        public static function traerTurnos($ruta)
        {
            
            $listaServicios = Archivo::LeerArchivo($ruta);
            if($listaServicios == null)
            {
                $listaServicios = "Error al traer los datos";
            }
            return $listaServicios;
        }

        public static function SacarTurno($data)
        {
            $ruta='./turnos.txt';
            $rutaVehiculos='./vehiculos.txt';
            $rutaServicios='./tipoServicio.txt';
            $muestroVehiculo=false;
            $patente=$data['patente'];
            $fecha=$data['fecha'];
            $precio=$data['precio'];
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
                    $precio,
                    $listaServicios[0]->tipo
                );
                Archivo::guardarObjeto($ruta, $turno);
                Turno::traerTurnos($ruta);
            }

            echo $mensaje;
        }
    }
?>