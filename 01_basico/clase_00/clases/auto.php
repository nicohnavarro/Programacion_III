<?php
    class Auto {
        private $_color;
        private $_precio;
        private $_marca;
        private $_fecha;

        public function __construct($_marca,$_color,$_precio,$_fecha)
        {
            $this->_marca=$_marca;
            $this->_color=$_color;
        }
    }
?>