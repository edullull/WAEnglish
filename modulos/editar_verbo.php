<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id_verbo = $_GET['id'];

    $query = "SELECT * FROM verbos WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_verbo, $_SESSION['usuario_id']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $verbo = $resultado->fetch_assoc(); 
    } else {
        echo "No se encontró el verbo o no tienes permiso para editarlo.";
        exit;
    }
} else {
    echo "ID de verbo no proporcionado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_verbo = $_POST['verbo'];
    $nuevo_significado = $_POST['significado'];
    $nuevo_ejemplo = $_POST['ejemplo'];

    $query = "UPDATE verbos SET verbo = ?, significado = ?, ejemplo = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $nuevo_verbo, $nuevo_significado, $nuevo_ejemplo, $id_verbo, $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        header('Location: verbos.php');
        exit;
    } else {
        echo "Error al actualizar el verbo: " . $conn->error;
    }
}

include('../templates/header.php');
?>
<main class="container my-5">
    <div class="p-2 bg-light shadow rounded text-center">
        <h1 class="display-6 text-primary fw-bold">Editar Verbo</h1>
        <p class="lead text-secondary">Realiza los cambios necesarios y guarda las modificaciones.</p>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <form method="POST" action="editar_verbo.php?id=<?php echo $id_verbo; ?>">
                        <div class="mb-3">
                            <label for="verbo" class="form-label fw-semibold text-primary">Verbo</label>
                            <input type="text" class="form-control" name="verbo" value="<?php echo $verbo['verbo']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="significado" class="form-label fw-semibold text-primary">Significado</label>
                            <input type="text" class="form-control" name="significado" value="<?php echo $verbo['significado']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ejemplo" class="form-label fw-semibold text-primary">Ejemplo</label>
                            <input type="text" class="form-control" name="ejemplo" value="<?php echo $verbo['ejemplo']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                            <a href="verbo.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
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
