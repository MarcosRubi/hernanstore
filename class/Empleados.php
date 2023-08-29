<?php
class Empleados extends DB
{
    public $nombre_empleado;
    public $contrasenna;
    public $correo;
    public $url_foto;
    public $id_rol;

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_empleados";
        return $this->EjecutarQuery($query);
    }
    public function listarRoles()
    {
        $query = "SELECT * FROM vta_listar_roles";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_empleados WHERE id_empleado='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarEmpleadoPorCorreo()
    {
        $query = "SELECT * FROM vta_listar_empleados WHERE correo='" . $this->correo . "' ";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_empleados(
            nombre_empleado,
            contrasenna,
            correo,
            url_foto,
            id_rol )
            VALUES (
            '" . $this->nombre_empleado . "',
            '" . password_hash($this->contrasenna, PASSWORD_DEFAULT) . "',
            '" . $this->correo . "',
            '" . $this->url_foto . "',
            '" . $this->id_rol . "' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_empleados SET 
        nombre_empleado = '" . $this->nombre_empleado . "',
        correo = '" . $this->correo . "',
        url_foto = '" . $this->url_foto . "',
        contrasenna = '" .  password_hash($this->contrasenna, PASSWORD_DEFAULT) . "',
        id_rol = '" . $this->id_rol . "' 
        WHERE id_empleado='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }
    public function ActualizarPorAdministrador($id)
    {
        $query = "UPDATE tbl_empleados SET 
        nombre_empleado = '" . $this->nombre_empleado . "',
        correo = '" . $this->correo . "',
        url_foto = '" . $this->url_foto . "',
        id_rol = '" . $this->id_rol . "' 
        WHERE id_empleado='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }
    public function RestablecerContrasenna($id)
    {
        $query = "UPDATE tbl_empleados SET 
        contrasenna = '" .  password_hash($this->contrasenna, PASSWORD_DEFAULT) . "'
        WHERE id_empleado='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_empleados SET Eliminado='S' WHERE id_empleado='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
