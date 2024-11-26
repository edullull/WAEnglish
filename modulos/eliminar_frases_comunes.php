<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id_frases_comunes = $_GET['id'];

    $query = "DELETE FROM frases_comunes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_frases_comunes);

    if ($stmt->execute()) {
        header('Location: frases_comunes.php');
        exit;
    } else {
        echo "Error al eliminar la frase: " . $conn->error;
    }
} else {
    echo "ID de frase no especificado.";
    exit;
}
?>