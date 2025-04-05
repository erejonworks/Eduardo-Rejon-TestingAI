<?php
// Redireccionar directamente al formulario de registro por ahora
// header("Location: views/register.php");
// exit();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Sistema de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h1 class="mb-4">Sistema de Registro de Usuarios</h1>
        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="views/register.php" class="btn btn-primary btn-lg">Registrar Usuario</a>
            <a href="views/user_list.php" class="btn btn-secondary btn-lg">Gestión de Usuarios</a>
        </div>
    </div>
</body>
</html>
