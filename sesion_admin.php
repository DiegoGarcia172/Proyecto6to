<?php
session_start();
if (!isset($_SESSION['usuarioid']) || $_SESSION['role'] != 1) { // Verificamos si el usuario no está autenticado o no es administrador
    header('Location: login.php');
    exit;
}
?>
