<!-- Validación de sesión -->
<?php require "../login/validar.php"; ?>

<!-- Conexión a base de datos -->
<?php require "../conexion/conexion.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>:: Sistema de Control de Inventario de Dispositivos Móviles - SCIDM ::</title>

	<?php include "meta.php"; ?>

	<?php include "estilos.php"; ?>

</head>
<body>

<!-- Contenido principal -->
<div class="container-fluid">

	<?php include "encabezado.php";?>

	<?php include "menu.php";?>	

	<!-- Contenido general -->
	<div class="row">
		<div class="col-md-12">

		<!-- Inicio -->
		<h4>Bienvenidos al sistema de inventario</h4>
		
		</div>
	</div>

	<?php include "pie.php"; ?>

</div>

	<?php include "scripts.php"; ?>

</body>
</html>