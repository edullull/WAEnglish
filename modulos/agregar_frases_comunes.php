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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = $_POST['frase'];
    $significado = $_POST['significado'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar el nuevo adverbio en la base de datos
    $query = "INSERT INTO frases_comunes (frase, significado, usuario_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $frase, $significado, $usuario_id);

    if ($stmt->execute()) {
        header('Location: frases_comunes.php');
        exit;
    } else {
        echo "Error al agregar la frase: " . $conn->error;
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container">
    <h1>Agregar frase</h1>
    <form method="POST" action="agregar_frases_comunes.php">
        <div class="mb-3">
            <label for="frase" class="form-label">Frase</label>
            <input type="text" class="form-control" name="frase" required>
        </div>
        <div class="mb-3">
            <label for="significado" class="form-label">Significado</label>
            <input type="text" class="form-control" name="significado" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar</button>
        <a href="frases_comunes.php" class="btn btn-secondary">Cancelar</a>

    </form>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
