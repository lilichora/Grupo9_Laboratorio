<?php
class medico
{
	private $IdMedico;
	private $nombre;
	private $especialidad;
	private $IdUsuario;
	private $con;

	function __construct($cn)
	{
		$this->con = $cn;
	}


	//*********************** 3.1 METODO update_consulta() **************************************************	

	public function update_medico()
	{
		$this->IdMedico = $_POST['IdMedico'];
		$this->nombre = $_POST['nombre'];
		$this->especialidad = $_POST['espCMB'];
		$this->IdUsuario = $_POST['IdUsuarioCMB'];

		$sql = "UPDATE medicos SET nombre='$this->nombre',
									especialidad='$this->especialidad',
									idUsuario='$this->IdUsuario'
				WHERE IdMedico=$this->IdMedico;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}
	}


	//*********************** 3.2 METODO save_consulta() **************************************************	

	public function save_medico()
	{
		$this->nombre = $_POST['nombre'];
		$this->especialidad = $_POST['espCMB'];
		$this->IdUsuario = $_POST['IdUsuarioCMB'];

		/*PRUEBA DE ESCRITORIO*/ /*MANIPULACION DE LA FOTO*/
		/*echo "<br> FILES <br>";
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";*/

		if ($this->IdUsuario == 12) {
			echo $this->_message_warning("Recuerde crear un usuario nuevo para este medico antes de guardar.");
		} else {
			$sql = "INSERT INTO medicos VALUES(NULL,
											'$this->nombre',
											'$this->especialidad',
											'$this->IdUsuario');";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("guardó");
		} else {
			echo $this->_message_error("guardar");
		}
		}
	}


	//*************************************** PARTE I ************************************************************


	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_combo_db($tabla, $valor, $etiqueta, $nombre, $defecto)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_radio($arreglo, $nombre, $defecto)
	{

		$html = '
		<table border=0 align="left">';

		//CODIGO NECESARIO EN CASO QUE EL USUARIO NO SE ESCOJA UNA OPCION

		foreach ($arreglo as $etiqueta) {
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';

			if ($defecto == NULL) {
				// OPCION PARA GRABAR UN NUEVO CONSULTA (IdMedico=0)
				$html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';
			} else {
				// OPCION PARA MODIFICAR UN CONSULTA EXISTENTE
				$html .= ($defecto == $etiqueta) ? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
			}

			$html .= '</tr>';
		}
		$html .= '
		</table>';
		return $html;
	}


	//************************************* PARTE II ****************************************************	

	public function get_form($IdMedico = NULL)
	{

		if ($IdMedico == NULL) {
			$this->nombre = NULL;
			$this->especialidad = NULL;
			$this->IdUsuario = NULL;
			
			$flag = NULL;
			$op = "new";
		} else {
			$sql = "SELECT me.IdMedico, me.Nombre as nombre, e.Descripcion as especialidad, u.Nombre as IdUsuario  
					FROM medicos me, especialidades e, usuarios u 
					WHERE me.Especialidad = e.IdEsp AND u.IdUsuario = me.IdUsuario AND IdMedico=$IdMedico;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar el consulta con IdMedico= " . $IdMedico;
				echo $this->_message_error($mensaje);
			} else {

				// ***** TUPLA ENCONTRADA *****
				/*echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>";*/

				$this->nombre = $row['nombre'];
				$this->especialidad = $row['especialidad'];
				$this->IdUsuario = $row['IdUsuario'];
				
				$flag = "disabled";
				$op = "update";
			}
		}

		$html = '
		<form name="medico" method="POST" action="index.php" enctype="multipart/form-data">
		
		<input type="hidden" name="IdMedico" value="' . $IdMedico  . '">
		<input type="hidden" name="op" value="' . $op  . '">
		
		<div class="container mt-5"> 
    	<div class="table-responsive">
		<button class="btn btn-info mt-3"><a href="index.php" style="color: white;">HOME</a></button>
			<table border="2"  class="table table-bordered table-hover table-primary  mx-auto">
					<th colspan="2" class="text-center align-middle  table-info">DATOS DE LOS MEDICOS</th>
				</tr>
				<tr>
					<td>Nombre:</td>
					<td><input type="text" size="30" name="nombre" value="' . $this->nombre . '" required></td>
				</tr>
				<tr>
					<td>Especialidad:</td>
					<td>' . $this->_get_combo_db("especialidades", "IdEsp", "Descripcion", "espCMB", $this->especialidad) . '</td>
				</tr>
				<tr>
					<td>Usuario:</td>
					<td>' . $this->_get_combo_db("usuarios", "IdUsuario", "Nombre", "IdUsuarioCMB", $this->IdUsuario) . '</td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="Guardar" value="GUARDAR"></th>
					</tr>												
					</table>
					</div>
					</div>
					</div>
					</form>';
		return $html;
	}



	public function get_list()
	{
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '
	
		<div class="container mt-5"> 
    	<div class="table-responsive"> 
		<button class="btn btn-info mt-3"><a href="index.html" style="color: white;">HOME</a></button>
		    
			<table  class="table table-bordered table-hover table-info mx-auto "   >
			<tr>
				<th colspan="8" class="text-center align-middle">LISTA DE MEDICOS</th>
			</tr>
			<tr>
			<th colspan="8" class="text-center align-middle"><button type="button" class="btn btn-light"><a href="index.php?d=' . $d_new_final . '">Nuevo</a></th>
			</tr>
											<tr>
												<th>Nombre</th>
												<th>Especialidad</th>
												<th colspan="3">Acciones</th>
												</tr>
												</div>
												</div>';
		$sql = "SELECT me.IdMedico, me.Nombre as nombre, e.Descripcion as especialidad, u.Nombre as IdUsuario 
		FROM medicos me, especialidades e, usuarios u 
		WHERE me.Especialidad = e.IdEsp AND u.IdUsuario = me.IdUsuario;";

		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&IdMedico=' . $row['IdMedico'] . '">Borrar</a></td>
		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdMedico'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['IdMedico'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['IdMedico'];
			$d_det_final = base64_encode($d_det);
			$html .= '
				<tr>
					<td>' . $row['nombre'] . '</td>
					<td>' . $row['especialidad'] . '</td>

					<td class="text-center"><a href="index.php?d=' . $d_act_final . '" class="btn btn-warning">Actualizar</a></td>
					<td class="text-center"><a href="index.php?d=' . $d_det_final . '" class="btn btn-info">Detalle</a></td>
					<td class="text-center"><a href="index.php?d=' . $d_del_final . '" class="btn btn-danger">Borrar</a></td>
				</tr>
				';
		}
		$html .= '  
	
		</table>
