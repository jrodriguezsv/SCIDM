<?php
	session_name("SCIDM");
	session_start();
	
	if (empty($_SESSION['idusuario']) || empty($_SESSION['idrol_usuario'])){
		header( "location: ../" );
	}
?>