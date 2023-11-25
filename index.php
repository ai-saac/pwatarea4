<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./public/css/style.css">
  <title>Login</title>
</head>

<body>
  <div class="login-container">
    <div class="login-banner">
    </div>
    <div class="login-form">
      <div class="form-container">
        <form class="login" method="post" action="./auth/login.php">
          <h1>Bienvenido</h1>
          <div class="form-login">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" id="email" name="email" class="form-input" required>
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" id="password" name="password" class="form-input" required>
            <br>
            <!-- <label for="codigo">Codigo de Verificacion:</label>
            <input type="number" id="codigo" name="codigo" required><br> -->
            <button type="submit" class="form-button">Iniciar sesión</button>
            <br>
            <button><a href="register.php">Crear Cuenta</a></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>