</div>

</div>';

		return $html;
	}


	public function get_detail_medico($IdMedico)
	{
		$sql = "SELECT me.IdMedico, me.Nombre as nombre, e.Descripcion as especialidad, u.Nombre as IdUsuario, u.Foto as foto  
		FROM medicos me, especialidades e, usuarios u 
		WHERE me.Especialidad = e.IdEsp AND u.IdUsuario = me.IdUsuario AND IdMedico=$IdMedico;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();

		$num = $res->num_rows;

		//Si es que no existiese ningun registro debe desplegar un mensaje 
		//$mensaje = "tratar de eliminar el consulta con IdMedico= ".$IdMedico;
		//echo $this->_message_error($mensaje);
		//y no debe desplegarse la tablas

		if ($num == 0) {
			$mensaje = "tratar de editar el consulta con IdMedico= " . $IdMedico;
			echo $this->_message_error($mensaje);
		} else {
			$html = '
			<div class="container mt-5"> 
    			<div class="table-responsive">
				<button class="btn btn-info mt-3"><a href="index.php" style="color: white;">HOME</a></button>
				<table class="table table-bordered table-hover table-primary mx-auto">
                <tr>
						<th colspan="2"  class="text-center table-info">DATOS DE LOS MEDICOS</th>
					</tr>
                        <tr>
						<td>Nombre: </td>
						<td>' . $row['nombre'] . '</td>
					</tr>
					<tr>
						<td>Especialidad: </td>
						<td>' . $row['especialidad'] . '</td>
					</tr>	
					<tr>
						<td>Usuario: </td>
						<td>' . $row['IdUsuario'] . '</td>
					</tr>	
					
						<th colspan="2"><a href="index.php">Regresar</a></th>
						</tr>																						
						</table>
						</div>
						</div>
				</div>';
						
						return $html;
				}
			}


	public function delete_medico($IdMedico)
	{
		$sql = "DELETE FROM medicos WHERE IdMedico=$IdMedico;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("ELIMINÓ");
		} else {
			echo $this->_message_error("eliminar");
		}
	}

	//*************************************************************************

	private function _get_especialidad_medico($nombre)
	{
		$sql = "SELECT Especialidad FROM medicos WHERE nombre = $nombre";
		$result = $this->con->query($sql);

		if ($result) {
			$row = $result->fetch_assoc();
			return $row['especialidad'];
		}

		return null;
	}

	//*************************************************************************	

	private function _message_error($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}


	private function _message_ok($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

	private function _message_warning($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th> ' . $tipo . ' </th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

	//****************************************************************************	

} // FIN SCRPIT
