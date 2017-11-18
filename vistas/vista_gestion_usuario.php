<!-- Validación de sesión -->
<?php require "../login/validar.php"; ?>

<!-- Conexión a base de datos -->
<?php require "../conexion/conexion.php"; ?>

<!-- Datos de tabla: usuario -->
<?php 	$query = "SELECT * FROM usuario WHERE idusuario = ".$_SESSION['idusuario'];
		$resultado = pg_query( $conexion, $query );
		$row = pg_fetch_array( $resultado ); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>:: Sistema de Control de Inventario de Dispositivos Móviles - SCIDM ::</title>

	<?php include "../plantilla/meta.php"; ?>

	<?php include "../plantilla/estilos.php"; ?>

</head>
<body>

<!-- Contenido principal -->
<div class="container-fluid">

	<?php include "../plantilla/encabezado.php";?>

	<?php include "../plantilla/menu.php";?>	

	<!-- Mensajes de alert-->
	<div id="mensaje"></div>

	<!-- Contenido general -->
	<div class="col-md-3"></div>
	<div class="col-md-6 well bs-component">
		<form id="frmGestion_usuario" class="form-horizontal" role="form" data-toggle="validator" method="POST">
			<fieldset>
				<legend>Perfil de usuario</legend>
				<input type="hidden" id="opcion" name="opcion" value="modificar">
				<div class="form-group">
					<label for="codigo_usuario" class="col-lg-3 control-label">Codigo usuario</label>
					<div class="col-lg-9">
					<?php echo "<input type='text' class='form-control' id='codigo_usuario' name='codigo_usuario' value='".$row[1]."' readonly required>"; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="nombres_usuario" class="col-lg-3 control-label">Nombres</label>
					<div class="col-lg-9">
					<?php echo "<input type='text' class='form-control' id='nombres_usuario' name='nombres_usuario' value='".$row[2]."' required>"; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="nombres_usuario" class="col-lg-3 control-label">Apellido</label>
					<div class="col-lg-9">
					<?php echo "<input type='text' class='form-control' id='apellidos_usuario' name='apellidos_usuario' value='".$row[3]."' required>"; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-lg-3 control-label">Contraseña</label>
					<div class="col-lg-9">
						<input type="password" class="form-control" id="password_usuario" name="password_usuario" required>
					</div>
				</div>
				<div align="right">
					<button type="reset" class="btn btn-secondary">Limpiar</button>
					<button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="col-md-3"></div>

	<?php include "../plantilla/pie.php"; ?>

</div>

	<?php include "../plantilla/scripts.php"; ?>

	<!-- Centrado vertical DataTables -->
	<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	</style>

	<!-- Inicializar funciones -->
	<script>
	$(document).ready(function(){
		guardar();
		limpiar();
	});

	var guardar = function(){
		$("#frmGestion_usuario").on("submit", function(e){
			e.preventDefault();
			var frm = $(this).serialize();
			$.ajax({
				method: "POST",
				url: "../gestionDB/crud_gestion_usuario.php",
				data: frm
			}).done( function( info ){
				var json_info = JSON.parse( info );
				mostrar_mensaje( json_info );
				limpiar();
			});
		});
	}

	var limpiar = function(){
		$("#frmGestion_usuario #password_usuario").val("");
	}

	var mostrar_mensaje = function( informacion ){
		if ( informacion.respuesta == "CORRECTO" ){
			var texto = "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Éxito!</strong> Se han guardado los cambios correctamente.</p></div>";
		} else if ( informacion.respuesta == "ERROR" ){
			var texto = "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se a podido procesar la petición.</p></div>";
		} else if ( informacion.respuesta == "EXISTE" ){
			var texto = "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Advertencia!</strong> Este usuario ya está registrado.</p></div>";
		} else if ( informacion.respuesta == "VACIO" ){
			var texto = "<div class='alert alert-dismissible alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Advertencia!</strong> Verifique que los campos obligatorios no estén vacios.</p></div>";
		} else if ( informacion.respuesta == "OPCION_VACIA" ){
			var texto = "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Advertencia!</strong> Favor eliminar la caché del navegador.</p></div>";
		}

		$("#mensaje").html( texto );
		$("#mensaje").fadeOut(5000, function(){
			$(this).html("");
			$(this).fadeIn(3000);
		});
	}

	</script>

</body>
</html>