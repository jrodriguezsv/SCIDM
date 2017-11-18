<?php
	require "../login/validar.php";
	require "../conexion/conexion.php";

	$query = "SELECT * FROM usuario usu INNER JOIN rol_usuario rol ON usu.idrol_usuario = rol.idrol_usuario ORDER BY idusuario DESC";
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