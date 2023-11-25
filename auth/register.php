<?php
// Iniciar la sesión
session_start();

// Conectarse a la base de datos usando PDO
require_once '../config/conn.php';

// Comprobar si se ha enviado el formulario
if (isset($_POST['submit'])) {
  // Obtener los datos del formulario
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $passwordConfirm = $_POST['password-confirm'];
  $role = $_POST['role'];

  // Validar los datos del formulario
  if (empty($name) || empty($email) || empty($password) || empty($passwordConfirm)) {
    // Alguno de los campos está vacío, muestra un mensaje de error
    $_SESSION['error'] = "Por favor, rellena todos los campos del formulario.";
  } elseif (strlen($name) < 3) {
    // El nombre de usuario es demasiado corto
    $_SESSION['error'] = "Por favor, ingresa un nombre válido.";
  } elseif (strlen($password) < 8) {
    // La contraseña es demasiado corta, muestra un mensaje de error
    $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres.";
  } elseif ($password !== $passwordConfirm) {
    // Las contraseñas no coinciden, muestra un mensaje de error
    $_SESSION['error'] = "Las contraseñas no coinciden.";
  } else {
    // Los datos del formulario son válidos, comprueba si el correo electrónico ya está en uso
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      // El correo electrónico ya está en uso, muestra un mensaje de error
      $_SESSION['error'] = "Este correo electrónico ya está en uso.";
    } else {
      // El correo electrónico está disponible, inserta el usuario en la base de datos
      $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

      $query = "INSERT INTO users (name, role, email, password) VALUES (:name, :role, :email, :password)";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':role', $role, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':password', $passwordHashed, PDO::PARAM_STR);

      if ($stmt->execute()) {
        // La consulta se ha ejecutado con éxito, muestra un mensaje de éxito
        $_SESSION['success'] = "El usuario se ha registrado con éxito.";
        header("Location: login.php");
      } else {
        // La consulta ha fallado, muestra un mensaje de error
        $_SESSION['error'] = "Ha ocurrido un error al registrar el usuario.";
      }
    }
  }

  exit();
}