<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idmarca_tablet = $_POST["idmarca_tablet"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$marca_tablet = $_POST["marca_tablet"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $marca_tablet != "" ) {
				$marca_duplicado = verificar_marca($marca_tablet, $conexion);
				if ($marca_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($marca_tablet, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $marca_tablet != "" ) {
				modificar($idmarca_tablet, $marca_tablet, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idmarca_tablet, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_marca( $marca_tablet, $conexion ){
		$query = "SELECT marca_tablet FROM marca_tablet WHERE UPPER(marca_tablet) = UPPER('$marca_tablet')";
		$resultado = pg_query($conexion, $query);
		$existe_marca = pg_num_rows($resultado);
		return $existe_marca;
	}

	function agregar($marca_tablet, $conexion){
		$query = "INSERT INTO marca_tablet (marca_tablet) VALUES ('$marca_tablet')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar($idmarca_tablet, $marca_tablet, $conexion){
		$query = "UPDATE marca_tablet SET marca_tablet = '$marca_tablet' WHERE idmarca_tablet = '$idmarca_tablet'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar($idmarca_tablet, $conexion){
		$query = "DELETE FROM marca_tablet WHERE idmarca_tablet = $idmarca_tablet";
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