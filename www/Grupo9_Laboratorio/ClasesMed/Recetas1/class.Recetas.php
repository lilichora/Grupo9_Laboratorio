<?php
class receta{
	private $IdReceta;
	private $IdConsulta;
	private $IdMedicamento;
	private $Cantidad;
	private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}
		
		
//*********************** 3.1 METODO update_receta() **************************************************	
	
	public function update_receta(){
		$this-> IdReceta = $_POST['id'];
		$this->IdConsulta= $_POST['consulta'];
		$this->IdMedicamento = $_POST['medicamento'];
		$this->Cantidad = $_POST['cantidad'];
		
		
		
		
		//exit;
		$sql = "UPDATE recetas SET IdConsulta=$this->IdConsulta,
									IdMedicamento=$this->IdMedicamento,
									Cantidad='$this->Cantidad'
									
									

				WHERE IdReceta=$this->IdReceta;";
		echo $sql;
		//exit;

		if($this->con->query($sql)){
			echo $this->_message_ok("modificó");
		}else{
			echo $this->_message_error("al modificar");
		}								
										
	}
	

//*********************** 3.2 METODO save_receta() **************************************************	

	public function save_receta(){
        $this-> IdReceta = $_POST['id'];
		$this->IdConsulta= $_POST['consulta'];
		$this->IdMedicamento = $_POST['medicamento'];
		$this->Cantidad = $_POST['cantidad']; 
			/*	echo "<br> FILES <br>";    
				echo "<pre>";
					print_r($_FILES);
				echo "</pre>";*/
		
		$sql = "INSERT INTO recetas VALUES(NULL,
											$this->IdConsulta,
											$this->IdMedicamento,
											'$this->Cantidad');";
											

		//echo $sql;
		//exit;
		if($this->con->query($sql)){
			echo $this->_message_ok("guardó");
		}else{
			echo $this->_message_error("guardar");
		}								
										
	}
	
	
//*************************************** PARTE I ************************************************************
	
	    
	 //Aquí se agregó el parámetro:  $defecto/
	private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto){
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}
	

	/*Aquí se agregó el parámetro:  $defecto
	private function _get_combo_anio($nombre,$anio_inicial,$defecto){
		$html = '<select name="' . $nombre . '">';
		$anio_actual = date('Y');
		for($i=$anio_inicial;$i<=$anio_actual;$i++){
			$html .= ($i == $defecto)? '<option value="' . $i . '" selected>' . $i . '</option>' . "\n":'<option value="' . $i . '">' . $i . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}*/
	
	//Aquí se agregó el parámetro:  $defecto
	private function _get_radio($arreglo,$nombre,$defecto){
		
		$html = '
		<table border=0 align="left">';
		
		//CODIGO NECESARIO EN CASO QUE EL USUARIO NO SE ESCOJA UNA OPCION
		
		foreach($arreglo as $etiqueta){
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';
				
				if($defecto == NULL){
					// OPCION PARA GRABAR UN NUEVO receta (id=0)
					$html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';
				
				}else{
					// OPCION PARA MODIFICAR UN receta EXISTENTE
					$html .= ($defecto == $etiqueta)? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
				}
			
			$html .= '</tr>';
		}
		$html .= '
		</table>';
		return $html;
	}
	
	
