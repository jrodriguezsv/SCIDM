<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idusuario = $_SESSION['idusuario'];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "modificar"){
		$codigo_usuario = $_POST["codigo_usuario"];
		$nombres_usuario = $_POST["nombres_usuario"];
		$apellidos_usuario = $_POST["apellidos_usuario"];
		$password_usuario = $_POST["password_usuario"];
	}

	switch ( $opcion ) {
		case "modificar":
			if ( $codigo_usuario != "" AND $nombres_usuario != "" AND $apellidos_usuario != "" AND $password_usuario != "") {
				modificar($idusuario, $codigo_usuario, $nombres_usuario, $apellidos_usuario, $password_usuario, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function modificar($idusuario, $codigo_usuario, $nombres_usuario, $apellidos_usuario, $password_usuario, $conexion){
		$query = "UPDATE usuario SET codigo_usuario = '$codigo_usuario', nombres_usuario = '$nombres_usuario', apellidos_usuario = '$apellidos_usuario', password_usuario = '$password_usuario' WHERE idusuario = '$idusuario'";
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