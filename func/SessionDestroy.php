<?php
session_start();

$path = $_SESSION['path'];
$remember = false;

if (isset($_SESSION['remember'])) {
    $correo = $_SESSION['correo'];
    $contrasenna = $_SESSION['contrasenna'];
    $remember = true;
}

session_unset();

$_SESSION['path'] = $path;

if ($remember) {
    $_SESSION['correo'] = $correo;
    $_SESSION['contrasenna'] = $contrasenna;
}
header("Location:" .  $_SESSION['path'] . "/iniciar-sesion/");
