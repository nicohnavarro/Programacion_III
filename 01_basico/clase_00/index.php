<?php
    echo "PARTE 1";
    echo "<br/>";
    echo "Aplicacion 1";
    echo "<br/>";
    $nombre="Juan";
    $apellido="Perez";
    print("Hola $apellido $nombre");
    echo "<br/><br/>";

    echo "Aplicacion 2";
    echo "<br/>";
    $x=3;
    $y=5;
    echo $x+$y;
    echo "<br/><br/>";

    echo "Aplicacion 3";
    echo "<br/>";
    $x=-3;
    $y=15;
    $z=$x+$y;
    print("$x <br/>+ $y<br/> $z");
    echo "<br/><br/>";

    echo "Aplicacion 4";
    echo "<br/>";
    $numero=1;
    $contador=0;
    do {
        $numero++;
        $contador++;
    } while ($numero<1000);

    print("$numero  cantidad : $contador");
    echo "<br/><br/>";

    echo "Aplicacion 5";
    echo "<br/>";
    echo "<br/><br/>";

    echo "Aplicacion 6";
    echo "<br/>";
    $operador='+';
    $op1=3;
    $op2=6;
    $resultado;
    switch ($operador) {
        case '+':
            $resultado= $op1+$op2;
            break;
        case '-':
            $resultado= $op1-$op2;
            break;
        case '*':
            $resultado= $op1*$op2;
            break;
        case '/':
            $resultado= $op1/$op2;
            break;
    }

    echo $resultado;
    echo "<br/><br/>";

    echo "Aplicacion 7";
    echo "<br/>";
    $fecha=date("m");

    echo "$fecha <br/> ";

    if ($fecha<3 || $fecha ==12) {
        echo "Es Verano";
    } elseif ($fecha<9 ||$fecha >=6) {
        echo "Es Invierno";
    }
    echo "<br/><br/>";

    echo "Aplicacion 8";
    echo "<br/>";
    $nombreNumero=array("Cero","Uno","Dos");
    foreach ($nombreNumero as $value) {
        # code...
        echo "$value <br/>";
    }
    echo "<br/><br/>";

    echo "PARTE 2";
    echo "<br/>";
    echo "Aplicacion 9";
    echo "<br/>";
    $miArray=array(
        0=> rand(0, 50),
        1=>rand(0, 50),
        2=>rand(0, 50),
        3=>rand(0, 50),
        4=>rand(0, 50)
    );
    $miAcumulador=0;
    foreach ($miArray as $value) {
        # code...
        $miAcumulador+=$value;
        print("$value <br/>");
    }
    $miPromedio=$miAcumulador/5;
    echo $miPromedio;
    echo "<br/><br/>";

    echo "Aplicacion 10";
    echo "<br/>";
    $numero=0;
    $arrayImpares[]=array();

    while (true) {
        if ($numero % 2!=0) {
            $arrayImpares[]=$numero;
        }
        if (count($arrayImpares)==10) {
            break;
        }
        $numero++;
    }
    for ($i=0;$i<count($arrayImpares);$i++) {
        echo $arrayImpares[$i] . "<br/>";
    }

    foreach ($arrayImpares as $value) {
        # code...
        echo $value . "<br/>";
    }
    echo "<br/><br/>";

    echo "Aplicacion 11";
    echo "<br/>";
    $miVector=array(
        1=>90,
        30=>7,
        'e'=>99,
        'hola'=>'mundo'
    );
    foreach ($miVector as $key => $value) {
        # code...
        print("Mi Clave : $key - Valor: $value <br/>");
    }
    echo "<br/><br/>";

    echo "Aplicacion 12";
    echo "<br/>";

    $lapicera=array(
        'Color'=>array("Verde","Rojo","Negro"),
        'Marca'=>array("Bic","Parker","FaberCastell"),
        'Trazo'=>array("fino","grueso","normal"),
        'Precio'=>array(50,100,200)
    );
    foreach ($lapicera as $key => $value) {
        # code...
        print("Lapicera  : $key ");
        var_dump($value);
    }
    echo "<br/><br/>";

    echo "Aplicacion 13";
    echo "<br/>";
    $arrayTrece1 =array();
    array_push($arrayTrece1, "Perro", "Gato", "Ratón", "Araña", "Mosca");
    $arrayTrece2 =array();
    array_push($arrayTrece2, "1986", "2015", "78", "89");
    $arrayTrece3=array();
    array_push($arrayTrece3,"php","mysqp","html5","typescript","ajax");

    $resultado=array_merge($arrayTrece1,$arrayTrece2,$arrayTrece3);
    print_r($resultado);
    echo "<br/><br/>";

    echo "Aplicacion 14";
    echo "<br/>";
    $arrayCatorce=array(
        'Animales'=>$arrayTrece1,
        'Años'=>$arrayTrece2,
        'Lenguajes'=>$arrayTrece3
    );
    var_dump($arrayCatorce);
    echo "<br/><br/>";
