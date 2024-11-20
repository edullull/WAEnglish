<?php
include("../conexion.php"); // Incluye la conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password']; // Contraseña en texto plano
    $nombre = $_POST['nombre'];

    // Verificar si el email ya existe en la base de datos
    $query = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");  
    $query->bind_param("s", $email);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows > 0) {
        // Si el correo ya existe
        echo "El correo electrónico ya está registrado. Intenta con otro.";
    } else {
        // Si el correo no existe, insertar el nuevo usuario sin encriptar la contraseña
        $insert_query = $conn->prepare("INSERT INTO usuarios (email, password, nombre) VALUES (?, ?, ?)");
        $insert_query->bind_param("sss", $email, $password, $nombre);

        if ($insert_query->execute()) {
            echo "Usuario registrado correctamente. <a href='login.php'>Inicia sesión aquí</a>";
        } else {
            echo "Error al registrar el usuario.";
        }
    }
}
?>

