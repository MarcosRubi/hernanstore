<?php
session_start();


if (!isset($_SESSION['NombreEmpleado'])) {
    header("Location:" .  $_SESSION['Path'] . "/iniciar-sesion/");
    die();
}
