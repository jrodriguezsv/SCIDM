<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$query = "SELECT * FROM admin_contrato ORDER BY idadmin_contrato DESC";
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
