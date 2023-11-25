<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener el ID de la tarea a eliminar
  $task_id = isset($_POST['task_id']) ? $_POST['task_id'] : null;

  // Verificar que se proporcionó un ID de tarea válido
  if (!$task_id) {
    echo json_encode(["error" => "ID de tarea no proporcionado"]);
    exit();
  }

  try {

    // Verificar si la tarea existe antes de eliminarla
    $queryExiste = "SELECT COUNT(*) FROM tasks WHERE id = ?";
    $stmtExiste = $pdo->prepare($queryExiste);
    $stmtExiste->execute([$task_id]);
    $categoriaExiste = $stmtExiste->fetchColumn() > 0;

    if ($categoriaExiste) {
      // Iniciar una transacción para asegurar la integridad de los datos
      $pdo->beginTransaction();

      // Eliminar la tarea
      $queryEliminar = "DELETE FROM tasks WHERE id = ?";
      $stmtEliminar = $pdo->prepare($queryEliminar);
      $stmtEliminar->execute([$task_id]);

      // Confirmar la transacción
      $pdo->commit();

      echo json_encode(["message" => "Tarea eliminada correctamente"]);
    } else {
      echo json_encode(["error" => "La tarea no existe"]);
    }
  } catch (PDOException $e) {
    // Revertir la transacción en caso de error
    $pdo->rollback();
    echo json_encode(["error" => "Error al eliminar tarea: " . $e->getMessage()]);
  }
}
