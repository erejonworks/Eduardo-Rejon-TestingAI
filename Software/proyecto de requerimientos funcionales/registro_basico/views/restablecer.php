<?php
require_once __DIR__ . '/../config/database.php';

$token = $_GET['token'] ?? '';
$mensaje = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');
    $token = $_POST['token'] ?? '';

    if (empty($password) || empty($confirm)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($password !== $confirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password = ?, token_activacion = NULL WHERE token_activacion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hash, $token);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $mensaje = "✅ Tu contraseña ha sido actualizada correctamente.";
        } else {
            $error = "El token no es válido o ya ha sido usado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Restablecer Contraseña</h2>

            <?php if (!empty($mensaje)) : ?>
                <div class="alert alert-success text-center"><?php echo $mensaje; ?></div>
            <?php elseif (!empty($error)) : ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (empty($mensaje)) : ?>
            <form method="POST" class="card p-4 shadow">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Restablecer contraseña</button>
            </form>
            <?php endif; ?>
            <div class="text-center mt-4">
                <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>
