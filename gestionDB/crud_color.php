<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idcolor_tablet = $_POST["idcolor_tablet"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$color_tablet = $_POST["color_tablet"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $color_tablet != "" ) {
				$color_duplicado = verificar_color($color_tablet, $conexion);
				if ($color_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($color_tablet, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $color_tablet != "" ) {
				modificar($idcolor_tablet, $color_tablet, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idcolor_tablet, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_color( $color_tablet, $conexion ){
		$query = "SELECT color_tablet FROM color_tablet WHERE UPPER(color_tablet) = UPPER('$color_tablet')";
		$resultado = pg_query($conexion, $query);
		$existe_color = pg_num_rows($resultado);
		return $existe_color;
	}

	function agregar( $color_tablet, $conexion ){
		$query = "INSERT INTO color_tablet (color_tablet) VALUES ('$color_tablet')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar( $idcolor_tablet, $color_tablet, $conexion ){
		$query = "UPDATE color_tablet SET color_tablet = '$color_tablet' WHERE idcolor_tablet = '$idcolor_tablet'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar( $idcolor_tablet, $conexion ){
		$query = "DELETE FROM color_tablet WHERE idcolor_tablet = $idcolor_tablet";
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