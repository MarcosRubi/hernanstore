<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';

$Obj_Clientes = new Clientes();

$Obj_Clientes->nombre_cliente = preg_replace('/\s+/', ' ', trim(strip_tags(ucwords(strtolower(trim($_POST['txtNombre']))))));
$Obj_Clientes->telefono = strip_tags(trim(str_replace("_", "", $_POST['txtTelefono'])));
$Obj_Clientes->direccion = preg_replace('/\s+/', ' ', trim(strip_tags(ucwords(strtolower(trim($_POST['txtDireccion']))))));
$Obj_Clientes->correo =  strip_tags(strtolower(trim($_POST['txtCorreo'])));
$Obj_Clientes->descripcion = '<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-size: 1.5rem; font-weight: bolder;">NÚMEROS DE TELÉFONOS</span><br></h4></div><table class="table table-bordered"><tbody><tr class="bg-lightblue"><td><b>NOMBRE DEL PROPIETARIO</b></td><td><b>PARENTESCO CON EL CLIENTE</b></td><td><b>NÚMERO DE TELÉFONO</b></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div>

<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-weight: bolder;">CORREOS ELECTRÓNICOS</span></h4></div><table class="table table-bordered"><tbody><tr class="bg-lightblue"><td><b>NOMBRE DEL PROPIETARIO</b></td><td><b>PARENTESCO CON EL CLIENTE</b></td><td><b>DIRECCIÓN DE EMAIL</b></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div>

<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-weight: bolder;">NOTAS ADICIONALES</span></h4></div>

<p></p><ul><li><b>Recordatorio:&nbsp;</b></li></ul><p><br></p>';

if (trim($_POST['txtNombre']) === '') {
    $_SESSION['msg'] = 'Ingrese el nombre del cliente.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

$Res_Clientes = $Obj_Clientes->Insertar();

if ($Res_Clientes) {
    $_SESSION['msg'] = 'Cliente creado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/clientes/");
}
