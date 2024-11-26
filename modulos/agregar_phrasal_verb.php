<?php
// Iniciar sesión
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phrasal_verb = $_POST['phrasal_verb'];
    $significado = $_POST['significado'];
    $ejemplo = $_POST['ejemplo'];
    $usuario_id = $_SESSION['usuario_id']; 
    $query = "INSERT INTO phrasal_verbs (phrasal_verb, significado, ejemplo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $phrasal_verb, $significado, $ejemplo, $usuario_id);

    if ($stmt->execute()) {
        header('Location: phrasal_verbs.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al agregar el verbo frasal: " . $conn->error . "</div>";
    }
}

include('../templates/header.php');
?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 text-center mb-0">Agregar Verbo Frasal</h1>
                </div>
        <div class="card-body">
            <form method="POST" action="agregar_phrasal_verb.php">
                <div class="mb-3">
                    <label for="phrasal_verb" class="form-label fw-bold">Verbo Frasal</label>
                    <input type="text" class="form-control" name="phrasal_verb" placeholder="Ejemplo: Look up" required>
                </div>
                <div class="mb-3">
                    <label for="significado" class="form-label fw-bold">Significado</label>
                    <input type="text" class="form-control" name="significado" placeholder="Ejemplo: Buscar información" required>
                </div>
                <div class="mb-3">
                    <label for="ejemplo" class="form-label fw-bold">Ejemplo</label>
                    <textarea class="form-control" name="ejemplo" rows="3" placeholder="Escribe un ejemplo del uso del verbo frasal" required></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Agregar</button>
                    <a href="phrasal_verbs.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
include('../templates/footer.php');
?>
