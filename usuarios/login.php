<?php
// Iniciar sesión
session_start();

// Verificar si ya ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Aquí debes verificar las credenciales con la base de datos (esto es un ejemplo simple)
    if ($email == "admin@admin.com" && $password == "12345") {
        $_SESSION['usuario'] = "admin";
        header('Location: index.php');
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WebLearnTalk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
          body {
            background-color: #f8f9fa;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        .login-container h3 {
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
            color: #343a40;
            text-align: center;

        }
        .login-container .form-control {
            border-radius: 50px;
            padding-left: 20px;
        }
        .btn-primary {
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .error-msg {
            color: red;
            text-align: center;
        }
    </style>
</head>
<div class="login-container">
        <h3>Iniciar Sesión</h3>

        <?php if (isset($error)) { ?>
            <div class="error-msg">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form action="procesar_login.php" method="POST">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>

        <!-- Enlace para registrar un nuevo usuario -->
        <div class="mt-3 text-center">
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>

 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
