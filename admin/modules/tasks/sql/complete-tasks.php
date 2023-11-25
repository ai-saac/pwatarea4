<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  try {
    $task_id = $_POST['task_id'];

    $query = "UPDATE tasks SET completed = 1 WHERE id = :task_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      echo json_encode(["message" => "Tarea completada correctamente"]);
    } else {
      echo json_encode(["error" => "Error al completar la tarea"]);
    }
  } catch (PDOException $e) {
      echo json_encode(["error" => "Error en la conexión a la base de datos: " . $e->getMessage()]);
  }
}
