<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id_phrasal_verbs = $_GET['id'];

    $query = "DELETE FROM phrasal_verbs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_phrasal_verbs);

    if ($stmt->execute()) {
        header('Location: phrasal_verbs.php');
        exit;
    } else {
        echo "Error al eliminar el verbo: " . $conn->error;
    }
} else {
    echo "ID del verbo no especificado.";
    exit;
}
?>