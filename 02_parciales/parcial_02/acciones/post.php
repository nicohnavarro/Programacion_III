<?php


    class Post{
        
        public static function CrearVehiculo($data){                                 
            return Vehiculo::GuardarVehiculo($data);
        }   
        
        public static function CargarTipoServicio($data){
            return Servicio::CargarTipoServicio($data);
        }

        public static function SacarTurno($data){
            return Turno::SacarTurno($data);
        }
    }

?>