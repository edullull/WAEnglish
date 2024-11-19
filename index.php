<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: usuarios/login.php');
    exit;
}

// URL base
$url_base = "http://localhost/weblearntalk/";

// Incluir el header con la sesión activa
include("templates/header.php");
?>

<main class="container my-5">
    <div class="p-5 text-center bg-light shadow rounded">
        <h1 class="display-4 fw-bold text-primary">Welcome to WAEnglish, <?php echo $_SESSION['usuario']; ?>!</h1>
        <p class="lead text-secondary">Improve your skills and manage your categories with ease. Get started now!</p>

        <!-- Imagen personalizada con tamaño ajustado -->
        <img src="<?php echo $url_base; ?>img/WAEnglish.png" class="img-fluid my-4 rounded" alt="Welcome banner" style="max-width: 300px; height: auto;">
        
        <div>
            <a href="<?php echo $url_base; ?>modulos/categorias.php" class="btn btn-primary btn-lg px-5">Start</a>
        </div>
    </div>
    <section class="mt-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Manage Categories</h5>
                        <p class="card-text">Organize your learning content by creating and managing categories effortlessly.</p>
                        <a href="<?php echo $url_base; ?>modulos/categorias.php" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title text-success">Track Progress</h5>
                        <p class="card-text">Monitor your achievements and stay motivated on your learning journey.</p>
                        <a href="#" class="btn btn-outline-success">View Dashboard</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Join the Community</h5>
                        <p class="card-text">Connect with other learners and exchange tips and resources.</p>
                        <a href="#" class="btn btn-outline-danger">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Incluir el footer
include("templates/footer.php");
?>

