<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirigir al login
    header('Location: ../login.php');
    exit;
}

$url_base = "http://localhost/weblearntalk/";

// Incluir el header con la sesión activa
include("../templates/header.php");
?>

<main class="container my-5">
    <div class="text-center">
        <h1 class="display-4 fw-bold text-primary">Categorías</h1>
        <p class="lead text-secondary">Explora y selecciona la categoría que deseas gestionar o repasar.</p>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Selecciona una Categoría</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="adverbios.php" class="text-decoration-none text-dark fw-bold d-flex justify-content-between align-items-center">
                            Adverbios
                            <span class="badge bg-primary rounded-pill">→</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="verbos.php" class="text-decoration-none text-dark fw-bold d-flex justify-content-between align-items-center">
                            Verbos
                            <span class="badge bg-success rounded-pill">→</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="adjetivos.php" class="text-decoration-none text-dark fw-bold d-flex justify-content-between align-items-center">
                            Adjetivos
                            <span class="badge bg-warning rounded-pill">→</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="phrasal_verbs.php" class="text-decoration-none text-dark fw-bold d-flex justify-content-between align-items-center">
                            Verbos Frasales
                            <span class="badge bg-danger rounded-pill">→</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="frases_comunes.php" class="text-decoration-none text-dark fw-bold d-flex justify-content-between align-items-center">
                            Frases Comunes
                            <span class="badge bg-info rounded-pill">→</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php
include("../templates/footer.php");
?>
