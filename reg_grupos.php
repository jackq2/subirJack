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
    $carrera = $_POST['carrera'];
    $nombre_grupo = $_POST['nombre_grupo'];
    $descgrupo = $_POST['descgrupo'];
    $numero_est = $_POST['numero_est'];
    $prof_autor = $_SESSION['id_user']; // El profesor autor toma el ID del usuario en sesión
    // Preparar la consulta SQL para insertar datos en la tabla tareas
    $sql = "INSERT INTO grupos (carrera, nombre_grupo, descgrupo, numero_est, prof_autor) VALUES (?, ?, ?, ?, ?)";
    // Preparar la sentencia SQL
    $stmt = $con->prepare($sql);
    // Vincular los parámetros
    $stmt->bind_param('sssis',$carrera,$nombre_grupo, $descgrupo, $numero_est, $prof_autor);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        header('Location: listagrupos.php?mensaje=El+grupo+se+ha+agregado+exitosamente.');
    } else {
        header('Location: listagrupos.php?error=Error+al+agregar+al+grupo:+' . urlencode($stmt->error));
    }
    // Cerrar la sentencia
    $stmt->close();
}
// Cerrar la conexión a la base de datos
$con->close();
