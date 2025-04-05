<?php
require_once __DIR__ . '/../controllers/UserListController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Usuarios Registrados</h2>

    <table class="table table-striped table-bordered shadow">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)) : ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['creado_en']); ?></td>
                        <td>
                            <form action="../controllers/DeleteUserController.php" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="5" class="text-center">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="register.php" class="btn btn-outline-primary">Volver al Registro</a>
    </div>
    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
    </div>

</div>
</body>
</html>
