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
    if (isset($_POST['editar_informacion'])) {
        $nuevos_nombres = $_POST['nombres'];
		$apellidopat = $_POST['apellidopat'];
		$apellidomat = $_POST['apellidomat'];
		$grupo = $_POST['grupo'];
		
    // Asegúrate de que "grupo" se haya enviado y no sea nulo
    if (isset($_POST['grupo'])) {
        $grupo = $_POST['grupo'];
    } else {
        // Puedes proporcionar un valor predeterminado o manejar este caso de otra manera
        $grupo = "Sin grupo";
    }
		
		$stmt = $con->prepare("UPDATE estudiantes SET nombres = ?, apellidopat = ?, apellidomat = ?, grupo = ? WHERE id_estudiante = ?");
		$stmt->bind_param('ssssi', $nuevos_nombres, $apellidopat, $apellidomat, $grupo, $id_estudiante);
        //$stmt = $con->prepare("UPDATE estudiantes SET nombres = ? WHERE id_estudiante = ?");
        //$stmt->bind_param('si', $nuevos_nombres, $id_estudiante);

        // Ejecutar la consulta de actualización
        if ($stmt->execute()) {
            header('Location: inicio.php?mensaje=Registro actualizado exitosamente.');
            exit;
        } else {
            header('Location: inicio.php?error=Error al actualizar el registro: ' . urlencode($stmt->error));
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
    <title>Editar Concursante</title>
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
        <h2>Editar Concursante</h2>
        <form method="POST" action="editar.php?id=<?php echo $id_estudiante; ?>" class="form-horizontal">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre del concursante:</th>
					<th>Apellido paterno del concursante:</th>
					<th>Apellido materno del concursante:</th>
                    <th>Enviar</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" class="form-control" name="nombres" value="<?php echo $estudiante['nombres']; ?>" required></td>
					<td><input type="text" class="form-control" name="apellidomat" value="<?php echo $estudiante['apellidomat']; ?>" required></td>
					<td><input type="text" class="form-control" name="apellidopat" value="<?php echo $estudiante['apellidopat']; ?>" required></td>
					<td><input type="text" class="form-control" name="grupo" value="<?php echo $estudiante['grupo']; ?>" required></td>
                    <td><input type="submit" class="btn btn-primary" name="editar_informacion" value="Guardar cambios"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
