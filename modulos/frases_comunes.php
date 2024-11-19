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

// Recuperar los verbos del usuario
$usuario_id = $_SESSION['usuario_id'];
$query = "SELECT * FROM frases_comunes WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<?php
// Incluir el header
include('../templates/nav.php');
?>

<main class="container">
    <h1>Frases comunes</h1>
    
    <!-- Botón para agregar nuevo verbo -->
    <a href="agregar_frases_comunes.php" class="btn btn-primary mb-3">Agregar frases</a>

    <!-- Mostrar lista de verbos frasales -->
    <?php if ($resultado->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Frases</th>
                    <th>Ejemplo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($frase_comunes = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($frase_comunes['frase']); ?></td>
                        <td><?php echo htmlspecialchars($frase_comunes['significado']); ?></td>
                        <td>
                            <!-- Botones para editar o eliminar el verbo frasal -->
                            <a href="editar_phrasal_verbs.php?id=<?php echo $verbo_frasal['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_verbo_frasal.php?id=<?php echo $verbo['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este verbo frasal?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No has agregado ningún verbo frasal aún.</p>
    <?php endif; ?>
</main>

<?php
// Incluir el footer
include('../templates/footer.php');
?>
