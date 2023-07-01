<?php
session_start();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a index.php
header("Location: index.php");
exit();
?>