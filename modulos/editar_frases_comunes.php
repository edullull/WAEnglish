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
    $id_frase = $_GET['id'];

    // Obtener los datos del adverbio seleccionado
    $query = "SELECT * FROM frases_comunes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_frase);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $frase = $resultado->fetch_assoc();

    // Verificar si el adverbio existe
    if (!$frase) {
        echo "<div class='alert alert-danger'>La frase comun no existe.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID de la frase comun no especificado.</div>";
    exit;
}

// Actualizar los datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_frase = $_POST['frase'];
    $nuevo_significado = $_POST['significado'];

    // Actualizar el adverbio en la base de datos
    $query = "UPDATE frases_comunes SET frase = ?, significado = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nueva_frase, $nuevo_significado, $id_frase);

    if ($stmt->execute()) {
        // Redirigir a la página anterior después de guardar
        header('Location: frases_comunes.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar la frase comun: " . $conn->error . "</div>";
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container my-5">
    <div class="p-2 bg-light shadow rounded text-center">   
        <h1 class="display-6 text-primary fw-bold">Editar Frase comun</h1>
        <p class="lead text-secondary">Realiza los cambios necesarios y guarda las modificaciones.</p>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <form method="POST" action="editar_frases_comunes.php?id=<?php echo $id_frase; ?>">
                        <div class="mb-3">
                            <label for="frase" class="form-label fw-semibold text-primary">Frase</label>
                            <input type="text" class="form-control" name="frase" value="<?php echo $frase['frase']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="significado" class="form-label fw-semibold text-primary">Significado</label>
                            <input type="text" class="form-control" name="significado" value="<?php echo $frase['significado']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                            <a href="frases_comunes.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
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
