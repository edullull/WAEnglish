<?php
// Iniciar la sesión
session_start();

// Destruir todas las sesiones
session_unset();
session_destroy();

// Redirigir al usuario al login o a la página principal
header("Location: ../index.php");
exit;
?>
    