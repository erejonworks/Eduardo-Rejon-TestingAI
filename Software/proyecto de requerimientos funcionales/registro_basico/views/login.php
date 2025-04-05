<?php
require_once __DIR__ . '/../controllers/LoginController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h2 class="mb-4 text-center">Iniciar Sesión</h2>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="card p-4 shadow">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
            </form>

            <div class="text-center mt-3">
                <a href="recuperar.php">¿Olvidaste tu contraseña?</a><br>
                <a href="register.php">¿No tienes cuenta? Regístrate</a>
            </div>
            <div class="text-center mt-4">
                <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
