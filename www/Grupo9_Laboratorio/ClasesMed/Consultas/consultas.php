<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>CONSULTAS</title>
	<!-- Agrega los enlaces a los archivos de Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<style>
        
        .jumbotron{
        	color: aliceblue;
        	background: #000 url("../../assets/imagenes/header5.jpg");
        	background-size: cover;
        	overflow: hidden;      
        }
        </style>
	<?php
		require_once("../constantes.php");
		include_once("class.consultas.php");

		$cn = conectar();
		$v = new consulta($cn);
		
		if(isset($_GET['d'])){
			$dato = base64_decode($_GET['d']);
		//	echo $dato;exit;
			$tmp = explode("/", $dato);
			$op = $tmp[0];
			$id = $tmp[1];
			
			if($op == "del"){
				echo $v->delete_consulta($id);
			}elseif($op == "det"){
				echo $v->get_detail_consulta($id);
			}elseif($op == "new"){
				echo $v->get_form();
			}elseif($op == "act"){
				echo $v->get_form($id);
			}
			
       // PARTE III	
		}else{
			 /*  
				echo "<br>PETICION POST <br>";
				echo "<pre>";
					print_r($_POST);
				echo "</pre>";
		      */
			if(isset($_POST['Guardar']) && $_POST['op']=="new"){
				$v->save_consulta();
			}elseif(isset($_POST['Guardar']) && $_POST['op']=="update"){
				$v->update_consulta();
			}else{
				echo $v->get_list();
			}	
		}
		
	//*******************************************************
		function conectar(){
			//echo "<br> CONEXION A LA BASE DE DATOS<br>";
			$c=new mysqli(SERVER,USER,PASS,BD);
			
			if($c->connect_errno) {
				die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
			}else{
				//echo "La conexión tuvo éxito .......<br><br>";
			}
			
			$c->set_charset("utf8");
			return $c;
		}
	//**********************************************************	

		
	?>	
<!-- footer section -->
<footer class="footer_section">
   
   <div class="footer-info">
	 <p>
	   &copy; <span id="displayYear"></span> All Rights Reserved By
	   <a href="https://html.design/">Free Html Templates<br><br></a>
		 &copy; <span id="displayYear"></span> Distributed By
		 <a href="https://themewagon.com/">ThemeWagon</a>
	 </p>
   </div>
 
</footer>
<!-- footer section -->

<!-- jQery -->
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<!-- bootstrap js -->
<script type="text/javascript" src="../js/bootstrap.js"></script>
<!-- owl slider -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!-- custom js -->
<script type="text/javascript" src="../js/custom.js"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
</script>
<!-- End Google Map -->
</body>

</html>