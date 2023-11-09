<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla Principal</title>
    <style>
        /* Estilos para la cuadrícula */
        .grid {
            display: grid; /* Usar el sistema de cuadrícula */
            grid-template-columns: repeat(4, 200px); /* Crear 4 columnas de 200px de ancho cada una */
            gap: 10px; /* Agregar espacio entre celdas */
            margin: 20px; /* Agregar margen alrededor de la cuadrícula */
        }

        /* Estilos para las celdas de estudiantes */
        .student {
            width: 100%; /* Ocupar todo el ancho de la columna */
            height: 100px; /* Altura fija para cada celda */
            background-color: red; /* Los estudiantes comienzan en rojo */
            border: 1px solid #000; /* Agregar un borde negro a las celdas */
            text-align: center; /* Centrar el contenido de las celdas */
            padding: 10px; /* Agregar un relleno interno */
            margin-right: 10px; /* Agregar margen derecho para separar horizontalmente las celdas */
        }

        .student.green {
            background-color: green; /* Cambiar a verde cuando terminen una tarea */
        }
    </style>
</head>
<body>
<h1>Pantalla Principal</h1>
<div class="grid"> <!-- Crear una cuadrícula con clase "grid" -->
    <?php
    // Genera la cuadrícula de estudiantes
    $totalStudents = 16; // Cambia el número de estudiantes según sea necesario

    for ($i = 1; $i <= $totalStudents; $i++) {
        echo '<div class="student">Estudiante ' . $i . '</div>'; // Crea una celda de estudiante
    }
    ?>
</div>
</body>
</html>
