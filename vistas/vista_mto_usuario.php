<!-- Validación de sesión -->
<?php require "../login/validar.php"; ?>

<!-- Conexión a base de datos -->
<?php require "../conexion/conexion.php"; ?>

<?php if ($_SESSION['idrol_usuario'] == 1){ ?>

<?php
$query = "SELECT * FROM rol_usuario ORDER BY rol_usuario DESC";
$resultado = pg_query( $conexion, $query );
?>

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

	<!-- Contenido general -->
	<div class="row">
		<div class="col-md-12">

		<h4 align="center">Mantenimiento de Usuario</h4>
		<div id="mensaje"></div>

		<!-- Inicio -->
		<div id="contenedor" align="center">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Codigo usuario</th>
						<th>Nombres</th>
						<th>Apellidos</th>
						<th>Contraseña</th>
						<th>Rol</th>
						<th>Acciones</th>
					</tr>
				</thead>
			</table>
		</div><br>

		</div>
	</div>

	<!-- Modal formulario usuario -->
	<div class="modal fade" id="modalfrmMto_usuario" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="frmMto_usuario" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 class="modal-title">Formulario de Usuario</h3>
						<input type="hidden" id="idusuario" name="idusuario" value="0">
						<input type="hidden" id="opcion" name="opcion" value="agregar">
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div id="mensaje"></div>
								<div class="form-group">
									<label for="mto_usuario">
										Codigo usuario
									</label>
									<input type="text" class="form-control" id="codigo_usuario" name="codigo_usuario" required />
								</div>
								<div class="form-group">
									<label for="mto_usuario">
										Nombres
									</label>
									<input type="text" class="form-control" id="nombres_usuario" name="nombres_usuario" required />
								</div>
								<div class="form-group">
									<label for="mto_usuario">
										Apellidos
									</label>
									<input type="text" class="form-control" maxlength="45" id="apellidos_usuario" name="apellidos_usuario" required />
								</div>
								<div class="form-group">
									<label for="mto_usuario">
										Contraseña
									</label>
									<input type="text" class="form-control" maxlength="45" id="password_usuario" name="password_usuario" required />
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Rol usuario</label>
									<select class="form-control" id="idrol_usuario" name="idrol_usuario" required>
									<?php
										/* Llenado de lista roles */
										while ($row = pg_fetch_array($resultado)) {
											echo "<option value='".$row['idrol_usuario']."'>".$row['rol_usuario']."</option>";
										}
									?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal eliminar usuario -->
	<div class="modal fade" id="modalfrmEliminar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="frmEliminarmto_usuario" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Eliminar Registro</h4>
						<input type="hidden" id="idusuario" name="idusuario" value="0">
						<input type="hidden" id="opcion" name="opcion" value="eliminar">
					</div>
					<div class="modal-body">
						<p>¿Desea eliminar este registro?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-danger" id="btnEliminar" data-dismiss="modal">Eliminar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

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
		listar();
		guardar();
		eliminar();
		limpiar();
	});

	var guardar = function(){
		$("#frmMto_usuario").on("submit", function(e){
			e.preventDefault();
			var frm = $(this).serialize();
			$.ajax({
				method: "POST",
				url: "../gestionDB/crud_mto_usuario.php",
				data: frm
			}).done( function( info ){
				var json_info = JSON.parse( info );
				mostrar_mensaje( json_info );
				limpiar();
				cerrar_modal();
				listar();
			});
		});
	}

	var eliminar = function(){
		$("#btnEliminar").on("click", function(){
			var idusuario = $("#frmEliminarmto_usuario #idusuario").val(),
				opcion = $("#frmEliminarmto_usuario #opcion").val();
			$.ajax({
				method:"POST",
				url: "../gestionDB/crud_mto_usuario.php",
				data: {"idusuario": idusuario, "opcion": opcion}
			}).done( function( info ){
				var json_info = JSON.parse( info );
				mostrar_mensaje( json_info );
				listar();
			});
		});
	}

	var obtener_data_editar = function(tbody, table){
		$(tbody).on("click", "button.editar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			var idusuario = $("#frmMto_usuario #idusuario").val( data.idusuario ),
				codigo_usuario = $("#frmMto_usuario #codigo_usuario").val( data.codigo_usuario ),
				nombres_usuario = $("#frmMto_usuario #nombres_usuario").val( data.nombres_usuario ),
				apellidos_usuario = $("#frmMto_usuario #apellidos_usuario").val( data.apellidos_usuario ),
				password_usuario = $("#frmMto_usuario #password_usuario").val( data.password_usuario ),
				idrol_usuario = $("#frmMto_usuario #idrol_usuario").val( data.idrol_usuario ),
				opcion = $("#frmMto_usuario #opcion").val("modificar");
		});
	}

	var obtener_id_eliminar = function(tbody, table){
		$(tbody).on("click", "button.eliminar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			var idusuario = $("#frmEliminarmto_usuario #idusuario").val( data.idusuario ),
				opcion = $("#frmEliminarmto_usuario #opcion").val("eliminar");
		});
	}

	var limpiar = function(){
		$("#frmMto_usuario #codigo_usuario").val("");
		$("#frmMto_usuario #nombres_usuario").val("");
		$("#frmMto_usuario #apellidos_usuario").val("");
		$("#frmMto_usuario #password_usuario").val("");
		$("#frmMto_usuario #idrol_usuario").val("");
		$("#frmMto_usuario #opcion").val("agregar");
	}

	var cerrar_modal = function(){
		$('#modalfrmMto_usuario').modal('toggle');
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

	var listar = function(){
		var myTable = $("#myTable").DataTable({
			dom: "<'row'<'form-inline' <'col-sm-offset-5'B>>>"
					+"<frtip>",
			responsive: true,
			buttons: [
				{
					text: '<i class="fa fa-user-plus" data-toggle="modal" data-target="#modalfrmMto_usuario"></i>',
					titleAttr: 'Nuevo registro',
					className: 'btn btn-info',
					action: function(){
						limpiar();
					}
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel',
					className: 'btn btn-success',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					className: 'btn btn-danger',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Imprimir',
					className: 'btn btn-secondary',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				}
			],
			"destroy": true,
			"processing": true,
			"ajax": {
				"method":"POST",
				"url":"datos_mto_usuario.php"
			},
			"columns": [
				{"data":"codigo_usuario"},
				{"data":"nombres_usuario"},
				{"data":"apellidos_usuario"},
				{"data":"password_usuario"},
				{"data":"rol_usuario"},
				{"defaultContent": "<div class='btn-group'><button type='button' class='editar btn btn-info' data-toggle='modal' data-target='#modalfrmMto_usuario'><i class='fa fa-pencil-square-o' title='Editar'></i></button> <button type='button' class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalfrmEliminar'><i class='fa fa-trash' title='Eliminar'></i></button></div>"}
			],
			"language": {
				"sUrl": '../js/dtspanish.json'
			}
		});

		obtener_data_editar("#myTable tbody", myTable);
		obtener_id_eliminar("#myTable tbody", myTable);
	}
	</script>

</body>
</html>

<?php
} else {
	header( "location: ../plantilla/plantilla.php" );
}
?>