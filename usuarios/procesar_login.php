<?php
session_start();
include('../conexion.php'); // Incluye la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Escapar entradas de usuario para evitar inyección SQL
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Consulta para verificar el usuario (sin cifrado de contraseñas)
    $query = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Verificar si la consulta se ejecutó correctamente
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    // Si hay resultados, procedemos
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Guardar el ID y el nombre del usuario en la sesión
        $_SESSION['usuario_id'] = $user['id'];  // Asignar el 'id' de la tabla usuarios
        $_SESSION['usuario'] = $user['nombre']; // Guardar el nombre del usuario

        // Si es el administrador, asignamos un valor especial
        if ($email == "admin@admin.com") {
            $_SESSION['usuario'] = "admin"; // Asignar explícitamente "admin" si es el administrador
        }

        // Redirigir al index tras el login exitoso (o a admin.php si es admin)
        if ($_SESSION['usuario'] == "admin") {
            header('Location: admin.php'); // Redirigir a admin.php si el admin es autenticado
        } else {
            header('Location: ../index.php'); // Si es usuario normal, redirigir a su página principal
        }
        exit;
    } else {
        echo "Email o contraseña incorrectos.";
    }
}

?>
