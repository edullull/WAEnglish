<?php
// Iniciar sesión
session_start();
echo 'Usuario ID: ' . $_SESSION['usuario_id'];

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

// Incluir la conexión a la base de datos
include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adverbio = $_POST['adverbio'];
    $significado = $_POST['significado'];
    $ejemplo = $_POST['ejemplo'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar el nuevo adverbio en la base de datos
    $query = "INSERT INTO adverbios (adverbio, significado, ejemplo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $adverbio, $significado, $ejemplo, $usuario_id);

    if ($stmt->execute()) {
        header('Location: adverbios.php');
        exit;
    } else {
        echo "Error al agregar el adverbio: " . $conn->error;
    }
}

// Incluir el header
include('../templates/header.php');
?>

<main class="container">
    <h1>Agregar Adverbio</h1>
    <form method="POST" action="agregar_adverbio.php">
        <div class="mb-3">
            <label for="adverbio" class="form-label">Adverbio</label>
            <input type="text" class="form-control" name="adverbio" required>
        </div>
        <div class="mb-3">
            <label for="significado" class="form-label">Significado</label>
            <input type="text" class="form-control" name="significado" required>
        </div>
        <div class="mb-3">
            <label for="ejemplo" class="form-label">Ejemplo</label>
            <input type="text" class="form-control" name="ejemplo" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
