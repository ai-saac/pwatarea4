<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde la tabla
    $task_id = $_POST['id'];
    $descripcion = $_POST['description'];

    try {
        $dsn = "mysql:host=localhost;dbname=pwa;charset=utf8";
        $usuario = "root";
        $contrasena = "";

        $pdo = new PDO($dsn, $usuario, $contrasena);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Actualizar la tarea en la base de datos
        $query = "UPDATE tasks SET description = :description WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':description', $descripcion);
        $stmt->bindParam(':id', $task_id);  // Corregir aquí el nombre del parámetro

        if ($stmt->execute()) {
            echo json_encode(["message" => "Tarea actualizada correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar la tarea"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error en la conexión a la base de datos: " . $e->getMessage()]);
    }
}
