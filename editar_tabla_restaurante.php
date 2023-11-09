<?php
// Incluir el archivo de conexión a la base de datos
include 'conexionDB.php'; // Asegúrate de que esto sea un archivo válido y contenga la conexión a la base de datos

// Función para crear la tabla de restaurantes
function crearTablaRestaurantes($con) {
    $sql = "CREATE TABLE IF NOT EXISTS restaurantes (
        id_restaurante INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL,
        tipo_comida VARCHAR(255) NOT NULL,
        direccion VARCHAR(255) NOT NULL,
        telefono VARCHAR(15)
    )";

    if ($con->query($sql) === TRUE) {
        echo "Tabla 'restaurantes' creada exitosamente.<br>";
    } else {
        echo "Error al crear la tabla: " . $con->error . "<br>";
    }
}

// Función para insertar un nuevo restaurante
function insertarRestaurante($con, $nombre, $tipo_comida, $direccion, $telefono) {
    $stmt = $con->prepare("INSERT INTO restaurantes (nombre, tipo_comida, direccion, telefono) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $nombre, $tipo_comida, $direccion, $telefono);

    if ($stmt->execute()) {
        echo "Restaurante insertado exitosamente.<br>";
    } else {
        echo "Error al insertar el restaurante: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

// Función para actualizar los datos de un restaurante
function actualizarRestaurante($con, $id, $nombre, $tipo_comida, $direccion, $telefono) {
    $stmt = $con->prepare("UPDATE restaurantes SET nombre = ?, tipo_comida = ?, direccion = ?, telefono = ? WHERE id_restaurante = ?");
    $stmt->bind_param('ssssi', $nombre, $tipo_comida, $direccion, $telefono, $id);

    if ($stmt->execute()) {
        echo "Restaurante actualizado exitosamente.<br>";
    } else {
        echo "Error al actualizar el restaurante: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

// Función para eliminar un restaurante por su ID
function eliminarRestaurante($con, $id) {
    $stmt = $con->prepare("DELETE FROM restaurantes WHERE id_restaurante = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "Restaurante eliminado exitosamente.<br>";
    } else {
        echo "Error al eliminar el restaurante: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

// Aquí comienza la ejecución del código
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear_tabla'])) {
        crearTablaRestaurantes($con);
    } elseif (isset($_POST['agregar_restaurante'])) {
        $nombre = $_POST['nombre'];
        $tipo_comida = $_POST['tipo_comida'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        insertarRestaurante($con, $nombre, $tipo_comida, $direccion, $telefono);
    } elseif (isset($_POST['actualizar_restaurante'])) {
        $id = $_POST['id_restaurante'];
        $nombre = $_POST['nombre'];
        $tipo_comida = $_POST['tipo_comida'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        actualizarRestaurante($con, $id, $nombre, $tipo_comida, $direccion, $telefono);
    } elseif (isset($_POST['eliminar_restaurante'])) {
        $id = $_POST['id_restaurante'];
        eliminarRestaurante($con, $id);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Restaurantes</title>
</head>
<body>
    <h1>Administrar Restaurantes</h1>
    <form method="POST">
        <input type="submit" name="crear_tabla" value="Crear Tabla 'restaurantes'">
    </form>

    <h2>Agregar Restaurante</h2>
    <form method="POST">
        <label for="nombre">Nombre del Restaurante:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="tipo_comida">Tipo de Comida:</label>
        <input type="text" name="tipo_comida" required>
        <br>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono">
        <br>
        <input type="submit" name="agregar_restaurante" value="Agregar Restaurante">
    </form>

    <h2>Actualizar Restaurante</h2>
    <form method="POST">
        <label for="id_restaurante">ID del Restaurante a Actualizar:</label>
        <input type="text" name="id_restaurante" required>
        <br>
        <label for="nombre">Nuevo Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="tipo_comida">Nuevo Tipo de Comida:</label>
        <input type="text" name="tipo_comida" required>
        <br>
        <label for="direccion">Nueva Dirección:</label>
        <input type="text" name="direccion" required>
        <br>
        <label for="telefono">Nuevo Teléfono:</label>
        <input type="text" name="telefono">
        <br>
        <input type="submit" name="actualizar_restaurante" value="Actualizar Restaurante">
    </form>

    <h2>Eliminar Restaurante</h2>
    <form method="POST">
        <label for="id_restaurante">ID del Restaurante a Eliminar:</label>
        <input type="text" name="id_restaurante" required>
        <br>
        <input type="submit" name="eliminar_restaurante" value="Eliminar Restaurante">
    </form>
</body>
</html>

