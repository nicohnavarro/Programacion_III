<?php 
    class Get{

        // Devuelve una lista de usuarios con determinado nombre en formato Json.
        public static function GetVehiculoByPatente($data){
            Vehiculo::consultarVehiculo($data);
        }

        public static function GetTurnos(){
           return Turno::traerTurnos('./turnos.txt');
        }
        public static function GetServicio($data){
            Servicio::TraerServicio($data);
         }
    }
?>