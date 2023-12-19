<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<link rel="icon" type="image/x-icon" href="../assets/logo-vt.svg" />
	<link href="../assets/styles.css" rel="stylesheet" type="text/css" />
	<title>Login </title>
	<link
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
		crossorigin="anonymous"
	/>
	<meta charset="UTF-8">

</head>

<body style="background-image: url('../crud/images/veris.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">

	<?php

	require_once("../crud/constantes.php");

	$cn = conectar();

	// Obtener los nombres de usuario de la base de datos
	$query = "SELECT Nombre FROM usuarios WHERE Rol IN (1)";
	$resultado = $cn->query($query);

	// Generar las opciones del select con los nombres de usuario
	$options = '';
	while ($row = $resultado->fetch_assoc()) {
		$nombre = $row['Nombre'];
		$options .= "<option value='$nombre'>$nombre</option>";
	}

	$html = '

		<form action="validar.php" method="POST" class="content d-flex justify-content-center align-items-center vh-100">
			<div class="content d-flex justify-content-center align-items-center vh-25">
				<div class="bg-primary p-5 rounded-5 text-light shadow" style="width: 25rem">
					<div class="text-center fs-1 fw-bold">Login</div>
					<div class="d-flex justify-content-center">

						<div class="form-control">
							<select class="form-control" name="usu" required>
								<option value="" disabled selected>Selecciona un usuario</option>
								' . $options . '
							</select>
						</div>

					</div>
					<div class="mb-3">
						<label for="inputPassword">Password</label>
						<input type="password" class="form-control" name="contra" placeholder="Ejemplo: 123" required>
					</div>
				
					<div class="mb-3 form-check">
   						 <input type="checkbox" id="inputSimular2fa" class="form-check-input" name="simular_2fa">
    					<label for="inputSimular2fa">Autenticacion 2Fa</label>
					</div>
					
					<button class="btn btn-success w-100" type="submit" id="btnEnviar">
						Login
					</button>

					<br> <br>

					

				</div>
			</div>
		</form>

	';
	echo $html;
	session_start();

	function conectar()
	{

		$c = new mysqli(SERVER, USER, PASS, BD);

		if ($c->connect_errno) {
			die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
		} else {
		}

		$c->set_charset("utf8");
		return $c;
	}

	
	


	?>
               
	
	  
    </div>
		<div class="footer">
			
			<div class=" table">
			</div>
		</div>
		<script>
		//Hack to fix hover on element with inline color set on child element for facebook and email buttons
		var fb_button = document.getElementById("facebook_button_initial");
		var fb_text = document.getElementById("fbchkintxt");
		var email_button = document.getElementById("email_button_initial");
		var email_text = document.getElementById("emchkintxt");
		
		if(fb_button){
			fb_button.onmouseover = function(){
				fb_text.style.color = "#fff";
				
			};
			fb_button.onmouseout = function(){
				fb_text.style.color = "#000)";
				
			};
		}
		
		if(email_button){
			email_button.onmouseover = function(){
				email_text.style.color = "#000)";
				
			};
			email_button.onmouseout = function(){
				email_text.style.color = "#fff";
				
			};
		}
		</script>
	</body>
</html>