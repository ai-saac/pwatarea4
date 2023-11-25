<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./public/css/style.css">
  <title>Registro</title>
</head>

<body>
  <!-- Contenedor principal -->
  <div class="login-container">
    <!-- Columna izquierda: banner -->
    <div class="login-banner">
      <!-- Contenido del banner -->
    </div>
    <!-- Columna derecha: formulario de inicio de sesión -->
    <div class="login-form">
      <!-- Contenedor del formulario -->
      <div class="form-container">
        <!-- Formulario de registro -->
        <form class="registro" method="post" action="./auth/register.php">
          <h1>Formulario de Registro</h1>
          <div class="form-registro">
            <label for="name">Nombre:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Correo electrónico:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="password-confirm">Confirmar contraseña:</label><br>
            <input type="password" id="password-confirm" name="password-confirm" required><br>
            <label for="role">Rol:</label><br>
            <select id="role" name="role">
              <option value="Admin">Admin</option>
              <option value="User">User</option>
            </select><br><br>
            <button type="submit" value="Registrarse" name="submit">Registrarse</button>
          </div>
        </form>
        <?php
        // Muestra mensajes de error o éxito si existen
        if (isset($_SESSION['error'])) {
          echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        } elseif (isset($_SESSION['success'])) {
          echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
          unset($_SESSION['success']);
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>