<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 50px; /* Para subir la caja más cerca del top */
        }
        .register-container {
            background-color: #d9f0ff; /* Azul claro */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.25);
            color: #004080;
            max-width: 400px;
            width: 100%;
        }
        .register-container h3 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #004080;
        }
        .form-control {
            border-radius: 50px;
            padding: 10px 20px;
        }
        .btn-primary {
            background-color: #004080;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #00264d;
        }
        .register-container label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .footer-text {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .footer-text a {
            color: #004080;
            text-decoration: none;
            font-weight: bold;
        }
        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h3>Crear un Nuevo Usuario</h3>
        <form action="procesar_registro.php" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="password" placeholder="Crea una contraseña" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
        </form>
        <div class="footer-text">
            ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
