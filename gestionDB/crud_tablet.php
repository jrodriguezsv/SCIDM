<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$idtablet = $_POST["idtablet"];
	$opcion = $_POST["opcion"];
	$informacion = [];

	if ($opcion == "agregar" || $opcion == "modificar"){
		$numero_inventario = $_POST["numero_inventario"];
		$numero_serie = $_POST["numero_serie"];
		$idmodelo_tablet = $_POST["idmodelo_tablet"];
		$idcolor_tablet = $_POST["idcolor_tablet"];
		$idestado_tablet = $_POST["idestado_tablet"];
		$idpropietario_tablet = $_POST["idpropietario_tablet"];
		$idadmin_contrato = $_POST["idadmin_contrato"];
		$idestablecimiento = $_POST["idestablecimiento"];
		$idfuente_financiamiento = $_POST["idfuente_financiamiento"];
	}

	switch ( $opcion ) {
		case "agregar":
			if ( $numero_inventario != "" && $numero_serie !="" && $idmodelo_tablet !="" && $idcolor_tablet !="" && $idestado_tablet !="" && $idpropietario_tablet !="" && $idadmin_contrato !="" && $idestablecimiento !="" && $idfuente_financiamiento !="" ) {
				$tablet_duplicada = verificar_inventario($numero_inventario, $conexion);
				if ($tablet_duplicada > 0 ) {
					$informacion["respuesta"] = "EXISTE";
					echo json_encode( $informacion );
				} else {
					agregar($numero_inventario, $numero_serie, $idmodelo_tablet, $idcolor_tablet, $idestado_tablet, $idpropietario_tablet, $idadmin_contrato, $idestablecimiento, $idfuente_financiamiento, $conexion);
				}
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;

		case "modificar":
			if ( $numero_inventario != "" && $numero_serie !="" && $idmodelo_tablet !="" && $idcolor_tablet !="" && $idestado_tablet !="" && $idpropietario_tablet !="" && $idadmin_contrato !="" && $idestablecimiento !="" && $idfuente_financiamiento !="" ) {
				modificar($idtablet, $numero_inventario, $numero_serie, $idmodelo_tablet, $idcolor_tablet, $idestado_tablet, $idpropietario_tablet, $idadmin_contrato, $idestablecimiento, $idfuente_financiamiento, $conexion);
			} else {
				$informacion["respuesta"] = "VACIO";
				echo json_encode( $informacion );
			}
			break;
		
		case "eliminar":
			eliminar($idtablet, $conexion);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode( $informacion );
			break;
	}

	function verificar_inventario( $numero_inventario, $conexion ){
		$query = "SELECT numero_inventario FROM tablet WHERE numero_inventario = '$numero_inventario'";
		$resultado = pg_query($conexion, $query);
		$existe_tablet = pg_num_rows($resultado);
		return $existe_tablet;
	}

	function agregar( $numero_inventario, $numero_serie, $idmodelo_tablet, $idcolor_tablet, $idestado_tablet, $idpropietario_tablet, $idadmin_contrato, $idestablecimiento, $idfuente_financiamiento, $conexion ){
		$query = "INSERT INTO tablet (numero_inventario, numero_serie, idmodelo_tablet, idcolor_tablet, idestado_tablet, idpropietario_tablet, idadmin_contrato, idestablecimiento, idfuente_financiamiento) VALUES ('$numero_inventario', '$numero_serie', '$idmodelo_tablet', '$idcolor_tablet', '$idestado_tablet', '$idpropietario_tablet', '$idadmin_contrato', '$idestablecimiento', '$idfuente_financiamiento')";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function modificar( $idtablet, $numero_inventario, $numero_serie, $idmodelo_tablet, $idcolor_tablet, $idestado_tablet, $idpropietario_tablet, $idadmin_contrato, $idestablecimiento, $idfuente_financiamiento, $conexion ){
		$query = "UPDATE tablet	SET	numero_inventario = '$numero_inventario',
										numero_serie = '$numero_serie',
										idmodelo_tablet = '$idmodelo_tablet',
										idcolor_tablet = '$idcolor_tablet',
										idestado_tablet = '$idestado_tablet',
										idpropietario_tablet = '$idpropietario_tablet',
										idadmin_contrato = '$idadmin_contrato',
										idestablecimiento = '$idestablecimiento',
										idfuente_financiamiento = '$idfuente_financiamiento'
								WHERE 	idtablet = '$idtablet'";
		$resultado = pg_query($conexion, $query);
		verificar_resultado( $resultado );
		cerrar( $conexion );
	}

	function eliminar( $idtablet, $conexion ){
		$query = "DELETE FROM tablet WHERE idtablet = $idtablet";
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