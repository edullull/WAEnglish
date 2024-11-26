<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

// Incluir la conexión a la base de datos
include('../conexion.php');

// Procesar el formulario al recibir una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adjetivo = $_POST['adjetivo']; 
    $significado = $_POST['significado'];
    $ejemplo = $_POST['ejemplo'];
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario que ha iniciado sesión

    $query = "INSERT INTO adjetivos (adjetivo, significado, ejemplo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $adjetivo, $significado, $ejemplo, $usuario_id);

    if ($stmt->execute()) {
        // Redirigir a la página de verbos frasales después de agregar el verbo
        header('Location: adjetivos.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al agregar el adjetivo: " . $conn->error . "</div>";
    }
}

include('../templates/header.php');
?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 text-center mb-0">Agregar Adjetivo</h1>
                </div>
        <div class="card-body">
            <form method="POST" action="agregar_adjetivos.php">
                <div class="mb-3">
                    <label for="adjetivo" class="form-label fw-bold">Adjetivo</label>
                    <input type="text" class="form-control" name="adjetivo" placeholder="Ejemplo" required>
                </div>
                <div class="mb-3">
                    <label for="significado" class="form-label fw-bold">Significado</label>
                    <input type="text" class="form-control" name="significado" placeholder="Ejemplo" required>
                </div>
                <div class="mb-3">
                    <label for="ejemplo" class="form-label fw-bold">Ejemplo</label>
                    <textarea class="form-control" name="ejemplo" rows="3" placeholder="Escribe un ejemplo" required></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Agregar</button>
                    <a href="adjetivos.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
