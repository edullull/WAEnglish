<!doctype html>
<html lang="en">

<head>
  <title>WAEnglish</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
      <img src="http://localhost/weblearntalk/img/WAEnglish.png" alt="WAEnglish Logo" width="40" class="d-inline-block align-text-top me-2">
      WAEnglish
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="http://localhost/weblearntalk/index.php">Inicio</a>
        </li>
        <!-- Mostrar Logout si el usuario está logueado -->
        <?php if (isset($_SESSION['usuario'])): ?>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="../usuarios/logout.php">Cerrar sesión</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>



