<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idfuente_financiamiento = $_POST["idfuente_financiamiento"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$nombre_financiamiento = $_POST["nombre_financiamiento"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $nombre_financiamiento != "" ) {
				$financiamiento_duplicado = verificar_financiamiento($nombre_financiamiento, $conexion);
				if ($financiamiento_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($nombre_financiamiento, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $nombre_financiamiento != "" ) {
				modificar($idfuente_financiamiento, $nombre_financiamiento, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idfuente_financiamiento, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_financiamiento( $nombre_financiamiento, $conexion ){
		$query = "SELECT nombre_financiamiento FROM fuente_financiamiento WHERE UPPER(nombre_financiamiento) = UPPER('$nombre_financiamiento')";
		$resultado = pg_query($conexion, $query);
		$existe_financiamiento = pg_num_rows($resultado);
		return $existe_financiamiento;
	}

	function agregar( $nombre_financiamiento, $conexion ){
		$query = "INSERT INTO fuente_financiamiento (nombre_financiamiento) VALUES ('$nombre_financiamiento')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar( $idfuente_financiamiento, $nombre_financiamiento, $conexion ){
		$query = "UPDATE fuente_financiamiento SET nombre_financiamiento = '$nombre_financiamiento' WHERE idfuente_financiamiento = '$idfuente_financiamiento'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar( $idfuente_financiamiento, $conexion ){
		$query = "DELETE FROM fuente_financiamiento WHERE idfuente_financiamiento = $idfuente_financiamiento";
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