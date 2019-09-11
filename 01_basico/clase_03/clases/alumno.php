<?php
    //require_once './clases/persona.php';

    class Alumno extends Persona{

        public function MostrarDatos(){
            return json_encode($this);
        }
    }
?>