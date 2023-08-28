<?php
session_start();


if (!isset($_SESSION['nombre_empleado'])) {
    // header("Location: https://hernanstore.com/iniciar-sesion/");
    header("Location: http://127.0.0.1/Proyectos/hernanstore.com/iniciar-sesion/");
    die();
}
