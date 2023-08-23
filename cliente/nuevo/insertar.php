<?php
require_once '../../func/LoginValidator.php';

$Nombre = ucfirst(strtolower(trim($_POST['txtNombre'])));
$Telefono = trim(str_replace("_", "", $_POST['txtTelefono']));
$Direccion = ucwords(strtolower(trim($_POST['txtDireccion'])));
$Informacion =  '<p><br>
</p><div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-size: 1.5rem; font-weight: bolder;">NÚMEROS DE TELÉFONOS</span><br></h4></div><table class="table table-bordered"><tbody><tr class="bg-lightblue"><td><b>NOMBRE DEL PROPIETARIO</b></td><td><b>PARENTESCO CON EL CLIENTE</b></td><td><b>NÚMERO DE TELÉFONO</b></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div>

<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-weight: bolder;">CORREOS ELECTRÓNICOS</span></h4></div><table class="table table-bordered"><tbody><tr class="bg-lightblue"><td><b>NOMBRE DEL PROPIETARIO</b></td><td><b>PARENTESCO CON EL CLIENTE</b></td><td><b>DIRECCIÓN DE EMAIL</b></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div>

<div style="text-align: center;"><h4 class="p-2" style="font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;"><span style="font-weight: bolder;">NOTAS ADICIONALES</span></h4></div>

<p></p><ul><li><b>Recordatorio:&nbsp;</b></li></ul><p><br></p>';

var_dump($Nombre, $Telefono, $Direccion);
