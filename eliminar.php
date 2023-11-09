<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
// Incluir el archivo de conexión a la base de datos
include 'conexionDB.php';
global $con;

if (isset($_GET['id'])) {
    echo "Si entro al archivo";
    $id_estudiante = $_GET['id'];
    $stmt = $con->prepare("DELETE FROM estudiantes WHERE id_estudiante = ?");
    $stmt->bind_param('i', $id_estudiante);
    // Ejecutar la consulta de inserción
    if ($stmt->execute()) {
        header('Location: inicio.php?mensaje=El+alumno+se+ha+eliminado+exitosamente.');
    } else {
        header('Location: inicio.php?error=Error+al+eliminar+los+datos:' . urlencode($stmt->error));
    }
    // Cierra la conexión y termina el script
    $stmt->close();
}
$con->close();

