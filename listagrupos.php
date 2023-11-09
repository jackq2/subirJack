<?php
// confirmar sesion
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="loggedin">
    <nav class="navtop">
        <div class="header">
            <h1 style="color:red; margin-right: 20px;">PartiTeck</h1>
            <div class="nav-links">
                <a href="inicio.php" class="nav-link">Inicio</a>
                <a href="perfil.php" class="nav-link">Perfil</a>
                <a href="cerrar-sesion.php" class="nav-link">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <h2>Insertar Nuevo GRUPO</h2>
        <!-- Formulario para insertar datos en la tabla grupos con diseño Bootstrap -->
        <?php
        if (isset($_GET['mensaje'])) {
            echo "<p style='color: green;'>" . $_GET['mensaje'] . "</p>";
        }
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>" . $_GET['error'] . "</p>";
        }
        ?>
        <form method="POST" action="reg_grupos.php" class="form-horizontal">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Carrera:</th>
                    <th>Nombre del grupo:</th>
                    <th>Descripción del grupo:</th>
                    <th>Número de Estudiantes:</th>
                    <th>Enviar</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <select name="carrera" class="form-control" required>
                            <option value="CONTADOR PUBLICO">CONTADOR PUBLICO</option>
                            <option value="LICENCIATURA EN ADMINISTRACION">LICENCIATURA EN ADMINISTRACION</option>
                            <option value="LICENCIATURA EN GASTRONOMIA">LICENCIATURA EN GASTRONOMIA</option>
                            <option value="LICENCIATURA EN TURISMO">LICENCIATURA EN TURISMO</option>
                            <option value="INGENIERIA EN ANIMACION DIGITAL Y EFECTOS VISUALES">INGENIERIA EN ANIMACION DIGITAL Y EFECTOS VISUALES</option>
                            <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES">INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
                            <option value="INGENIERIA EN INDUSTRIAS ALIMENTARIAS">INGENIERIA EN INDUSTRIAS ALIMENTARIAS</option>
                            <option value="INGENIERIA EN ENERGIAS RENOVABLES">INGENIERIA EN ENERGIAS RENOVABLES</option>
                            <option value="INGENIERIA FERROVIARIA">INGENIERIA FERROVIARIA</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="nombre_grupo" required></td>
                    <td><input type="text" class="form-control" name="descgrupo" required></td>
                    <td><input type="number" class="form-control" name="numero_est" required></td>
                    <td><input type="submit" class="btn btn-primary" value="Guardar"></td>
                </tr>
                </tbody>
            </table>
        </form>
        <!-- Mostrar la tabla de GRUPOS -->
        <h3>Tabla de Tareas</h3>
        <?php
        // Aquí debes obtener y mostrar los datos de la tabla GRUPOS
        // Consulta SQL para obtener todos los registros de GRUPOS
        include 'conexionDB.php';
        global $con;
        $sql = "SELECT * FROM grupos";
        $result = $con->query($sql);
        // Verificar si la tabla está vacía
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Carrera</th>";
            echo "<th>Nombre del grupo</th>";
            echo "<th>Descripción</th>";
            echo "<th>Número de Estudiantes</th>";
            echo "<th>Profesor Autor</th>";
            echo "<th>Editar Actividades</th>"; // Nueva columna para editar actividades
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_grupo']}</td>";
                echo "<td>{$row['carrera']}</td>";
                echo "<td>{$row['nombre_grupo']}</td>";
                echo "<td>{$row['descgrupo']}</td>";
                echo "<td>{$row['numero_est']}</td>";
                echo "<td>{$row['prof_autor']}</td>";
                // Agrega una nueva celda con un enlace para editar actividades
                echo "<td><a href='edit_act.php?id_grupo={$row['id_grupo']}'>Editar</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No hay registros en la tabla de GRUPOS.</p>";
        }
        // Cerrar la consulta
        $result->close();
        ?>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
