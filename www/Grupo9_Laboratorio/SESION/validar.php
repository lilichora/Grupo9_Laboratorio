<?php
require_once "../CRUD/constantes.php";
session_start();
$username = $_POST['usu'];
$password = $_POST['contra'];
$simular2fa = isset($_POST['simular_2fa']) ? $_POST['simular_2fa'] : 'off';

// Verificar si se está simulando 2FA
if ($simular2fa == 'on') {
    // Conectar a la base de datos
    $conexion = mysqli_connect(SERVER, USER, PASS, BD);
    $consulta = "SELECT * FROM usuarios WHERE Nombre = '$username' and Password = '$password'";
    $resultado = mysqli_query($conexion, $consulta);

    $filas = mysqli_num_rows($resultado);

    
    if ($filas > 0) {
        $_SESSION['login'] = $username;
        $row = $resultado->fetch_assoc();
        $_SESSION["TipoUsuario"] = $row['Rol'];

        // Redireccionar según el tipo de usuario
        if ($_SESSION["TipoUsuario"] == 1) {
            header("location:../crud/clases/principal/principal.php");
        } elseif ($_SESSION["TipoUsuario"] == 2){
            header("location:../ClasesMed/Principal/principalMedico.php");
        }elseif ($_SESSION["TipoUsuario"] == 3) {
            header("location:../ClasesPac/Principal/principalPaciente.php");
        }
        exit;
    } else {
        header("Refresh: 4;URL= login.php");
        echo '<h1 style="color: red; font-size: 24px; text-align: center; margin-top: 20px;">NO SE PUDO INGRESAR, INTENTE DE NUEVO</h1>';
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
} else {
    // Mensaje de error si el checkbox no está marcado
    echo '<h1 style="color: red; font-size: 24px; text-align: center; margin-top: 20px;">Por favor, active el Check de Seguridad</h1>';
}
?>
