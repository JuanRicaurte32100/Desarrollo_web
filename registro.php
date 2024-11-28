<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

include('conexion.php');

if (isset($_POST['usuario']) && isset($_POST['password'])) {
    
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        $error = "Por favor, ingresa un nombre de usuario y una contraseña.";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $usuario); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Este nombre de usuario ya está registrado.";
        } else {
           
            $password_hash = password_hash($password, PASSWORD_BCRYPT); 
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $usuario, $password_hash);

            if ($stmt->execute()) {
                $success = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $error = "Hubo un problema al registrar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="registro-container">
        <h2>Registrarse</h2>
        
        <form action="registro.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        
        <?php if (isset($error)): ?>
            <div class="mensaje error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="mensaje exito"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <p>¿Ya tienes cuenta? <a href="login.html">Iniciar sesión</a></p>
    </div>
</body>
</html>