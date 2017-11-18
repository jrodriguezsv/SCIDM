<!-- Validación de sesión -->
<?php require "../login/validar.php"; ?>

<!-- Conexión a base de datos -->
<?php require "../conexion/conexion.php"; ?>

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

	<h4 align="center">Mantenimiento de administrador contrato</h4>
		<div id="mensaje"></div>

	<!-- Contenido general -->
	<div class="row">
		<div class="col-md-12">
	
		<!-- Inicio -->
		<div id="contenedor" align="center">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="50%">
				<thead>
					<tr>
						<th width="80%">Nombre Administrador</th>
						<th width="20%">Acciones</th>
					</tr>
				</thead>
			</table>
		</div><br>

		</div>
	</div>

	<!-- Modal formulario admin_contrato -->
	<div class="modal fade" id="modalfrmAdmin_contrato" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="frmAdmin_contrato" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 class="modal-title">Formulario de registro administrador de contrato</h3>
						<input type="hidden" id="idadmin_contrato" name="idadmin_contrato" value="0">
						<input type="hidden" id="opcion" name="opcion" value="agregar">
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div id="mensaje"></div>
								<div class="form-group">
									<label for="nombre_admin">
										Administrador de contrato
									</label>
									<input type="text" class="form-control" maxlength="45" id="nombre_admin" name="nombre_admin" required />
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

	<!-- Modal eliminar color -->
	<div class="modal fade" id="modalfrmEliminar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="frmEliminaradmin_contrato" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Eliminar Registro</h4>
						<input type="hidden" id="idadmin_contrato" name="idadmin_contrato" value="0">
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
		$("#frmAdmin_contrato").on("submit", function(e){
			e.preventDefault();
			var frm = $(this).serialize();
			$.ajax({
				method: "POST",
				url: "../gestionDB/crud_admin_contrato.php",
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
			var idadmin_contrato = $("#frmEliminaradmin_contrato #idadmin_contrato").val(),
				opcion = $("#frmEliminaradmin_contrato #opcion").val();
			$.ajax({
				method:"POST",
				url: "../gestionDB/crud_admin_contrato.php",
				data: {"idadmin_contrato": idadmin_contrato, "opcion": opcion}
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
			var idadmin_contrato = $("#frmAdmin_contrato #idadmin_contrato").val( data.idadmin_contrato ),
				nombre_admin = $("#frmAdmin_contrato #nombre_admin").val( data.nombre_admin ),
				opcion = $("#frmAdmin_contrato #opcion").val("modificar");
		});
	}

	var obtener_id_eliminar = function(tbody, table){
		$(tbody).on("click", "button.eliminar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			var idadmin_contrato = $("#frmEliminaradmin_contrato #idadmin_contrato").val( data.idadmin_contrato ),
				opcion = $("#frmEliminaradmin_contrato #opcion").val("eliminar");
		});
	}

	var limpiar = function(){
		$("#frmAdmin_contrato #nombre_admin").val("");
		$("#frmAdmin_contrato #opcion").val("agregar");
	}

	var cerrar_modal = function(){
		$('#modalfrmAdmin_contrato').modal('toggle');
	}

	var mostrar_mensaje = function( informacion ){
		if ( informacion.respuesta == "CORRECTO" ){
			var texto = "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Éxito!</strong> Se han guardado los cambios correctamente.</p></div>";
		} else if ( informacion.respuesta == "ERROR" ){
			var texto = "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se a podido procesar la petición.</p></div>";
		} else if ( informacion.respuesta == "EXISTE" ){
			var texto = "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Advertencia!</strong> Este administrador de contrato ya está registrado.</p></div>";
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
					text: '<i class="fa fa-user-plus" data-toggle="modal" data-target="#modalfrmAdmin_contrato"></i>',
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
						columns: [ 0 ]
					}
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					className: 'btn btn-danger',
					exportOptions: {
						columns: [ 0 ]
					}
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Imprimir',
					className: 'btn btn-secondary',
					exportOptions: {
						columns: [ 0 ]
					}
				}
			],
			"destroy": true,
			"processing": true,
			"ajax": {
				"method":"POST",
				"url":"datos_admin_contrato.php"
			},
			"columns": [
				{"data":"nombre_admin"},
				{"defaultContent": "<div class='btn-group'><button type='button' class='editar btn btn-info' data-toggle='modal' data-target='#modalfrmAdmin_contrato'><i class='fa fa-pencil-square-o' title='Editar'></i></button> <button type='button' class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalfrmEliminar'><i class='fa fa-trash' title='Eliminar'></i></button></div>"}
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