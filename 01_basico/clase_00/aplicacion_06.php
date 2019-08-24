<?php  
    $operador='+';
    $op1=3;
    $op2=6;
    $resultado;
    switch($operador){
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
?>