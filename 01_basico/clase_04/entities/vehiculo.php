<?php

    class Vehiculo
    {
        public $marca;
        public $modelo;
        public $patente;
        public $precio;
        public $imagen;
        public function __construct($marca, $modelo, $patente, $precio)
        {
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->patente = $patente;
            $this->precio = $precio;
            $this->imagen=null;
            
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
    }
?>