<?php
require_once __DIR__ . '/../config/database.php';

$mensaje = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor ingresa un correo válido.";
    } else {
        // Verificar si el correo existe
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $token = bin2hex(random_bytes(32));

            // Guardar el token en la BD (temporalmente en el campo token_activacion)
            $update = $conn->prepare("UPDATE usuarios SET token_activacion = ? WHERE email = ?");
            $update->bind_param("ss", $token, $email);
            $update->execute();

            // Enviar correo con enlace
            $asunto = "Recuperación de contraseña";
            $enlace = "http://localhost/registro_basico/views/restablecer.php?token=$token";
            $mensajeCorreo = "
                <p>Hola,</p>
                <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace:</p>
                <p><a href='$enlace'>$enlace</a></p>
                <p>Si no solicitaste esto, ignora este mensaje.</p>
            ";

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8\r\n";
            $headers .= "From: no-reply@tusistema.com\r\n";

            mail($email, $asunto, $mensajeCorreo, $headers);

            $mensaje = "Te hemos enviado un enlace de recuperación a tu correo electrónico.";
        } else {
            $error = "No encontramos una cuenta con ese correo.";
        }
    }
}
