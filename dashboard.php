<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); 
    exit();
}
echo "Bienvenido, " . $_SESSION['usuario'] . "!";
?>

<!-- Botón de cierre de sesión -->
<form action="logout.php" method="POST">
    <button type="submit">Cerrar sesión</button>
</form>
