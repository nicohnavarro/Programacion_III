<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\comida;


include_once __DIR__ . '/comida.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class comidaControler
{
    public function CargarComida($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
    
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();

        $datos = $request->getParsedBody();

        if(isset($datos["nombre"],$datos["tipo"],$datos["precio"]))
        {
            
            if(comidaControler::ValidarTipo($datos["tipo"]))
            {
                $comida = new comida();
                $comida->nombre = $datos["nombre"];    
                $comida->tipo = $datos["tipo"];
                $comida->precio = $datos["precio"];
                $comida->save();

                empleadoControler::RegistrarOperacion($empleado, 'Cargar Comida');

                $newResponse = $response->withJson("Comida cargada", 200);


            }
            else
            {
                $newResponse = $response->withJson("No es un tipo válido", 200);
            }
        }
        else
        {
            $newResponse = $response->withJson("Faltan datos", 200);
        }

        return $newResponse;

    }


    public function ModificarComida($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idComida = $request->getAttribute('idComida');
    
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();

        $datos = $request->getParsedBody();

        //busco la comida:
        $comida = comida::where('id', $idComida)->first();

        if($comida != null)
        {
            if(isset($datos["nombre"]))
            {
                $comida->nombre = $datos["nombre"];    
            }

            if(isset($datos["tipo"]))
            {
                if(comidaControler::ValidarTipo($datos["tipo"]))
                {
                    $comida->tipo = $datos["tipo"];    
                }
                else
                {
                    $newResponse = $response->withJson("No es un tipo válido", 200);
                }
            
                
            }

            if(isset($datos["precio"]))
            {
                $comida->precio = $datos["precio"];    
            }

            $comida->save();

            empleadoControler::RegistrarOperacion($empleado, 'Modificar Comida');


            $newResponse = $response->withJson("Comida modificada", 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontró la comida $idComida", 200);
        }         

        return $newResponse;

    }

    public function BorrarComida($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idComida = $request->getAttribute('idComida');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();

        if(isset($idComida))
        {
            
            $comida = comida::where('id', $idComida)->first();
                
            $comida->delete();

            empleadoControler::RegistrarOperacion($empleado, 'Borrar Comida');

            $newResponse = $response->withJson("Comida $idComida borrada", 200);
       
        }
        else
        {
            $newResponse = $response->withJson("Faltan datos", 200);
        }
        
        return $newResponse;

    }

        //Valido el tipo de pedido
    public static function ValidarTipo($tipo)
    {
        $esValido = true;

        if(is_array($tipo))
        {
            $length = count($tipo);

            for($i = 0; $i < $length; $i++)
            {
                if(strcasecmp($tipo[$i],'cerveza') == 0 ||
                    strcasecmp($tipo[$i],'bebida') == 0 ||
                    strcasecmp($tipo[$i],'comida') == 0 )
                {
                    continue;
                }
                else
                {
                    $esValido = false;
                    break;
                }
            }
        }
        else
        {
            if(strcasecmp($tipo,'cerveza') == 0 ||
                    strcasecmp($tipo,'bebida') == 0 ||
                    strcasecmp($tipo,'comida') == 0 )
                {
                    $esValido = true;
                }
                else
                {
                    $esValido = false;
                }
        }



        return $esValido;
    }


}




?>