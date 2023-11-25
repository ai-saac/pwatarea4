<?php

// Iniciar la sesión
session_start();

// Eliminar la información de la sesión
session_unset();

// Cerrar la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header("Location: ../index.php");
exit();
