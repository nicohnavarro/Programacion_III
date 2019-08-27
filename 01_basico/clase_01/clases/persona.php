<?php
    class Persona{
        public $nombre;
        public $edad;

        public function __construct($nombre,$edad)
        {
            $this->nombre=$nombre;
            $this->edad=$edad;
        }

        public function Mostrar()
        {
             return json_encode($this);
        }
    }
?>