//************************************* PARTE II ****************************************************	

	public function get_form($id=NULL){
		
		if($id == NULL){
			$this->IdReceta= NULL;
			$this->IdConsulta = NULL;
			$this->IdMedicamento = NULL;
			$this->Cantidad = NULL;
			
			
			$flag = NULL;  //VARIABLES AUXILIARES
			$op = "new";
			
		}else{

			$sql = "SELECT * FROM recetas WHERE IdReceta=$id;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de actualizar la receta con id= ".$id;
                echo $this->_message_error($mensaje);
            }else{   
			
              // ***** TUPLA ENCONTRADA *****
				echo "<br>TUPLA <br>";
				echo "<pre>";
					print_r($row);
				echo "</pre>";
			
				$this->IdReceta = $row['IdReceta'];
				$this->IdConsulta = $row['IdConsulta'];
				$this->IdMedicamento = $row['IdMedicamento'];
				$this->Cantidad = $row['Cantidad'];
				
				
				$flag = "disabled";
				$op = "update";
			}
		}
		
		
		
		$html = '
		<form name="receta" method="POST" action="recetas.php" enctype="multipart/form-data">
		
		<input type="hidden" name="id" value="' . $id  . '"> //
		<input type="hidden" name="op" value="' . $op  . '">
		<div class="container mt-5"> 
		<div class="table-responsive">
			<button class="btn btn-info mt-3"><a href="recetas.php" style="color: white;">HOME</a></button>
				<table border="2"  class="table table-bordered table-hover table-primary  mx-auto">
			<tr>
				<th colspan="2" class="text-center align-middle">DATOS DE LA RECETA</th>
			</tr>
				<tr>
					<td>Consulta:</td>
					<td>' . $this->_get_combo_db("consultas","IdConsulta","Diagnostico","consulta",$this->IdConsulta) . '</td>
				</tr>
				<tr>
					<td>Medicamento:</td>
					<td>' . $this->_get_combo_db("medicamentos","IdMedicamento","Nombre","medicamento",$this->IdMedicamento ) . '</td>
				</tr>
			
				<tr>
					<td>Cantidad:</td>
					<td><input type="number" min=1 max=100 name="cantidad" value="' . $this->Cantidad . '" required></td>
				</tr>
				<tr>
						 <th colspan="2" class="text-center">
							 <input type="submit" class="btn btn-primary" name="Guardar" value="GUARDAR">
						 </th>
					 </tr>													
					 </table>
					 </div>
				 </div>';
		return $html;
	}
	
	

	public function get_list(){
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '
		<div class="container mt-5"> 
    	<div class="table-responsive"> 
		
		    
			<table  class="table table-bordered table-hover table-info mx-auto "   >
			<tr>
				<th colspan="8" class="text-center align-middle">Lista De Las Recetas</th>
			</tr>
			<tr>
			<th colspan="8" class="text-center align-middle" ><a class="btn btn-outline-success" href="recetas.php?d=' . $d_new_final . '">Nuevo</a></th>
			</tr>
			<tr>
				<th>Paciente</th>
				<th>Diagnostico</th>
				<th>Medicamento</th>
				<th>Tipo de Medicamento</th>
				<th>Cantidad</th>
				<th colspan="3">Acciones</th>
			</tr>
			</div>
			</div>';
		$sql = "SELECT r.IdReceta,p.nombre Paciente, p.diagnostico Diagnostico, m.Nombre Medicamento, m.Tipo TipoMedicamento, r.Cantidad FROM recetas r 
		INNER JOIN medicamentos m ON (m.IdMedicamento = r.IdMedicamento) INNER JOIN (SELECT c.IdConsulta consulta, p.Nombre nombre, c.Diagnostico diagnostico 
		FROM consultas c LEFT JOIN pacientes p ON (c.IdPaciente=p.IdPaciente)) p ON (p.consulta = r.IdConsulta);";	
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
		while($row = $res->fetch_assoc()){
			$d_del = "del/" . $row['IdReceta'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['IdReceta'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['IdReceta'];
			$d_det_final = base64_encode($d_det);					
			$html .= '
				<tr>
					<td>' . $row['Paciente'] . '</td>
					<td>' . $row['Diagnostico'] . '</td>
					<td>' . $row['Medicamento'] . '</td>
					<td>' . $row['TipoMedicamento'] . '</td>
					<td>' . $row['Cantidad'] . '</td>
					<!-- <td><button class="btn btn-outline-danger" disabled><a href="recetas.php?d=' . $d_del_final . '">Borrar</a></button></td> -->
					<td><button class="btn btn-outline-danger" disabled><a>Borrar</a></button></td>
					<td><button class="btn btn-outline-primary"><a href="recetas.php?d=' . $d_act_final . '">Actualizar</a></button></td>
					<td><button class="btn btn-outline-dark"><a href="recetass.php?d=' . $d_det_final . '">Detalle</a></button></td>
				</tr>';
		}
		$html .= '  
		</table>';
		
		return $html;
		
	}
	
	
	public function get_detail_receta($id){
		$sql = "SELECT r.IdReceta,p.nombre Paciente, p.diagnostico Diagnostico, m.Nombre Medicamento, m.Tipo TipoMedicamento, r.Cantidad FROM recetas r 
		INNER JOIN medicamentos m ON (m.IdMedicamento = r.IdMedicamento) INNER JOIN (SELECT c.IdConsulta consulta, p.Nombre nombre, c.Diagnostico diagnostico 
		FROM consultas c LEFT JOIN pacientes p ON (c.IdPaciente=p.IdPaciente)) p ON (p.consulta = r.IdConsulta)
		WHERE r.IdReceta = $id;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();
		
		$num = $res->num_rows;


        //Si es que no existiese ningun registro debe desplegar un mensaje 
        //$mensaje = "tratar de eliminar el receta con id= ".$id;
        //echo $this->_message_error($mensaje);
        //y no debe desplegarse la tablas
        
        if($num==0){
            $mensaje = "tratar de editar el receta con id= ".$id;
            echo $this->_message_error($mensaje);
        }else{ 
				$html = '
				<div class="container">
						<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
							<thead class="thead-dark">
								<tr>
									<th colspan="2" class="text-center">DATOS DE LA RECETA</th>
								</tr>
							</thead>
							<tbody>
					<tr>
						<td>Paciente: </td>
						<td>'. $row['Paciente'] .'</td>
					</tr>
					<tr>
						<td>Diagnostico: </td>
						<td>'. $row['Diagnostico'] .'</td>
					</tr>
					<tr>
						<td>Nombre del Medicamento: </td>
						<td>'. $row['Medicamento'] .'</td>
					</tr>
					<tr>
						<td>Tipo de Medico : </td>
						<td>'. $row['TipoMedicamento'] .'</td>
					</tr>
					<tr>
						<td>Cantidad: </td>
						<td>'. $row['Cantidad'] .'</td>
					</tr>
					<tr>
							<th colspan="2"><a class="btn btn-primary col-12 " href="recetas.php">Regresar</a></th>
						</tr>';

        $html .= '</tbody></table></div>';
				
				return $html;
		}
	}
	
	
	public function delete_receta($id){
		$sql = "DELETE FROM recetas WHERE IdReceta=$id;";
			if($this->con->query($sql)){
			echo $this->_message_ok("ELIMINÓ");
		}else{
			echo $this->_message_error("eliminar");
		}	
	}
	

	
//*************************************************************************	
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="recetas.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="recetas.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//****************************************************************************	
	
} // FIN SCRPIT
?>