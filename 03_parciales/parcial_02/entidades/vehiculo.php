<?php

    class Vehiculo
    {
        public $marca;
        public $patente;
        public $kilometros;
        public function __construct($marca, $patente, $kilometros)
        {
            $this->marca = $marca;
            $this->patente = $patente;
            $this->kilometros = $kilometros;
            
        }
        //Manejo la fuente de datos acá:
        public static function traerVehiculos($ruta)
        {
            $ruta = "./vehiculos.txt";
            
            $listaVehiculos = Archivo::leerArchivo($ruta);
            if($listaVehiculos == null)
            {
                $listaVehiculos = "Error al traer los datos";
            }
            return $listaVehiculos;
        }

        public static function GuardarVehiculo($data)
        {
            $ruta = "./vehiculos.txt";
            $vehiculo= new Vehiculo($data['marca'],$data['patente'],$data['kilometros']);
            if (file_exists($ruta)) {
                $listaVehiculos = Vehiculo::traerVehiculos($ruta);

                for ($i=0;$i<count($listaVehiculos);$i++) {
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
                echo $mensaje;
            } else {
                $mensaje='Vehiculo REPETIDO';
                echo $mensaje;
            }
        }

        public static function consultarVehiculo($consulta)
        {
            $ruta='./vehiculos.txt';
            $muestroVehiculo= false;
            $encontro= false;
            $miVehiculo=array();
            $listaVehiculos=Vehiculo::traerVehiculos($ruta);
            foreach ($listaVehiculos as $auxVehiculo) {
                if ($auxVehiculo->marca == $consulta || $auxVehiculo->patente==$consulta) {
                    $muestroVehiculo=true;
                }
                if ($muestroVehiculo) {
                    $encontro=true;
                    array_push($miVehiculo,$auxVehiculo);
                }
                $muestroVehiculo=false;
            }
            if (!$encontro) {
                $miVehiculo="No encontro $consulta";
            }
            
            var_dump($miVehiculo);
        }
    }
?>