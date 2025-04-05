<?php
require_once __DIR__ . '/../config/database.php';

session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Debes ingresar tu correo y contraseña.";
    } else {
        $sql = "SELECT id, nombre, email, password, activo FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (!$usuario['activo']) {
                $error = "Tu cuenta aún no ha sido activada. Revisa tu correo.";
            } elseif (password_verify($password, $usuario['password'])) {
                // Autenticación exitosa
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];

                header("Location: ../index.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
}
