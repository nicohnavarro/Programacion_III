<?php
    class Persona{
        public $nombre;

        public function __construct($nombre,$edad)
        {
            $this->nombre=$nombre;
            $this->edad=$edad;
        }

        public function Mostrar()
        {
            echo $this->nombre;
            echo $this->edad;
        }
    }
?>