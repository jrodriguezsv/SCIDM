<?php
	require "../conexion/conexion.php";

	$codigo_usuario = $_POST["codigo_usuario"];
	$password_usuario = $_POST["password_usuario"];
	$informacion = [];

	if ($codigo_usuario != "" && $password_usuario !=""){
		$row = login($codigo_usuario, $password_usuario, $conexion);
		if (!empty($row)){
			session_name("SCIDM");
			session_start();
			$_SESSION['idusuario'] = $row['idusuario'];
			$_SESSION['nombres_usuario'] = $row['nombres_usuario'];
			$_SESSION['apellidos_usuario'] = $row['apellidos_usuario'];
			$_SESSION['idrol_usuario'] = $row['idrol_usuario'];
			
			$informacion["respuesta"] = "CORRECTO";
			echo json_encode( $informacion );
		} else {
			$informacion["respuesta"] = "ERROR";
			echo json_encode( $informacion );
		}
	} else {
		$informacion["respuesta"] = "ERROR";
		echo json_encode( $informacion );
	}

	function login( $codigo_usuario, $password_usuario, $conexion ){
		$query = "SELECT * FROM usuario WHERE codigo_usuario = '$codigo_usuario' AND password_usuario = '$password_usuario'";
		$resultado = pg_query($conexion, $query);
		$row = pg_fetch_array($resultado);
		cerrar($conexion);
		return $row;
	}

	function verificar_resultado( $resultado ){
		if (!$resultado) {
			$informacion["respuesta"] = "ERROR";
		} else {
			$informacion["respuesta"] = "CORRECTO";
		}
		echo json_encode($informacion);
	}

	function cerrar( $conexion ){
		pg_close($conexion);
	}
?>