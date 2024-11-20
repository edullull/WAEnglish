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
        <p class="lead text-secondary">Bienvenido a WAEnglish, para empezar y visualizar las categorias, pulsa START!</p>

        <!-- Imagen personalizada con tamaño ajustado -->
        <img src="<?php echo $url_base; ?>img/WAEnglish.png" class="img-fluid my-4 rounded" alt="Welcome banner" style="max-width: 300px; height: auto;">
        
        <div>
            <a href="<?php echo $url_base; ?>modulos/categorias.php" class="btn btn-primary btn-lg px-5">Start</a>
        </div>
    </div>
    
</main>

<?php
// Incluir el footer
include("templates/footer.php");
?>

