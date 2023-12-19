<?php
class pacientes{
	private $IdPaciente;
    private $IdUsuario;
    private $Nombre;
    private $Cedula;
    private $Edad;
    private $Genero;
    private $Estatura;
    private $Peso;

    private $con;

    function __construct($cn)
    {
        $this->con = $cn;
    }

		
		
//******** 3.1 METODO update_consulta() *****************


public function update_pacientes()
    {
        $this->IdPaciente = $_POST['IdPaciente'];
        $this->IdUsuario = $_POST['IdUsuario'];
        $this->Nombre = $_POST['Nombre'];
        $this->Cedula = $_POST['Cedula'];
        $this->Edad = $_POST['Edad'];
        $this->Genero = $_POST['Genero'];
        $this->Estatura = $_POST['Estatura'];
        $this->Peso = $_POST['Peso'];

        $sql = "UPDATE pacientes SET 
            IdUsuario = '$this->IdUsuario',
            Nombre = '$this->Nombre',
            Cedula = '$this->Cedula',
            Edad = '$this->Edad',
            Genero = '$this->Genero',
            `Estatura (cm)` = '$this->Estatura',
            `Peso (kg)` = '$this->Peso'
            WHERE IdPaciente = $this->IdPaciente;";


        echo $sql;
        //exit;
        if ($this->con->query($sql)) {
            echo $this->_message_ok("modificó");
        } else {
            echo $this->_message_error("al modificar");
        }

    }

	

//******** 3.2 METODO save_consulta() *****************	

public function save_pacientes()
{
$this->IdUsuario = $_POST['IdUsuario'];
$this->Nombre = $_POST['Nombre'];
$this->Cedula = $_POST['Cedula'];
$this->Edad = $_POST['Edad'];
$this->Genero = $_POST['Genero'];
$this->Estatura = $_POST['Estatura'];
$this->Peso = $_POST['Peso'];

$sql = "INSERT INTO pacientes (IdUsuario, Nombre, Cedula, Edad, Genero, `Estatura (cm)`, `Peso (kg)`) 
VALUES ('$this->IdUsuario', '$this->Nombre', '$this->Cedula', 
'$this->Edad', '$this->Genero', '$this->Estatura', '$this->Peso');";

        //echo $sql;
        //exit;
        if ($this->con->query($sql)) {
            echo $this->_message_ok("guardó");
        } else {
            echo $this->_message_error("guardar");
        }

}



//******** 3.3 METODO _get_name_File() *****************	
	
	private function _get_name_file($nombre_original, $tamanio){
		$tmp = explode(".",$nombre_original); //Divido el nombre por el punto y guardo en un arreglo
		$numElm = count($tmp); //cuento el número de elemetos del arreglo
		$ext = $tmp[$numElm-1]; //Extraer la última posición del arreglo.
		$cadena = "";
			for($i=1;$i<=$tamanio;$i++){
				$c = rand(65,122);
				if(($c >= 91) && ($c <=96)){
					$c = NULL;
					 $i--;
				 }else{
					$cadena .= chr($c);
				}
			}
		return $cadena . "." . $ext;
	}
	
	
//************* PARTE I ********************
	
	    
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
					// OPCION PARA GRABAR UN NUEVO consulta (id=0)
					$html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';
				
				}else{
					// OPCION PARA MODIFICAR UN consulta EXISTENTE
					$html .= ($defecto == $etiqueta)? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
				}
			
			$html .= '</tr>';
		}
		$html .= '
		</table>';
		return $html;
	}
	
	
