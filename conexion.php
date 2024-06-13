<?php
$serverName = "DIEGO\\SQLEXPRESS";
$connectionInfo = array("Database" => "proyectobase", "UID" => "ra", "PWD" => "1234");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn) {
    die("Connection could not be established.<br />" . print_r(sqlsrv_errors(), true));
}
?>