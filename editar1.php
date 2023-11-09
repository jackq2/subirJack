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
    $id_estudiante = $_GET['id'];
    
    // Comprueba si se envió un formulario de edición
    if (isset($_POST['editar_nombres'])) {
        $nuevos_nombres = $_POST['nombres'];

        $stmt = $con->prepare("UPDATE estudiantes SET nombres = ? WHERE id_estudiante = ?");
        $stmt->bind_param('si', $nuevos_nombres, $id_estudiante);

        // Ejecutar la consulta de actualización
        if ($stmt->execute()) {
            header("Location: inicio.php?mensaje=Registro actualizado exitosamente.");
            exit;
        } else {
            header("Location: inicio.php?error=Error al actualizar el registro: " . urlencode($stmt->error));
            exit;
        }
    }

    // Obtener los datos del estudiante para mostrar en el formulario de edición
    $sql = "SELECT * FROM estudiantes WHERE id_estudiante = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id_estudiante);
    $stmt->execute();
    $result = $stmt->get_result();
    $estudiante = $result->fetch_assoc();

    $stmt->close();
} else {
    // Si no se proporciona un ID válido, redirigir a la página principal
    header('Location: inicio.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="loggedin">
    <nav class="navtop">
        <div class="header">
            <h1 style="color:red; margin-right: 20px;">Partiteck</h1>
            <div class="nav-links">
                <a href="listagrupos.php" class="nav-link">Team</a>
                <a href="perfil.php" class="nav-link">Perfil</a>
                <a href="cerrar-sesion.php" class="nav-link">Cerrar</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <h2>Editar Estudiante</h2>
        <form method="POST" action="editar.php?id=<?php echo $id_estudiante; ?>" class="form-horizontal">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombres de la comida:</th>
                    <th>Enviar</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" class="form-control" name="nombres" value="<?php echo $estudiante['nombres']; ?>" required></td>
                    <td><input type="submit" class="btn btn-primary" value="Guardar cambios"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
