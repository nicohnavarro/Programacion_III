<?php
    class Persona{
        public $nombre;

        public function __construct($nombre)
        {
            $this->nombre=$nombre;
        }

        public function Saludar()
        {
            echo("hola soy $this->nombre");
        }
    }
?>