//************* PARTE II ******************	

	public function get_form($IdPaciente = NULL){
		
        if ($IdPaciente == NULL) {
            // Aquí deberías inicializar todas las propiedades a NULL o valores predeterminados
            // según corresponda para evitar errores de variables no definidas más adelante
    
            $this->IdUsuario = NULL;
            $this->Nombre = NULL;
            $this->Cedula = NULL;
            $this->Edad = NULL;
            $this->Genero = NULL;
            $this->Estatura = NULL;
            $this->Peso = NULL;
    
            $flag = "enabled";
            $op = "new";
    
        } else {
    
            $sql = "SELECT * FROM pacientes WHERE IdPaciente=$IdPaciente;";
            $res = $this->con->query($sql);
            $row = $res->fetch_assoc();
    
            $num = $res->num_rows;
            if ($num == 0) {
                $mensaje = "tratar de actualizar la consulta con IdPaciente= " . $IdPaciente;
                echo $this->_message_error($mensaje);
            } else {
    
                $this->IdUsuario = $row['IdUsuario'];
    
                $flag = "enabled";
                $op = "update";
            }
        }
		
		
		$html = '
		<form name="consulta" method="POST" action="pacientes.php" enctype="multipart/form-data"  onsubmit="return validarFormulario();">
		
		<input type="hidden" name="IdPaciente" value="' . $IdPaciente  . '"> 
		<input type="hidden" name="op" value="' . $op  . '">
		<div class="container mt-5"> 
		<div class="table-responsive">
			<button class="btn btn-info mt-3"><a href="pacientes.php" style="color: white;">HOME</a></button>
				<table border="2"  class="table table-bordered table-hover table-primary  mx-auto">
			<tr>
				<th colspan="2" class="text-center align-middle">DATOS DE PACIENTE</th>
			</tr>

				<tr>
                            <td>Usuario Id:</td>
                            <td>' . $this->_get_combo_db("usuarios", "IdUsuario", "IdUsuario", "IdUsuario", $this->IdUsuario) . '</td>
                        </tr>
                        <tr>
                            <td>Nombre:</td>
                            <td><input type="text" size="12" name="Nombre" value="' . $this->Nombre . '" required></td>
                        </tr>
                        <tr>
                            <td>Cedula:</td>
                            <td><input type="text" size="12" name="Cedula" value="' . $this->Cedula . '" required></td>
                        </tr>
                        <tr>
                            <td>Edad:</td>
                            <td><input type="text" size="12" name="Edad" value="' . $this->Edad . '" required></td>
                        </tr>
                        <tr>
                            <td>Genero:</td>
                            <td>' . $this->_get_combo_db("pacientes", "Genero", "Genero", "Genero", $this->Genero) . '</td>
                        </tr>
                        <tr>
                            <td>Estatura (cm):</td>
                            <td><input type="text" size="12" name="Estatura" value="' . $this->Estatura . '" required></td>
                        </tr>
                        <tr>
                            <td>Peso (Kg):</td>
                            <td><input type="text" size="12" name="Peso" value="' . $this->Peso . '" required></td>
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
				<th colspan="8" class="text-center align-middle">Lista De Las Pacientes</th>
			</tr>
			<tr>
			<th colspan="8" class="text-center align-middle" ><a class="btn btn-outline-success" href="pacientes.php?d=' . $d_new_final . '">Nuevo</a></th>
			</tr>
			<tr>   
                <th class="text-center">Paciente Id</th>
                <th class="text-center">Usuario</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Cedula</th>
                <th class="text-center">Edad</th>
                <th class="text-center">Genero</th>
                <th class="text-center">Estatura (cm)</th>
                <th class="text-center">Peso (Kg)</th>
				<th colspan="3">Acciones</th>
				</tr>
			</div>
			</div>';
$sql = "SELECT pacientes.IdPaciente, usuarios.Nombre AS NombreUsuario,
        pacientes.Nombre,
        pacientes.Cedula,
        pacientes.Edad,
        pacientes.Genero,
        pacientes.`Estatura (cm)`,
        pacientes.`Peso (kg)` 
        FROM pacientes
        INNER JOIN usuarios ON pacientes.IdUsuario = usuarios.IdUsuario";
        
$res = $this->con->query($sql);
// Sin codificar <td><a href="index.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
while($row = $res->fetch_assoc()){
    $d_del = "del/" . $row['IdPaciente'];
    $d_del_final = base64_encode($d_del);
    $d_act = "act/" . $row['IdPaciente'];
    $d_act_final = base64_encode($d_act);
    $d_det = "det/" . $row['IdPaciente'];
    $d_det_final = base64_encode($d_det);                    
    $html .= '
        <tr>
            <td class="text-center">' . $row['IdPaciente'] . '</td>
            <td class="text-center">' . $row['NombreUsuario'] . '</td>
            <td class="text-center">' . $row['Nombre'] . '</td>
            <td class="text-center">' . $row['Cedula'] . '</td>
            <td class="text-center">' . $row['Edad'] . '</td>
            <td class="text-center">' . $row['Genero'] . '</td>
            <td class="text-center">' . $row['Estatura (cm)'] . '</td>
            <td class="text-center">' . $row['Peso (kg)'] . '</td>
            <!-- <td><button class="btn btn-outline-danger"><a href="pacientes.php?d=' . $d_del_final . '">Borrar</a></button></td> -->
            <td><button class="btn btn-outline-danger" disabled><a >Borrar</a></button></td>
            <td><button class="btn btn-outline-primary"><a href="pacientes.php?d=' . $d_act_final . '">Actualizar</a></button></td>
            <td><button class="btn btn-outline-dark"><a href="pacientes.php?d=' . $d_det_final . '">Detalle</a></button></td>
        </tr>';
}
		$html .= '  
		</table>';
		
		return $html;
		
	}
	
	
	public function get_detail_pacientes($IdPaciente){
		$sql = "SELECT pacientes.IdPaciente, usuarios.Nombre AS NombreUsuario,
                pacientes.Nombre, pacientes.Cedula,
                pacientes.Edad, pacientes.Genero,
                pacientes.`Estatura (cm)`, pacientes.`Peso (kg)`
                FROM pacientes
                INNER JOIN usuarios ON pacientes.IdUsuario = usuarios.IdUsuario
                WHERE IdPaciente = $IdPaciente;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();
		
		$num = $res->num_rows;


        //Si es que no existiese ningun registro debe desplegar un mensaje 
        //$mensaje = "tratar de eliminar el consulta con id= ".$id;
        //echo $this->_message_error($mensaje);
        //y no debe desplegarse la tablas
        
        if($num==0){
            $mensaje = "tratar de editar el consulta con IdPaciente= ".$IdPaciente;
            echo $this->_message_error($mensaje);
        }else{ 
				$html = '
				<div class="container">
						<table class="table table-bordered table-striped mx-auto" style="max-width: 800px;">
							<thead class="thead-dark">
								<tr>
									<th colspan="2" class="text-center">DATOS DE LA CONSULTA</th>
								</tr>
							</thead>
							<tbody>
                <tr>
                    <td>Id Paciente: </td>
                    <td>' . $row['IdPaciente'] . '</td>
                </tr>
                <tr>
                    <td>Nombre de Usuario: </td>
                    <td>' . $row['NombreUsuario'] . '</td>
                </tr>
                <tr>
                    <td>Nombre: </td>
                    <td>' . $row['Nombre'] . '</td>
                </tr>
                <tr>
                    <td>Cedula: </td>
                    <td>' . $row['Cedula'] . '</td>
                </tr>
                <tr>
                    <td>Edad: </td>
                    <td>' . $row['Edad'] . '</td>
                </tr>
                <tr>
                    <td>Genero: </td>
                    <td>' . $row['Genero'] . '</td>
                </tr>
                <tr>
                    <td>Estatura (cm): </td>
                    <td>' . $row['Estatura (cm)'] . '</td>
                </tr>
                <tr>
                    <td>Peso (kg): </td>
                    <td>' . $row['Peso (kg)'] . '</td>
                </tr>
				    <tr>
							<th colspan="2"><a class="btn btn-primary col-12 " href="consultas.php">Regresar</a></th>
						</tr>';

        $html .= '</tbody></table></div>';
		}
	}
	
	
	public function delete_pacientes($IdPaciente){
		$sql = "DELETE FROM pacientes WHERE IdPaciente=$IdPaciente;";
			if($this->con->query($sql)){
			echo $this->_message_ok("ELIMINÓ");
		}else{
			echo $this->_message_error("eliminar");
		}	
	}
	

	
//*************************	
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="pacientes.php">Regresar</a></th>
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
				<th><a href="pacientes.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//**************************	
	
} // FIN SCRPIT
?>