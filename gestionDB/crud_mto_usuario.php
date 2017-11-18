<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idusuario = $_POST["idusuario"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$codigo_usuario = $_POST["codigo_usuario"];
		$nombres_usuario = $_POST["nombres_usuario"];
		$apellidos_usuario = $_POST["apellidos_usuario"];
		$password_usuario = $_POST["password_usuario"];
		$idrol_usuario = $_POST["idrol_usuario"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $codigo_usuario != "" AND $nombres_usuario != "" AND $apellidos_usuario != "" AND $password_usuario != "" AND $idrol_usuario != "") {
				$usuario_duplicado = verificar_usuario($codigo_usuario, $conexion);
				if ($usuario_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($codigo_usuario, $nombres_usuario, $apellidos_usuario, $password_usuario, $idrol_usuario, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $codigo_usuario != "" AND $nombres_usuario != "" AND $apellidos_usuario != "" AND $password_usuario != "" AND $idrol_usuario != "") {
				modificar($idusuario, $codigo_usuario, $nombres_usuario, $apellidos_usuario, $password_usuario, $idrol_usuario, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idusuario, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_usuario( $codigo_usuario, $conexion ){
		$query = "SELECT codigo_usuario FROM usuario WHERE UPPER(codigo_usuario) = UPPER('$codigo_usuario')";
		$resultado = pg_query($conexion, $query);
		$existe_establecimiento = pg_num_rows($resultado);
		return $existe_establecimiento;
	}

	function agregar($codigo_usuario, $nombres_usuario, $apellidos_usuario, $password_usuario, $idrol_usuario, $conexion){
		$query = "INSERT INTO usuario (codigo_usuario, nombres_usuario, apellidos_usuario, password_usuario, idrol_usuario) VALUES ('$codigo_usuario','$nombres_usuario','$apellidos_usuario','$password_usuario','$idrol_usuario')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar($idusuario, $codigo_usuario, $nombres_usuario, $apellidos_usuario, $password_usuario, $idrol_usuario, $conexion){
		$query = "UPDATE usuario SET codigo_usuario = '$codigo_usuario',nombres_usuario = '$nombres_usuario', apellidos_usuario = '$apellidos_usuario' ,password_usuario = '$password_usuario' ,idrol_usuario = '$idrol_usuario' WHERE idusuario = '$idusuario'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar($idusuario, $conexion){
		$query = "DELETE FROM usuario WHERE idusuario = $idusuario";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function verificar_resultado( $resultado ){
		if (!$resultado) {
			$informacion["respuesta"] = "ERROR";
		} else {
			$informacion["respuesta"] = "CORRECTO";
		}
		echo json_encode( $informacion );
	}

	function cerrar( $conexion ){
		pg_close( $conexion );
	}
?>