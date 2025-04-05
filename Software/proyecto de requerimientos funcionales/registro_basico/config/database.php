<?php
$host = "localhost";
$user = "root";
$pass = ""; // Si tienes contraseña en MySQL, colócala aquí.
$dbname = "registro_db";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
