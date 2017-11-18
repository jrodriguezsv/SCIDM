<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idmodelo_tablet = $_POST["idmodelo_tablet"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$modelo_tablet = $_POST["modelo_tablet"];
		$idmarca_tablet = $_POST["idmarca_tablet"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $modelo_tablet != "" AND $idmarca_tablet != "" ) {
				$modelo_duplicado = verificar_modelo($modelo_tablet, $conexion);
				if ($modelo_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($modelo_tablet, $idmarca_tablet, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $modelo_tablet != "" AND $idmarca_tablet != "") {
				modificar($idmodelo_tablet, $modelo_tablet, $idmarca_tablet, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idmodelo_tablet, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_modelo( $modelo_tablet, $conexion ){
		$query = "SELECT modelo_tablet FROM modelo_tablet WHERE UPPER(modelo_tablet) = UPPER('$modelo_tablet')";
		$resultado = pg_query($conexion, $query);
		$existe_modelo = pg_num_rows($resultado);
		return $existe_modelo;
	}

	function agregar($modelo_tablet, $idmarca_tablet, $conexion){
		$query = "INSERT INTO modelo_tablet (modelo_tablet, idmarca_tablet) VALUES ('$modelo_tablet','$idmarca_tablet')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar($idmodelo_tablet, $modelo_tablet, $idmarca_tablet, $conexion){
		$query = "UPDATE modelo_tablet SET modelo_tablet = '$modelo_tablet', idmarca_tablet = '$idmarca_tablet' WHERE idmodelo_tablet = '$idmodelo_tablet'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar($idmodelo_tablet, $conexion){
		$query = "DELETE FROM modelo_tablet WHERE idmodelo_tablet = $idmodelo_tablet";
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