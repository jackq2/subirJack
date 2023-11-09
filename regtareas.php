<?php
// Confirmar sesión
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
// Incluir el archivo de conexión a la base de datos
include 'conexionDB.php';
global $con;
// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $nombre_tarea = $_POST['nombre_tarea'];
    $descripcion_tarea = $_POST['descripcion_tarea'];
    $numero_est = $_POST['numero_est'];
    $prof_autor = $_SESSION['id']; // El profesor autor toma el ID del usuario en sesión
    // Preparar la consulta SQL para insertar datos en la tabla tareas
    $sql = "INSERT INTO tareas (nombre_tarea, descripcion_tarea, numero_est, prof_autor) VALUES (?, ?, ?, ?)";
    // Preparar la sentencia SQL
    $stmt = $con->prepare($sql);
    // Vincular los parámetros
    $stmt->bind_param('ssii', $nombre_tarea, $descripcion_tarea, $numero_est, $prof_autor);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        header('Location: inicio.php?mensaje=La tarea se ha agregado exitosamente.');
    } else {
        header('Location: inicio.php?error=Error al agregar la tarea: ' . urlencode($stmt->error));
    }
    // Cerrar la sentencia
    $stmt->close();
}
// Cerrar la conexión a la base de datos
$con->close();
?>
