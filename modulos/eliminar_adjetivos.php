<?php
// Iniciar sesión
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id_adjetivo = $_GET['id'];

    $query = "DELETE FROM adjetivos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_adjetivo);

    if ($stmt->execute()) {
        header('Location: adjetivos.php');
        exit;
    } else {
        echo "Error al eliminar el adjetivo: " . $conn->error;
    }
} else {
    echo "ID de adjetivo no especificado.";
    exit;
}
?>
