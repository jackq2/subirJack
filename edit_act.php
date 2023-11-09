<?php
// Confirmar sesión
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
// Verificar si se recibió el parámetro id_grupo
if (isset($_GET['id_grupo'])) {
    $id_grupo = $_GET['id_grupo'];
    // Incluir el archivo de conexión a la base de datos
    include 'conexionDB.php';
    global $con;
    // Consulta SQL para obtener el nombre del grupo
    $sql_nombre_grupo = "SELECT nombre_grupo FROM grupos WHERE id_grupo = ?";
    $stmt_nombre_grupo = $con->prepare($sql_nombre_grupo);
    $stmt_nombre_grupo->bind_param('i', $id_grupo);
    $stmt_nombre_grupo->execute();
    $stmt_nombre_grupo->store_result();
    $stmt_nombre_grupo->bind_result($nombre_grupo);
    $stmt_nombre_grupo->fetch();
    $stmt_nombre_grupo->close();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Actividades</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="loggedin">
    <nav class="navtop">
        <div class="header">
            <h1 style="color:white; margin-right: 20px;">PartiTech</h1>
            <div class="nav-links">
                <a href="inicio.php" class="nav-link">Inicio</a>
                <a href="listagrupos.php" class="nav-link">Grupos</a>
                <a href="perfil.php" class="nav-link">Perfil</a>
                <a href="cerrar-sesion.php" class="nav-link">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <h3>Agregar Nueva Actividad</h3>
        <!-- Formulario para insertar datos en la tabla actividades -->
        <?php
        if (isset($_GET['mensaje'])) {
            echo "<p style='color: green;'>" . $_GET['mensaje'] . "</p>";
        }
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>" . $_GET['error'] . "</p>";
        }
        ?>
        <form method="POST" action="reg_act.php" class="form-horizontal">
            <input type="hidden" name="id_grupo" value="<?php echo $id_grupo; ?>"> <!-- Campo oculto para el id_grupo -->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre de la Actividad:</th>
                    <th>Descripción de la Actividad:</th>
                    <th>Número de Estudiantes:</th>
                    <th>Enviar</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" class="form-control" name="nombre_actividad" required></td>
                    <td><input type="text" class="form-control" name="desc_actividad" required></td>
                    <td><input type="number" class="form-control" name="numero_est" required></td>
                    <td><input type="submit" class="btn btn-primary" value="Guardar"></td>
                </tr>
                </tbody>
            </table>
        </form>
        <h2>Editar Actividades del Grupo: <?php echo $nombre_grupo; ?></h2>
        <!-- Mostrar la tabla de actividades -->
        <?php
        // Aquí debes obtener y mostrar los datos de la tabla GRUPOS
        // Consulta SQL para obtener todos los registros de GRUPOS
        include 'conexionDB.php';
        global $con;
        $sql = "SELECT * FROM actividades";
        $result = $con->query($sql);
        // Verificar si la tabla está vacía
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Id actividad</th>";
            echo "<th>Nombre de la actividad</th>";
            echo "<th>Descripción actividad</th>";
            echo "<th>Número de Estudiantes</th>";
            echo "<th>Profesor Autor</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_actividad']}</td>";
                echo "<td>{$row['nombre_actividad']}</td>";
                echo "<td>{$row['desc_actividad']}</td>";
                echo "<td>{$row['numero_est']}</td>";
                echo "<td>{$row['prof_autor']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No hay actividades registradas para este grupo.</p>";
        }
        // Cerrar la consulta
        $result->close();
        $con->close();
        ?>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
    } else {
        // Si no se recibió el parámetro id_grupo, redirigir o mostrar un mensaje de error
        header('Location: listagrupos.php?error=El+grupo+no+se+encuentra+definido.');
        exit;
    }
    ?>