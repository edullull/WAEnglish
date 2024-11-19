<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Si no tienes contraseña, déjalo vacío
$db = 'bdproject'; // Nombre de tu base de datos

// Crear la conexión con mysqli
$conn = new mysqli($host, $user, $password, $db);

// Verificar si la conexión tuvo éxito
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
