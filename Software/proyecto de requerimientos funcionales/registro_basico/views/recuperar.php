
<?php
require_once __DIR__ . '/../controllers/RecuperarController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">¿Olvidaste tu contraseña?</h2>

            <?php if (!empty($mensaje)) : ?>
                <div class="alert alert-success text-center"><?php echo $mensaje; ?></div>
            <?php elseif (!empty($error)) : ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="card p-4 shadow">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar enlace de recuperación</button>
            </form>

            <div class="text-center mt-3">
                <a href="login.php">Volver al inicio de sesión</a>
            </div>
            <div class="text-center mt-3">
                <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>
