<?php

use App\Models\AutentificadorJWT;
use App\Models\ORM\usuario;
include_once __DIR__ . '/../../src/app/modelAPI/AutentificadorJWT.php';

class Middleware
{
    public function ValidarRuta($req,$res,$next)
    {
        $isValid=false;
        $token=$req->getHeader('token');
        if($token!=null)
        {
            $token=$token[0];

            try{
                AutentificadorJWT::VerificarToken($token);
                $isValid=true;
            }
            catch(\Exception $e){
                $newRes=$res->withJson('Token invalido. ERROR: '.$e->getMessage(),200);
            }

            if($isValid){
                $newRes=$next($req,$res);
            }
            else{
                $newRes=$res->withJson('No se envio el token',200);
            }
            return $newRes;
        }
    }

    public function ValidarAdmin($req,$res,$next)
    {
        $token=$req->getHeader('token');
        $token=$token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);
        $idUsuarioToken=$datosToken->id;

        $usuarioToken=usuario::where('id',$idUsuarioToken)->first();

        if(strcasecmp($usuarioToken->tipo, 'admin')==0){
            $newRes=$next($req,$res);
        }
        else{
            $newRes=$res->withJson('No es admin ',200);
        }
        return $newRes;
    }

}