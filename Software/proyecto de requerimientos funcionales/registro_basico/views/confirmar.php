<?php
require_once __DIR__ . '/../config/database.php';

$mensaje = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT id FROM usuarios WHERE token_activacion = ? AND activo = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Activar la cuenta
        $stmt->bind_result($id);
        $stmt->fetch();

        $update = $conn->prepare("UPDATE usuarios SET activo = 1, token_activacion = NULL WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();

        $mensaje = "✅ Tu cuenta ha sido activada correctamente. Ya puedes iniciar sesión.";
    } else {
        $mensaje = "❌ El token no es válido o la cuenta ya fue activada.";
    }
} else {
    $mensaje = "❌ Token de activación no proporcionado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Activación de Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert <?php echo strpos($mensaje, '✅') !== false ? 'alert-success' : 'alert-danger'; ?> text-center">
            <h4><?php echo $mensaje; ?></h4>
            <?php if (strpos($mensaje, 'activada') !== false): ?>
                <a href="login.php" class="btn btn-success mt-3">Ir al inicio de sesión</a>
            <?php endif; ?>
        </div>
        <div class="text-center mt-3">
            <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
        </div>

    </div>
</body>
</html>
