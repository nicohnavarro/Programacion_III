<?php
    class Servicio
    {
        public $id;
        public $tipo;
        public $precio;
        public $demora;

        public function __construct ($id,$tipo,$precio,$demora)
        {
            $this->id=$id;
            $this->tipo=$tipo;
            $this->precio=$precio;
            $this->demora=$demora;
        }

        public static function traerServicios($ruta)
        {
            $listaServicios=Archivo::leerArchivo($ruta);
            if($listaServicios==null)
                $listaServicios="Error al traer los datos";
            return $listaServicios;
        }

        public static function CargarTipoServicio($data)
        {
            $ruta='./tipoServicio.txt';
            $servicio = new Servicio($data['id'],$data['tipo'],$data['precio'],$data['demora']);

            Archivo::guardarObjeto($ruta, $servicio);
            $listaServicios= Servicio::traerServicios($ruta);
            echo "Servicio Cargado";
        }

        public static function TraerServicio($data)
        {
            $ruta='./turnos.txt';
            $rutaServicios='./tipoServicio.txt';
            $tipoServicio=$data;
            $fecha=$data;
            $datos=array();
            $mensaje='error';
            $miTurno='error';
            if (file_exists($ruta)) {
                $listaTurnos= Turno::traerTurnos($ruta);
                foreach ($listaTurnos as $auxTurnos) {
                    if ($auxTurnos->fecha==$fecha  || $auxTurnos->tipoServicio==$tipoServicio) {
                        $miTurno=$auxTurnos;
                        $mensaje='Encontrado!';
                        array_push($datos,$auxTurnos);
                        break;
                    }
                }
                if ($miTurno==null) {
                    $mensaje='No se encontro turno con '.$data;
                }
            }

            if(true)
            {
                var_dump($datos);
            }
            echo $mensaje;
        }
    }
?>