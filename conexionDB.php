<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "partitech";
// Crear una conexión a la base de datos
$con = new mysqli($servername, $username, $password, $database);
// Verificar si la conexión fue exitosa
if ($con->connect_error) {
    die("Error al conectar a la base de datos: " . $con->connect_error);
}
// Configurar el juego de caracteres a UTF-8 (opcional)
$con->set_charset("utf8");
// Ahora, tienes la variable $conn que representa la conexión a la base de datos.
// Puedes usarla para ejecutar consultas MySQLi en tu aplicación.
