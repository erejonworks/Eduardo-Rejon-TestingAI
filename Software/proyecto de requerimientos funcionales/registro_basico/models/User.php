<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public static function registrar($nombre, $email, $password) {
        global $conn;
    
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32)); // Token de activación único
    
        $sql = "INSERT INTO usuarios (nombre, email, password, token_activacion, activo)
                VALUES (?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param("ssss", $nombre, $email, $hashPassword, $token);
    
        if ($stmt->execute()) {
            // Enviar correo de activación
            self::enviarCorreoActivacion($email, $token);
            return true;
        }
    
        return false;
    }
    

    public static function obtenerTodos() {
        global $conn;
    
        $sql = "SELECT id, nombre, email, creado_en FROM usuarios";
        $result = $conn->query($sql);
    
        $usuarios = [];
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
    
        return $usuarios;
    }
    
    public static function existeCorreo($email) {
        global $conn;
    
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
    
            return $stmt->num_rows > 0;
        }
    
        return false;
    }
    
    public static function enviarCorreoActivacion($email, $token) {
        $asunto = "Activa tu cuenta";
        $enlace = "http://localhost/registro_basico/views/confirmar.php?token=$token";
    
        $mensaje = "
            <h2>¡Gracias por registrarte!</h2>
            <p>Para activar tu cuenta, haz clic en el siguiente enlace:</p>
            <p><a href='$enlace'>$enlace</a></p>
        ";
    
        $cabeceras = "MIME-Version: 1.0\r\n";
        $cabeceras .= "Content-type: text/html; charset=UTF-8\r\n";
        $cabeceras .= "From: no-responder@tusistema.com\r\n";
    
        mail($email, $asunto, $mensaje, $cabeceras);
    }
    

}
?>
