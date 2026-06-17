<?php

/**
 * Configuracion de Base de Datos
 * STOCK SYSTEM
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'stock_system');
define('DB_PORT', 3306);

// Crear conexion
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

// Verificar conexion
if ($conn->connect_error) {
    die('Error de conexion a la base de datos: ' . $conn->connect_error);
}

// Configurar charset
$conn->set_charset('utf8mb4');

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

?>