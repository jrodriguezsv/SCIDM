<?php
	require ("../conexion/conexion.php");

	if (session_name("SCIDM") == true){
		session_start();
		session_destroy();
		header("location: ../");
	}
?>