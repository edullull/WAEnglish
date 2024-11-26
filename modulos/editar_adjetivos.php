<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id_adjetivo = $_GET['id'];

    $query = "SELECT * FROM adjetivos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_adjetivo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $adjetivo = $resultado->fetch_assoc();

    if (!$adjetivo) {
        echo "<div class='alert alert-danger'>El adverbio no existe.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID de adverbio no especificado.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_adjetivo = $_POST['adjetivo'];
    $nuevo_significado = $_POST['significado'];
    $nuevo_ejemplo = $_POST['ejemplo'];

    $query = "UPDATE adjetivos SET adjetivo = ?, significado = ?, ejemplo = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nuevo_adjetivo, $nuevo_significado, $nuevo_ejemplo, $id_adjetivo);

    if ($stmt->execute()) {
        header('Location: adjetivos.php');  
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el adjetivo: " . $conn->error . "</div>";
    }
}

include('../templates/header.php');
?>

<main class="container my-5">
    <div class="p-2 bg-light shadow rounded text-center">   
        <h1 class="display-6 text-primary fw-bold">Editar Adjetivo</h1>
        <p class="lead text-secondary">Realiza los cambios necesarios y guarda las modificaciones.</p>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <form method="POST" action="editar_adjetivos.php?id=<?php echo $id_adjetivo; ?>">
                        <div class="mb-3">
                            <label for="adjetivo" class="form-label fw-semibold text-primary">Adjetivo</label>
                            <input type="text" class="form-control" name="adjetivo" value="<?php echo $adjetivo['adjetivo']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="significado" class="form-label fw-semibold text-primary">Significado</label>
                            <input type="text" class="form-control" name="significado" value="<?php echo $adjetivo['significado']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ejemplo" class="form-label fw-semibold text-primary">Ejemplo</label>
                            <input type="text" class="form-control" name="ejemplo" value="<?php echo $adjetivo['ejemplo']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                            <a href="adjetivos.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include('../templates/footer.php');
?>
