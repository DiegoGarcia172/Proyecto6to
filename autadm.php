<?php
session_start();
if (!isset($_SESSION['usuarioid']) || $_SESSION['rol_id'] != 1) {
    header('Location: login.php');
    exit();
}
?>