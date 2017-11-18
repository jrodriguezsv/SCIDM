<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$query = "SELECT * FROM tablet tab
				INNER JOIN modelo_tablet modt ON tab.idmodelo_tablet = modt.idmodelo_tablet
				INNER JOIN color_tablet colt ON tab.idcolor_tablet = colt.idcolor_tablet
				INNER JOIN propietario_tablet prot ON tab.idpropietario_tablet = prot.idpropietario_tablet
				INNER JOIN establecimiento est ON tab.idestablecimiento = est.idestablecimiento
				INNER JOIN estado_tablet estt ON tab.idestado_tablet = estt.idestado_tablet
				INNER JOIN admin_contrato admc ON tab.idadmin_contrato = admc.idadmin_contrato
				INNER JOIN fuente_financiamiento ffi ON tab.idfuente_financiamiento = ffi.idfuente_financiamiento
				ORDER BY tab.idtablet DESC";
	$resultado = pg_query( $conexion, $query );

	if ( !$resultado ) {
		die( "Error" );
	} else {
		while ( $data = pg_fetch_assoc( $resultado ) ) {
			$arreglo["data"][] = $data;
		}
		echo json_encode( $arreglo );
	}

	pg_free_result( $resultado );
	pg_close( $conexion );
?>