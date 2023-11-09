<?php
session_start();
include 'conexionDB.php';
global $con;
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
$stmt = $con->prepare('SELECT password, email FROM cuentas WHERE id_user = ?');
$stmt->bind_param('i', $_SESSION['id_user']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="loggedin">
    <nav class="navtop">
        <div class="header">
            <h1 style="color:red; margin-right: 20px;">PartiTeck</h1>
            <div class="nav-links">
                <a href="inicio.php" class="nav-link">Inicio</a>
                <a href="listagrupos.php" class="nav-link">Grupos</a>
                <a href="cerrar-sesion.php" class="nav-link">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <h2>Información del Usuario</h2>
        <div>
            <p>
                La siguiente es la información registrada de tu cuenta
            </p>
            <table>
                <tr>
                    <td>Usuario:</td>
                    <td><?= $_SESSION['name'] ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?= $email ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>