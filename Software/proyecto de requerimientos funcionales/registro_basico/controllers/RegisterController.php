<?php
require_once __DIR__ . '/../models/User.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $confirm_password = trim($_POST["confirm_password"] ?? '');

    // Validación de campos vacíos
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Intentar registrar usuario
        if (User::existeCorreo($email)) {
            $error = "El correo electrónico ya está registrado.";
        } elseif (User::registrar($nombre, $email, $password)) {
            // (Aquí más adelante podemos agregar el envío del correo de confirmación)
            header("Location: ../views/success.php");
            exit();
        } else {
            $error = "Ocurrió un error al registrar. Inténtalo de nuevo.";
        }
    }
}
