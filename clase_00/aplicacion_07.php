<?php
    $fecha=date("m");

    echo "$fecha <br/> ";

    if($fecha<3 || $fecha ==12)
    {
        echo "Es Verano";
    }
    else if ($fecha<9 ||$fecha >=6)
    {
        echo "Es Invierno";
    }
?>