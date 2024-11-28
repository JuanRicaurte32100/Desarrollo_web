<?php
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
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                
                $_SESSION['usuario'] = $usuario;
                header('Location: dashboard.php'); 
                exit();
            } else {
                
                $error = "Contraseña incorrecta.";
            }
        } else {
            
            $error = "Usuario no encontrado.";
        }
    }
}
?>
