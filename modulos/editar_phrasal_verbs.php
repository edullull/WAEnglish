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
    $id_phrasal_verb = $_GET['id'];

    // Obtener los datos del verbo frasal seleccionado
    $query = "SELECT * FROM phrasal_verbs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_phrasal_verb);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $phrasal_verb = $resultado->fetch_assoc();
    
    // Verificar si el verbo frasal existe
    if (!$phrasal_verb) {
        echo "El verbo frasal no existe.";
        exit;
    }
} else {
    echo "ID de verbo frasal no especificado.";
    exit;
}

// Actualizar los datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_phrasal_verb = $_POST['phrasal_verb'];
    $nuevo_significado = $_POST['significado'];
    $nuevo_ejemplo = $_POST['ejemplo'];

    // Actualizar el verbo frasal en la base de datos
    $query = "UPDATE phrasal_verbs SET phrasal_verb = ?, significado = ?, ejemplo = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nuevo_phrasal_verb, $nuevo_significado, $nuevo_ejemplo, $id_phrasal_verb);

    if ($stmt->execute()) {
        // Redirigir a la página de verbos frasales después de actualizar
        header('Location: phrasal_verbs.php');
        exit;
    } else {
        echo "Error al actualizar el verbo frasal: " . $conn->error;
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container">
    <h1>Editar Verbo Frasal</h1>
    <form method="POST" action="editar_phrasal_verbs.php?id=<?php echo $id_phrasal_verb; ?>">
        <div class="mb-3">
            <label for="phrasal_verb" class="form-label">Verbo Frasal</label>
            <input type="text" class="form-control" name="phrasal_verb" value="<?php echo htmlspecialchars($phrasal_verb['phrasal_verb']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="significado" class="form-label">Significado</label>
            <input type="text" class="form-control" name="significado" value="<?php echo htmlspecialchars($phrasal_verb['significado']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="ejemplo" class="form-label">Ejemplo</label>
            <input type="text" class="form-control" name="ejemplo" value="<?php echo htmlspecialchars($phrasal_verb['ejemplo']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
