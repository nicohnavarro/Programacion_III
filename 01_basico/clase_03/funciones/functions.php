<?php

    function Save($dato, $path, $modificar = false)
    {
        if ($modificar==false) {
            $aux= Read($path);
            if (!$aux) {
                $aux=array();
            }
        
            array_push($aux, $dato);
        } else {
            $aux=$dato;
        }
        $archivo = fopen($path, 'w');
        $respuesta=fwrite($archivo, json_encode($aux));
        fclose($archivo);
        return $respuesta;
    }

    function Read($path)
    {
        if (file_exists($path)) {
            $archivo=fopen($path, 'r');
        } else {
            return false;
        }
        $size = filesize($path);
        if ($size > 0) {
            $aux=fread($archivo, $size);
        } else {
            fclose($archivo);
            return false;
        }
        return json_decode($aux, true);
    }

    function Delete($dato, $path)
    {
        $aux= Read($path);
        $retorno=array();
        $respuesta=false;
        for ($i=0 ; $i< count($aux);$i++) {
            if ($aux[$i]['legajo'] != $dato->legajo) {
                array_push($retorno, $aux[$i]);
            } else {
                $respuesta=true;
            }
        }
        Save($retorno, $path, true);
        return $respuesta;
    }

    function Modificar($obj, $path)
    {
        $aux=Read($path);
        $retorno=false;
        for ($i=0 ;$i< count($aux);$i++) {
            if ($aux[$i]['legajo']==$obj->legajo) {
                $aux[$i]=$obj;
                $retorno=true;
            }
        }
        Save($aux, $path, true);
        return $retorno;
    }

    function Backup($legajo, $path)
    {
        $aux=Read($path);
        $ruta=0;
        $respuesta=false;

        for ($i=0; $i< count($aux);$i++) {
            if ($auc[$i]['legajo']==$legajo) {
                $respuesta=true;
                $ruta=$aux[$i]['imagen'];
            }
        }
        if ($respuesta) {
            $extension = explode('.', $ruta);
            rename($ruta, './BackupImages/php.'.$legajo. '.'. $extension[count($extension)-1]);
        }
        return $respuesta;
    }

    function ValidarExistencia($dato, $aux)
    {
        for ($i=0; $i< count($aux);$i++) {
            if ($aux[$i]['legajo']== $dato->legajo) {
                return true;
            }
        }
        return false;
    }

    function Alta($dato, $path)
    {
        $aux = Read($path);
        if ($aux==false) {
            Save($dato, $path, true);
        } else {
            if (ValidarExistencia($dato, $aux)) {
                echo 'Ya existe no se da de alta';
                return false;
            }
        }
        Save($dato, $path, false);
        return true;
    }

    function Show($path)
    {
        $aux= Read($path);
        for ($i=0; $i< count($aux);$i++) {
            var_dump($aux)[$i];
        }
    }
