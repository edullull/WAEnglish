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
    $phrasal_verb = $_POST['phrasal_verb'];
    $significado = $_POST['significado'];
    $ejemplo = $_POST['ejemplo'];
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario que ha iniciado sesión

    // Insertar el nuevo verbo frasal en la base de datos
    $query = "INSERT INTO phrasal_verbs (phrasal_verb, significado, ejemplo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $phrasal_verb, $significado, $ejemplo, $usuario_id);

    if ($stmt->execute()) {
        // Redirigir a la página de verbos frasales después de agregar el verbo
        header('Location: phrasal_verbs.php');
        exit;
    } else {
        echo "Error al agregar el verbo frasal: " . $conn->error;
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container">
    <h1>Agregar Verbo Frasal</h1>
    <form method="POST" action="agregar_phrasal_verb.php">
        <div class="mb-3">
            <label for="phrasal_verb" class="form-label">Verbo Frasal</label>
            <input type="text" class="form-control" name="phrasal_verb" required>
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
        <a href="verbos_frasales.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
