<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id_phrasal_verb = $_GET['id'];

    $query = "SELECT * FROM phrasal_verbs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_phrasal_verb);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $phrasal_verb = $resultado->fetch_assoc();
    
    if (!$phrasal_verb) {
        echo "El verbo frasal no existe.";
        exit;
    }
} else {
    echo "ID de verbo frasal no especificado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_phrasal_verb = $_POST['phrasal_verb'];
    $nuevo_significado = $_POST['significado'];
    $nuevo_ejemplo = $_POST['ejemplo'];

    $query = "UPDATE phrasal_verbs SET phrasal_verb = ?, significado = ?, ejemplo = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nuevo_phrasal_verb, $nuevo_significado, $nuevo_ejemplo, $id_phrasal_verb);

    if ($stmt->execute()) {
        header('Location: phrasal_verbs.php');
        exit;
    } else {
        echo "Error al actualizar el verbo frasal: " . $conn->error;
    }
}

include('../templates/header.php');
?>

<main class="container my-5">
    <div class="p-2 bg-light shadow rounded text-center">
        <h1 class="display-6 text-primary fw-bold">Editar verbo frasal</h1>
        <p class="lead text-secondary">Realiza los cambios necesarios y guarda las modificaciones.</p>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <form method="POST" action="editar_phrasal_verbs.php?id=<?php echo $id_phrasal_verb; ?>">
                        <div class="mb-3">
                            <label for="phrasal_verb" class="form-label fw-semibold text-primary">Verbo frasal</label>
                            <input type="text" class="form-control" name="phrasal_verb" value="<?php echo $phrasal_verb['phrasal_verb']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="significado" class="form-label fw-semibold text-primary">Significado</label>
                            <input type="text" class="form-control" name="significado" value="<?php echo $phrasal_verb['significado']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ejemplo" class="form-label fw-semibold text-primary">Ejemplo</label>
                            <input type="text" class="form-control" name="ejemplo" value="<?php echo $phrasal_verb['ejemplo']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                            <a href="phrasal_verbs.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
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
