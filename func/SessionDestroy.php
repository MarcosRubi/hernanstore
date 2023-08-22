<?php
session_start();

$Path = $_SESSION['Path'];

session_unset();

$_SESSION['Path'] = $Path;
header("Location:" .  $_SESSION['Path'] . "/iniciar-sesion/");
