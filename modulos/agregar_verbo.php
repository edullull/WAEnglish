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

// Procesar el formulario al recibir una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verbo = $_POST['verbo'];
    $significado = $_POST['significado'];
    $ejemplo = $_POST['ejemplo'];
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario que ha iniciado sesión

    // Insertar el nuevo verbo en la base de datos
    $query = "INSERT INTO verbos (verbo, significado, ejemplo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $verbo, $significado, $ejemplo, $usuario_id);

    if ($stmt->execute()) {
        // Redirigir a la página de verbos después de agregar el verbo
        header('Location: verbos.php');
        exit;
    } else {
        echo "Error al agregar el verbo: " . $conn->error;
    }
}


include('../templates/header.php');
?>


<main class="container">
    <h1>Agregar Verbo</h1>
    <form method="POST" action="agregar_verbo.php">
        <div class="mb-3">
            <label for="adverbio" class="form-label">Verbo</label>
            <input type="text" class="form-control" name="verbo" required>
        </div>
        <div class="mb-3">
            <label for="significado" class="form-label">Significado</label>
            <input type="text" class="form-control" name="significado" required>
        </div>
        <div class="mb-3">
            <label for="ejemplo" class="form-label">Ejemplo</label>
            <input type="text" class="form-control" name="ejemplo" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
</main>