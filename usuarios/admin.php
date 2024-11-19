<?php
session_start();

// Verificar si el usuario ha iniciado sesión (y si se necesita)
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

include('../conexion.php'); // Conexión a la base de datos

// Obtener todos los términos de las tablas relacionadas (sin filtro por id_usuario)
$adjetivos_query = "SELECT * FROM adjetivos";
$adverbios_query = "SELECT * FROM adverbios";
$frases_comunes_query = "SELECT * FROM frases_comunes";
$phrasal_verbs_query = "SELECT * FROM phrasal_verbs";
$verbos_query = "SELECT * FROM verbos";
$usuarios_query = "SELECT * FROM usuarios";

$adjetivos_result = mysqli_query($conn, $adjetivos_query);
$adverbios_result = mysqli_query($conn, $adverbios_query);
$frases_comunes_result = mysqli_query($conn, $frases_comunes_query);
$phrasal_verbs_result = mysqli_query($conn, $phrasal_verbs_query);
$verbos_result = mysqli_query($conn, $verbos_query);
$usuarios_result = mysqli_query($conn, $usuarios_query);

// Verificar si las consultas fueron exitosas
if (!$adjetivos_result || !$adverbios_result || !$frases_comunes_result || !$phrasal_verbs_result || !$verbos_result || !$usuarios_result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Eliminar término si se pasa el ID y tipo de término a través de la URL
if (isset($_GET['delete_id']) && isset($_GET['tipo'])) {
    $delete_id = $_GET['delete_id'];
    $tipo = $_GET['tipo'];
    $table = '';

    // Determinar la tabla según el tipo
    switch ($tipo) {
        case 'adjetivo':
            $table = 'adjetivos';
            break;
        case 'adverbio':
            $table = 'adverbios';
            break;
        case 'frase_comun':
            $table = 'frases_comunes';
            break;
        case 'phrasal_verb':
            $table = 'phrasal_verbs';
            break;
        case 'verbo':
            $table = 'verbos';
            break;
    }

    // Si existe la tabla, eliminamos el término
    if ($table) {
        $delete_query = "DELETE FROM $table WHERE id = '$delete_id'";
        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            echo "<div class='alert alert-success'>Término eliminado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el término.</div>";
        }
    }

    // Redirigir después de eliminar
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar a {
            color: #fff !important;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #6c757d;
            color: #fff;
            font-weight: bold;
            text-align: center;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .card-body {
            padding: 20px;
        }
        .card-body p {
            font-size: 1rem;
            color: #495057;
        }
        .card-body a {
            text-decoration: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }
        .alert {
            margin-top: 20px;
        }
        .icon {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center text-primary mb-4">Panel de Administración - Términos de los Usuarios</h1>

        <!-- Listado de adjetivos -->
        <h2>Adjetivos</h2>
        <?php while ($adjetivo = mysqli_fetch_assoc($adjetivos_result)) { ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-ad"></i> Adjetivo ID: <?php echo $adjetivo['id']; ?>
                </div>
                <div class="card-body">
                    <p><strong>Usuario ID:</strong> <?php echo $adjetivo['id_usuario']; ?></p>
                    <p><strong>Adjetivo:</strong> <?php echo $adjetivo['adjetivo']; ?></p>
                    <a href="admin.php?delete_id=<?php echo $adjetivo['id']; ?>&tipo=adjetivo" class="btn btn-danger"><i class="fas fa-trash-alt icon"></i>Eliminar</a>
                </div>
            </div>
        <?php } ?>

        <!-- Listado de adverbios -->
        <h2>Adverbios</h2>
        <?php while ($adverbio = mysqli_fetch_assoc($adverbios_result)) { ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bullhorn"></i> Adverbio ID: <?php echo $adverbio['id']; ?>
                </div>
                <div class="card-body">
                    <p><strong>Adverbio:</strong> <?php echo $adverbio['adverbio']; ?></p>
                    <p><strong>Significado:</strong> <?php echo $adverbio['significado']; ?></p>
                    <p><strong>Ejemplo:</strong> <?php echo $adverbio['ejemplo']; ?></p>
                    <a href="admin.php?delete_id=<?php echo $adverbio['id']; ?>&tipo=adverbio" class="btn btn-danger"><i class="fas fa-trash-alt icon"></i>Eliminar</a>
                </div>
            </div>
        <?php } ?>

        <!-- Listado de frases comunes -->
        <h2>Frases Comunes</h2>
        <?php while ($frase_comun = mysqli_fetch_assoc($frases_comunes_result)) { ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-quote-right"></i> Frase Común ID: <?php echo $frase_comun['id']; ?>
                </div>
                <div class="card-body">
                    <p><strong>Frase Común:</strong> <?php echo $frase_comun['frase_comun']; ?></p>
                    <a href="admin.php?delete_id=<?php echo $frase_comun['id']; ?>&tipo=frase_comun" class="btn btn-danger"><i class="fas fa-trash-alt icon"></i>Eliminar</a>
                </div>
            </div>
        <?php } ?>

        <!-- Listado de phrasal verbs -->
        <h2>Phrasal Verbs</h2>
        <?php while ($phrasal_verb = mysqli_fetch_assoc($phrasal_verbs_result)) { ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-cogs"></i> Phrasal Verb ID: <?php echo $phrasal_verb['id']; ?>
                </div>
                <div class="card-body">
                    <p><strong>Phrasal Verb:</strong> <?php echo $phrasal_verb['phrasal_verb']; ?></p>
                    <a href="admin.php?delete_id=<?php echo $phrasal_verb['id']; ?>&tipo=phrasal_verb" class="btn btn-danger"><i class="fas fa-trash-alt icon"></i>Eliminar</a>
                </div>
            </div>
        <?php } ?>

        <!-- Listado de verbos -->
        <h2>Verbos</h2>
        <?php while ($verbo = mysqli_fetch_assoc($verbos_result)) { ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-running"></i> Verbo ID: <?php echo $verbo['id']; ?>
                </div>
                <div class="card-body">
                    <p><strong>Verbo:</strong> <?php echo $verbo['verbo']; ?></p>
                    <a href="admin.php?delete_id=<?php echo $verbo['id']; ?>&tipo=verbo" class="btn btn-danger"><i class="fas fa-trash-alt icon"></i>Eliminar</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
