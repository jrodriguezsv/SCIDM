<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idestablecimiento = $_POST["idestablecimiento"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$nombre_establecimiento = $_POST["nombre_establecimiento"];
		$iddepartamento = $_POST["iddepartamento"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $nombre_establecimiento != "" and $iddepartamento != "") {
				$establecimiento_duplicado = verificar_establecimiento($nombre_establecimiento, $conexion);
				if ($establecimiento_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($nombre_establecimiento, $iddepartamento, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $nombre_establecimiento != "" and $iddepartamento != "") {
				modificar($idestablecimiento, $nombre_establecimiento, $iddepartamento, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idestablecimiento, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_establecimiento( $nombre_establecimiento, $conexion ){
		$query = "SELECT nombre_establecimiento FROM establecimiento WHERE UPPER(nombre_establecimiento) = UPPER('$nombre_establecimiento')";
		$resultado = pg_query($conexion, $query);
		$existe_establecimiento = pg_num_rows($resultado);
		return $existe_establecimiento;
	}

	function agregar( $nombre_establecimiento, $iddepartamento, $conexion ){
		$query = "INSERT INTO establecimiento (nombre_establecimiento, iddepartamento) VALUES ('$nombre_establecimiento','$iddepartamento')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar( $idestablecimiento, $nombre_establecimiento, $iddepartamento, $conexion ){
		$query = "UPDATE establecimiento SET nombre_establecimiento = '$nombre_establecimiento', iddepartamento = '$iddepartamento' WHERE idestablecimiento = '$idestablecimiento'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar( $idestablecimiento, $conexion ){
		$query = "DELETE FROM establecimiento WHERE idestablecimiento = $idestablecimiento";
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