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

// Verificar si se ha proporcionado el ID del verbo a editar
if (isset($_GET['id'])) {
    $id_verbo = $_GET['id'];

    // Preparar la consulta para obtener los datos del verbo
    $query = "SELECT * FROM verbos WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_verbo, $_SESSION['usuario_id']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si se encontró el verbo
    if ($resultado->num_rows > 0) {
        $verbo = $resultado->fetch_assoc(); // Obtener los datos del verbo
    } else {
        echo "No se encontró el verbo o no tienes permiso para editarlo.";
        exit;
    }
} else {
    echo "ID de verbo no proporcionado.";
    exit;
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_verbo = $_POST['verbo'];
    $nuevo_significado = $_POST['significado'];
    $nuevo_ejemplo = $_POST['ejemplo'];

    // Actualizar el verbo en la base de datos
    $query = "UPDATE verbos SET verbo = ?, significado = ?, ejemplo = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $nuevo_verbo, $nuevo_significado, $nuevo_ejemplo, $id_verbo, $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        // Redirigir a la página de verbos después de guardar los cambios
        header('Location: verbos.php');
        exit;
    } else {
        echo "Error al actualizar el verbo: " . $conn->error;
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container">
    <h1>Editar Verbo</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="verbo" class="form-label">Verbo</label>
            <input type="text" class="form-control" name="verbo" value="<?php echo htmlspecialchars($verbo['verbo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="significado" class="form-label">Significado</label>
            <input type="text" class="form-control" name="significado" value="<?php echo htmlspecialchars($verbo['significado']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="ejemplo" class="form-label">Ejemplo Frase</label>
            <input type="text" class="form-control" name="ejemplo" value="<?php echo htmlspecialchars($verbo['ejemplo']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
