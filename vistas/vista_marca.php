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

	<!-- Contenido general -->
	<div class="row">
		<div class="col-md-12">

		<h4 align="center">Mantenimiento de marca</h4>
		<div id="mensaje"></div>

		<!-- Inicio -->
		<div id="contenedor" align="center">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="50%">
				<thead>
					<tr>
						<th width="80%">Marca</th>
						<th width="20%">Acciones</th>
					</tr>
				</thead>
			</table>
		</div><br>

		</div>
	</div>

	<!-- Modal formulario Marca -->
	<div class="modal fade" id="modalfrmMarca" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="frmMarca" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 class="modal-title">Formulario de registro marca</h3>
						<input type="hidden" id="idmarca_tablet" name="idmarca_tablet" value="0">
						<input type="hidden" id="opcion" name="opcion" value="agregar">
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="marca_tablet">
										Marca
									</label>
									<input type="text" class="form-control" maxlength="45" id="marca_tablet" name="marca_tablet" required />
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
				<form id="frmEliminarmarca" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Eliminar Registro</h4>
						<input type="hidden" id="idmarca_tablet" name="idmarca_tablet" value="0">
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
		$("#frmMarca").on("submit", function(e){
			e.preventDefault();
			var frm = $(this).serialize();
			$.ajax({
				method: "POST",
				url: "../gestionDB/crud_marca.php",
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
			var idmarca_tablet = $("#frmEliminarmarca #idmarca_tablet").val(),
				opcion = $("#frmEliminarmarca #opcion").val();
			$.ajax({
				method:"POST",
				url: "../gestionDB/crud_marca.php",
				data: {"idmarca_tablet": idmarca_tablet, "opcion": opcion}
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
			var idmarca_tablet = $("#frmMarca #idmarca_tablet").val( data.idmarca_tablet ),
				marca_tablet = $("#frmMarca #marca_tablet").val( data.marca_tablet ),
				opcion = $("#frmMarca #opcion").val("modificar");
		});
	}

	var obtener_id_eliminar = function(tbody, table){
		$(tbody).on("click", "button.eliminar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			var idmarca_tablet = $("#frmEliminarmarca #idmarca_tablet").val( data.idmarca_tablet ),
				opcion = $("#frmEliminarmarca #opcion").val("eliminar");
		});
	}

	var limpiar = function(){
		$("#frmMarca #marca_tablet").val("");
		$("#frmMarca #opcion").val("agregar");
	}

	var cerrar_modal = function(){
		$('#modalfrmMarca').modal('toggle');
	}

	var mostrar_mensaje = function( informacion ){
		if ( informacion.respuesta == "CORRECTO" ){
			var texto = "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Éxito!</strong> Se han guardado los cambios correctamente.</p></div>";
		} else if ( informacion.respuesta == "ERROR" ){
			var texto = "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se a podido procesar la petición.</p></div>";
		} else if ( informacion.respuesta == "EXISTE" ){
			var texto = "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Advertencia!</strong> Esta marca ya está registrada.</p></div>";
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
					text: '<i class="fa fa-user-plus" data-toggle="modal" data-target="#modalfrmMarca"></i>',
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
				"url":"datos_marca.php"
			},
			"columns": [
				{"data":"marca_tablet"},
				{"defaultContent": "<div class='btn-group'><button type='button' class='editar btn btn-info' data-toggle='modal' data-target='#modalfrmMarca'><i class='fa fa-pencil-square-o' title='Editar'></i></button> <button type='button' class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalfrmEliminar'><i class='fa fa-trash' title='Eliminar'></i></button></div>"}
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