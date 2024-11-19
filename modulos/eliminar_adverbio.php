<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

// Incluir la conexión a la base de datos
include('../conexion.php');

// Verificar si se ha pasado un ID válido
if (isset($_GET['id'])) {
    $id_adverbio = $_GET['id'];

    // Preparar la consulta de eliminación
    $query = "DELETE FROM adverbios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_adverbio);

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        // Redirigir a la lista de adverbios después de eliminar
        header('Location: adverbios.php');
        exit;
    } else {
        echo "Error al eliminar el adverbio: " . $conn->error;
    }
} else {
    echo "ID de adverbio no especificado.";
    exit;
}
?>
