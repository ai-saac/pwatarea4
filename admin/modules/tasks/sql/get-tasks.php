<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

// Obtener el ID y el rol del usuario que inició sesión

$userId = $_SESSION['user']['id'];
$userRole = $_SESSION['user']['role'];

try {
    // Consulta SQL para obtener las tareas según el rol del usuario
    if ($userRole === 'Admin') {
        // Si es un administrador, muestra todas las tareas
        $queryTareas = "SELECT t.*, u.name AS nombre, u.role AS rol
                        FROM tasks AS t
                        LEFT JOIN users AS u ON t.user_id = u.id";
    } else {
        // Si no es un administrador, muestra solo sus propias tareas
        $queryTareas = "SELECT t.*, u.name AS nombre, u.role AS rol
                        FROM tasks AS t
                        LEFT JOIN users AS u ON t.user_id = u.id
                        WHERE t.user_id = :userId";
    }

    $stmtTareas = $pdo->prepare($queryTareas);

    // Si no es un administrador, vincula el parámetro para filtrar por usuario
    if ($userRole !== 'Admin') {
        $stmtTareas->bindParam(':userId', $userId, PDO::PARAM_INT);
    }

    $stmtTareas->execute();

    $tareas = array();
    while ($row = $stmtTareas->fetch(PDO::FETCH_ASSOC)) {
        $tareas[] = $row;
    }

    // echo json_encode(array('success' => true, 'tasks' => $tareas));
} catch (PDOException $e) {
    echo json_encode(array('success' => false, 'error' => 'Error al obtener tareas: ' . $e->getMessage()));
} finally {
    // Cierra la conexión a la base de datos
    $pdo = null;
}
