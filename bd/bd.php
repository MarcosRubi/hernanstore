<?php
class DB
{
    private $Server;
    private $User;
    private $Password;
    private $DataBase;
    private $Conexion;
    private $ResultadoConsulta;

    public function __construct()
    {
        $this->Server = "localhost";
        $this->User = "root";
        $this->Password = "";
        $this->DataBase = "db_hernanstore";
    }

    protected function ConectarDB()
    {
        @$this->Conexion = mysqli_connect($this->Server, $this->User, $this->Password, $this->DataBase) or die('<br><br>No se puede establecer conexión');
        return $this->Conexion;
    }

    protected function CerrarConexion()
    {
        return mysqli_close($this->Conexion);
    }

    public function EjecutarQuery($query)
    {
        $this->ResultadoConsulta = mysqli_query($this->ConectarDB(), $query) or die('Error en la consulta<br>MySQL:' . mysqli_error($this->Conexion));
        $this->CerrarConexion();
        return $this->ResultadoConsulta;
    }
}
