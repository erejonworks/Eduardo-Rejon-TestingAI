<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Redirigir de vuelta a la lista de usuarios
    header("Location: ../views/user_list.php");
    exit();
} else {
    // Si alguien intenta acceder por GET o sin ID
    header("Location: ../views/user_list.php");
    exit();
}
