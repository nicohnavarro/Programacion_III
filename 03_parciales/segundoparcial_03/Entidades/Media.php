<?php
include_once("DB/AccesoDatos.php");

class Media
{
    public $id;
    public $color;
    public $marca;
    public $precio;
    public $talle;
    public $foto;

    public function __toString()
    {
        return $this->id." - ".$this->color." - ".$this->marca." - ".$this->precio." - ".$this->talle." - ".$this->foto;
    }
        
    public static function ConsultarTodos()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, color, marca, precio, talle, foto FROM media");
        
        $consulta->execute();        
                
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Media");
    }

    public static function Insertar($color,$marca,$precio,$talle,$foto)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO media (color, marca, precio, talle, foto)
                                                        VALUES(:color, :marca, :precio, :talle, :foto)");
        
        $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
        $consulta->bindValue(':color', $color, PDO::PARAM_STR);
        $consulta->bindValue(':talle', $talle, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $foto, PDO::PARAM_STR);

        $consulta->execute();   
    }

    public static function Eliminar($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consultaFoto = $objetoAccesoDato->RetornarConsulta("SELECT foto FROM media WHERE id = :id");
        $consultaFoto->bindValue(':id', $id, PDO::PARAM_INT);
        $consultaFoto->execute();
        $foto = $consultaFoto->fetch()["foto"];
        //borro la foto
        unlink("./Fotos/FotoMedias/$foto");
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM media WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
    
}