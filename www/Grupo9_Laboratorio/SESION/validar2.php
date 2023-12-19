<?php
require_once "../CRUD/constantes.php";
session_start();
$username = $_POST['usu'];
$password = $_POST['contra'];

//Conectar a la base de datos
$conexion = mysqli_connect(SERVER, USER, PASS, BD);
$consulta = "SELECT * FROM usuarios WHERE Nombre = '$username' and Password = '$password'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado); //0 si no coincide, 1 o + si concidio

//var_dump($usuario);


if($filas>0){
    $_SESSION['login'] = $username;
    $row = $resultado->fetch_assoc();
    $_SESSION["TipoUsuario"] = $row['Rol'];
    if($_SESSION["TipoUsuario"]==1){
    header("location:../crud/clases/principal/principal.php");
} elseif ($_SESSION["TipoUsuario"] == 2){
    header("location:../ClasesMed/principalMedico.php");
}elseif ($_SESSION["TipoUsuario"] == 3) {
    header("location:../ClasesPac/principalPacientes.php");
}
} else {
    header("Refresh: 4;URL=login.php");
    echo '<h1 style="color: red; font-size: 24px; text-align: center; margin-top: 20px;">NO SE PUDO INGRESAR, INTENTE DE NUEVO</h1>';
}
mysqli_free_result($resultado);
mysqli_close($conexion);


?>