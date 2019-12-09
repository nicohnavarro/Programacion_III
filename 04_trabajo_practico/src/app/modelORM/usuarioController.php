<?php
namespace App\Models\ORM;
use Slim\App;
use App\Models\ORM\usuario;

include_once __DIR__ . '/usuario.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;

class usuarioController 
{
    private static $claveSecreta='claveSecreta1';

    public function CargarUsuario($req,$res,$args){
        $token=$req->getHeader('token');
        $token=$token[0];
        $datosToken=AutentificadorJWT::ObtenerData($token);
        $idUsuarioToken=$datosToken->id;
        $usuarioToken=usuario::where('id',$idUsuarioToken)->first();

        $datos=$req->getParsedBody();

        if(isset($datos['nombre'],$datos['apellido'],$datos['tipo'],$datos['clave']))
        {
            //Tipos de usuarios
            if (usuarioController::ValidarTipo($datos['tipo'])) {
                $usuario=new usuario();
                $usuario->nombre=$datos['nombre'];
                $usuario->apellido=$datos['apellido'];
                $usuario->clave=crypt($datos['clave'], self::$claveSecreta);
                $usuario->tipo=$datos['tipo'];

                $usuario->save();

                $newRes=$res->withJson('Usuario Cargado', 200);
            }
            else
            {
                $newRes=$res->withJson('Tipo Invalido :(',200);
            }
        }
        else
        {
            $newRes=$res->withJson('Faltan Datos :(',200);
        }
        return $newRes;
    }

    public function UsuarioLogin($req,$res,$arg)
    {
        $datos=$req->getParsedBody();
        if(isset($datos['id'],$datos['clave']))
        {
            $id=$datos['id'];
            $clave=$datos['clave'];

            $usuario= usuario::where('id',$id)->first();
            $hash=crypt($clave,self::$claveSecreta);
            if($usuario!=null)
            {
                if(hash_equals($usuario->clave,crypt($clave,self::$claveSecreta)))
                {
                    $datosToken=array(
                        'id'=>$usuario->id,
                        'nombre'=>$usuario->nombre,
                        'apellido'=>$usuario->apellido,
                        'tipo'=>$usuario->tipo
                    );

                    $token=AutentificadorJWT::CrearToken($datosToken);
                    //guardaroperacion
                    $newRes=$res->withJson($token,200);
                }
                else{
                    $newRes=$res->withJson('ERROR',200);
                }
            }
            else
            {
                $newRes=$res->withJson('Faltan DAtos',200);
            }
            return $newRes;
        }
    }

    public static function ValidarTipo($tipo)
    {
        $esValido = false;
        if(strcasecmp($tipo,'bartender') == 0 ||
                strcasecmp($tipo,'cervecero') == 0 ||
                strcasecmp($tipo,'cocinero') == 0 ||
                strcasecmp($tipo,'mozo') == 0 ||
                strcasecmp($tipo,'admin') == 0 ||
                strcasecmp($tipo,'socio') == 0)
        {   
            $esValido = true;
        }
        return $esValido;
    }

}