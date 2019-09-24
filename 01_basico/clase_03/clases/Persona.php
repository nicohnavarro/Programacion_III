<?php
    class Persona{
        public $nombre;
        public $apellido;
        public $legajo;
        public $imagen;

        public function __construct($nombre,$apellido,$legajo,$imagen)
        {
            $this->nombre=$nombre;
            $this->apellido=$apellido;
            $this->legajo=$legajo;
            $this->imagen=$imagen;

            //$origen=$imagen;
            //$destino='./usuarios/'.$apellido.$legajo.'.jpg';
            //move_uploaded_file($origen,$destino);
        }

    }
?>