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

// Consultar todos los adverbios del usuario actual
$usuario_id = $_SESSION['usuario_id'];
$query = "SELECT * FROM verbos WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

// Incluir el header
include('../templates/nav.php');
?>

<main class="container my-5">
    <div class="text-center">
        <h1 class="display-4 text-primary fw-bold">Lista de Verbos</h1>
        <p class="lead text-secondary">Consulta, edita o elimina los verbos de tu colección personalizada.</p>
    </div>

    <!-- Botón para agregar un nuevo adverbio -->
    <div class="d-flex justify-content-end my-4">
        <a href="agregar_verbo.php" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Agregar verbo
        </a>
    </div>

    <!-- Tabla para mostrar los adverbios -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col">Verbo</th>
                    <th scope="col">Significado</th>
                    <th scope="col">Ejemplo</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($verbo = $resultado->fetch_assoc()) : ?>
                        <tr>
                            <td class="fw-bold text-primary"><?php echo htmlspecialchars($verbo['verbo']); ?></td>
                            <td><?php echo htmlspecialchars($verbo['significado']); ?></td>
                            <td><?php echo htmlspecialchars($verbo['ejemplo']); ?></td>
                            <td class="text-center">
                                <!-- Enlace para editar -->
                                <a href="editar_verbo.php?id=<?php echo $verbo['id']; ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>

                                <!-- Enlace para eliminar -->
                                <a href="eliminar_verbo.php?id=<?php echo $verbo['id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Estás seguro de eliminar este verbo?');">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">No se encontraron verbos en tu colección.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
