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

    // Obtener los datos del adverbio seleccionado
    $query = "SELECT * FROM adverbios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_adverbio);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $adverbio = $resultado->fetch_assoc();

    // Verificar si el adverbio existe
    if (!$adverbio) {
        echo "<div class='alert alert-danger'>El adverbio no existe.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID de adverbio no especificado.</div>";
    exit;
}

// Actualizar los datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_adverbio = $_POST['adverbio'];
    $nuevo_significado = $_POST['significado'];
    $nuevo_ejemplo = $_POST['ejemplo'];

    // Actualizar el adverbio en la base de datos
    $query = "UPDATE adverbios SET adverbio = ?, significado = ?, ejemplo = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nuevo_adverbio, $nuevo_significado, $nuevo_ejemplo, $id_adverbio);

    if ($stmt->execute()) {
        // Redirigir a la página anterior después de guardar
        header('Location: adverbios.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el adverbio: " . $conn->error . "</div>";
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container my-5">
    <div class="p-2 bg-light shadow rounded text-center">
        <h1 class="display-6 text-primary fw-bold">Editar Adverbio</h1>
        <p class="lead text-secondary">Realiza los cambios necesarios y guarda las modificaciones.</p>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <form method="POST" action="editar_adverbio.php?id=<?php echo $id_adverbio; ?>">
                        <div class="mb-3">
                            <label for="adverbio" class="form-label fw-semibold text-primary">Adverbio</label>
                            <input type="text" class="form-control" name="adverbio" value="<?php echo $adverbio['adverbio']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="significado" class="form-label fw-semibold text-primary">Significado</label>
                            <input type="text" class="form-control" name="significado" value="<?php echo $adverbio['significado']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ejemplo" class="form-label fw-semibold text-primary">Ejemplo</label>
                            <input type="text" class="form-control" name="ejemplo" value="<?php echo $adverbio['ejemplo']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                            <a href="adverbios.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
