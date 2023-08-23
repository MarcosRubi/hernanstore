<?php
session_start();


if (!isset($_SESSION['NombreEmpleado'])) {
    header("Location: http://127.0.0.1/Proyectos/hernanstore.com/iniciar-sesion/");
    die();
}
