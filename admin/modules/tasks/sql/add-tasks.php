<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	try {
		$user_id = $_POST['user_id'];
		$descripcion = $_POST['description'];

		$queryUser = "SELECT name FROM users WHERE id = ?";
		$stmtUser = $pdo->prepare($queryUser);
		$stmtUser->execute([$user_id]);
		$user = $stmtUser->fetchColumn();

		$query = "INSERT INTO tasks (user_id, description) VALUES (?, ?)";
		$stmt = $pdo->prepare($query);
		$stmt->execute([$user_id, $descripcion]);

		header("Location: ../views/tasks_admin.php");
	} catch (PDOException $e) {
		echo "Error al agregar producto: " . $e->getMessage();
	}
}