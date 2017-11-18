<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idadmin_contrato = $_POST["idadmin_contrato"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$nombre_admin = $_POST["nombre_admin"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $nombre_admin != "" ) {
				$nombre_duplicado = verificar_nombre($nombre_admin, $conexion);
				if ($nombre_duplicado > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($nombre_admin, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $nombre_admin != "") {
				modificar($idadmin_contrato, $nombre_admin, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idadmin_contrato, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_nombre( $nombre_admin, $conexion ){
		$query = "SELECT nombre_admin FROM admin_contrato WHERE UPPER(nombre_admin) = UPPER('$nombre_admin')";
		$resultado = pg_query($conexion, $query);
		$existe_nombre = pg_num_rows($resultado);
		return $existe_nombre;
	}

	function agregar( $nombre_admin, $conexion ){
		$query = "INSERT INTO admin_contrato (nombre_admin) VALUES ('$nombre_admin')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar( $idadmin_contrato, $nombre_admin, $conexion ){
		$query = "UPDATE admin_contrato SET nombre_admin = '$nombre_admin' WHERE idadmin_contrato = '$idadmin_contrato'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar( $idadmin_contrato, $conexion ){
		$query = "DELETE FROM admin_contrato WHERE idadmin_contrato = $idadmin_contrato";
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