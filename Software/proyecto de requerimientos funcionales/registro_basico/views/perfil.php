<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = $error = "";

// Actualizar nombre
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nombre'])) {
    $nuevoNombre = trim($_POST['nombre']);
    if (!empty($nuevoNombre)) {
        $sql = "UPDATE usuarios SET nombre = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nuevoNombre, $usuario_id);
        if ($stmt->execute()) {
            $_SESSION['usuario_nombre'] = $nuevoNombre;
            $mensaje = "Información actualizada correctamente.";
        } else {
            $error = "Error al actualizar.";
        }
    } else {
        $error = "El nombre no puede estar vacío.";
    }
}

// Actualizar contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['new_password'])) {
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    if (strlen($new) < 6) {
        $error = "La nueva contraseña debe tener al menos 6 caracteres.";
    } elseif ($new !== $confirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hash, $usuario_id);
        if ($stmt->execute()) {
            $mensaje = "Contraseña actualizada correctamente.";
        } else {
            $error = "No se pudo actualizar la contraseña.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Perfil de Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-success text-center"><?php echo $mensaje; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow mb-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" value="<?php echo htmlspecialchars($_SESSION['usuario_email']); ?>" class="form-control" disabled>
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
        </form>
    </div>

    <div class="card p-4 shadow">
        <form method="POST">
            <h5 class="mb-3">Cambiar contraseña</h5>
            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Actualizar contraseña</button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
    </div>
</div>
</body>
</html>
