<?php
session_start();
//credenciales de acceso a la base datos
include 'conexionDB.php';
global $con;
// conexion a la base de datos
// Se valida si se ha enviado información, con la función isset()
if (!isset($_POST['username'], $_POST['password'])) {
    // si no hay datos muestra error y re direccionar
    header('Location: index.html');
}
// evitar inyección sql
if ($stmt = $con->prepare('SELECT id_user,password FROM cuentas WHERE username = ?')) {
    // parámetros de enlace de la cadena s
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
}
// acá se valida si lo ingresado coincide con la base de datos
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id_user, $password);
    $stmt->fetch();
    // se confirma que la cuenta existe ahora validamos la contraseña
    if ($_POST['password'] === $password) {
        // la conexion sería exitosa, se crea la sesión
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id_user'] = $id_user;
        header('Location: inicio.php');
    }
} else {
    // usuario incorrecto
    header('Location: index.html');
}
$stmt->close();
