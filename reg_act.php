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
    $nombre_actividad = $_POST['nombre_actividad'];
    $desc_actividad = $_POST['desc_actividad'];
    $numero_est = $_POST['numero_est'];
    $prof_autor = $_SESSION['id_user']; // El profesor autor toma el ID del usuario en sesión
    $id_grupo = $_POST['id_grupo']; // Obtener el ID del grupo desde el formulario
    // Preparar la consulta SQL para insertar datos en la tabla actividades
    $sql = "INSERT INTO actividades (nombre_actividad, desc_actividad, id_grupo, numero_est, prof_autor) VALUES (?, ?, ?, ?, ?)";
    // Preparar la sentencia SQL
    $stmt = $con->prepare($sql);
    // Vincular los parámetros
    $stmt->bind_param('ssiii', $nombre_actividad, $desc_actividad, $id_grupo, $numero_est, $prof_autor);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: edit_act.php?id_grupo=$id_grupo&mensaje=La+actividad+se+ha+agregado+exitosamente.");
    } else {
        header("Location: edit_act.php?id_grupo=$id_grupo&error=Error+al+agregar+la+actividad:+" . urlencode($stmt->error));
    }
    // Cerrar la sentencia
    $stmt->close();
}
// Cerrar la conexión a la base de datos
$con->close();
?>
