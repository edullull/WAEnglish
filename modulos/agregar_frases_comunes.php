<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = $_POST['frase'];
    $significado = $_POST['significado'];
    $usuario_id = $_SESSION['usuario_id'];

    $query = "INSERT INTO frases_comunes (frase, significado, usuario_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $frase, $significado, $usuario_id);

    if ($stmt->execute()) {
        header('Location: frases_comunes.php');
        exit;
    } else {
        echo "Error al agregar la frase: " . $conn->error;
    }
}

include('../templates/header.php');
?>
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 text-center mb-0">Agregar Frase comun</h1>
                </div>
        <div class="card-body">
            <form method="POST" action="agregar_frases_comunes.php">
                <div class="mb-3">
                    <label for="frase" class="form-label fw-bold">Frase común</label>
                    <input type="text" class="form-control" name="frase" placeholder="Ejemplo: Look up" required>
                </div>
                <div class="mb-3">
                    <label for="significado" class="form-label fw-bold">Significado</label>
                    <input type="text" class="form-control" name="significado" placeholder="Ejemplo: Buscar información" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Agregar</button>
                    <a href="frases_comunes.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>


<?php
include('../templates/footer.php');
?>
