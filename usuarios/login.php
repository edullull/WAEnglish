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
    <title>Login - WAEnglish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(145deg, #66b3ff, #004080); 
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            color: #0056b3;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-top: 10vh; /* Ajuste para elevar la caja */
        }
        .login-container h3 {
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .login-container .form-control {
            background: #f8f9fa;
            border: none;
            border-radius: 25px;
            padding: 10px 15px;
            font-size: 16px;
        }
        .login-container .btn {
            background: #007bff;
            color: #fff;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
        }
        .login-container .btn:hover {
            background: #0056b3;
        }
        .error-msg {
            color: #dc3545;
            margin-top: 10px;
        }
        .footer-link {
            margin-top: 20px;
        }
        .footer-link a {
            color: #0056b3;
            font-weight: bold;
            text-decoration: none;
        }
        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3>Iniciar Sesión</h3>

        <?php if (isset($error)) { ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php } ?>

        <form action="procesar_login.php" method="POST">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block w-100">Iniciar Sesión</button>
        </form>

        <div class="footer-link">
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
