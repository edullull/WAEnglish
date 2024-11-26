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
    $verbo = $_POST['verbo'];
    $significado = $_POST['significado'];
    $ejemplo = $_POST['ejemplo'];
    $usuario_id = $_SESSION['usuario_id']; 
    $query = "INSERT INTO verbo (verbo, significado, ejemplo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $verbo, $significado, $ejemplo, $usuario_id);

    if ($stmt->execute()) {
        header('Location: verbos.php');
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
                    <h1 class="h4 text-center mb-0">Agregar Verbo</h1>
                </div>
        <div class="card-body">
            <form method="POST" action="agregar_phrasal_verb.php">
                <div class="mb-3">
                    <label for="phrasal_verb" class="form-label fw-bold">Verbo</label>
                    <input type="text" class="form-control" name="phrasal_verb" placeholder="Ecribe un ejemplo" required>
                </div>
                <div class="mb-3">
                    <label for="significado" class="form-label fw-bold">Significado</label>
                    <input type="text" class="form-control" name="significado" placeholder="Ecribe un ejemplo" required>
                </div>
                <div class="mb-3">
                    <label for="ejemplo" class="form-label fw-bold">Ejemplo</label>
                    <textarea class="form-control" name="ejemplo" rows="3" placeholder="Ecribe un ejemplo" required></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Agregar</button>
                    <a href="verbos.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
include('../templates/footer.php');
?>