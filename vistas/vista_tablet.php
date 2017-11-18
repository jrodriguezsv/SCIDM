<!-- Validación de sesión -->
<?php require "../login/validar.php"; ?>

<!-- Conexión a base de datos -->
<?php require "../conexion/conexion.php"; ?>

<!-- Datos de tabla: modelo -->
<?php 	$query = "SELECT * FROM modelo_tablet ORDER BY modelo_tablet ASC";
		$resultado = pg_query( $conexion, $query ); ?>

<!-- Datos de tabla: color -->
<?php 	$query2 = "SELECT * FROM color_tablet ORDER BY color_tablet ASC";
		$resultado2 = pg_query( $conexion, $query2 ); ?>

<!-- Datos de tabla: estado_tablet -->
<?php 	$query3 = "SELECT * FROM estado_tablet ORDER BY estado_tablet ASC";
		$resultado3 = pg_query( $conexion, $query3 ); ?>

<!-- Datos de tabla: propietario_tablet -->
<?php 	$query4 = "SELECT * FROM propietario_tablet ORDER BY nombre_propietario_tablet ASC";
		$resultado4 = pg_query( $conexion, $query4 ); ?>

<!-- Datos de tabla: admin_contrato -->
<?php 	$query5 = "SELECT * FROM admin_contrato ORDER BY nombre_admin ASC";
		$resultado5 = pg_query( $conexion, $query5 ); ?>

<!-- Datos de tabla: establecimiento -->
<?php 	$query6 = "SELECT * FROM establecimiento ORDER BY nombre_establecimiento ASC";
		$resultado6 = pg_query( $conexion, $query6 ); ?>

<!-- Datos de tabla: fuente_financiamiento -->
<?php 	$query7 = "SELECT * FROM fuente_financiamiento ORDER BY nombre_financiamiento ASC";
		$resultado7 = pg_query( $conexion, $query7 ); ?>

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

	<h4 align="center">Mantenimiento de tablets</h4>
		<div id="mensaje"></div>

	<!-- Contenido general -->
	<div class="row">
		<div class="col-md-12">

		<!-- Inicio -->
		<div id="contenedor" align="center">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Correlativo tablet</th>
						<th>No. Inventario</th>
						<th>No. Serie</th>
						<th>Color</th>
						<th>Modelo</th>
						<th>Estado tablet</th>
						<th>Propietario</th>
						<th>Establecimiento</th>
						<th>Administrador de contrato</th>
						<th>Fuente de financiamiento</th>
						<th>Acciones</th>
					</tr>
				</thead>
			</table>
		</div><br>

		</div>
	</div>

	<!-- Modal formulario tablet -->
	<div class="modal fade" id="modalfrmtablet" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<form id="frmtablet" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h3 class="modal-title">Formulario de registro tablet</h3>
						<input type="hidden" id="idtablet" name="idtablet" value="0">
						<input type="hidden" id="opcion" name="opcion" value="agregar">
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div id="mensaje"></div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="numero_inventario">
										Número de inventario
									</label>
									<input type="text" class="form-control" id="numero_inventario" name="numero_inventario" required/>
								</div>
								<div class="form-group">
									<label for="numero_serie">
										Número de serie
									</label>
									<input type="text" class="form-control" id="numero_serie" name="numero_serie" required />
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Modelo</label>
									<select class="form-control" id="idmodelo_tablet" name="idmodelo_tablet" required>
									<?php /* Llenado de lista marca */
										while ($row = pg_fetch_array($resultado)) {
											echo "<option value='".$row['idmodelo_tablet']."'>".$row['modelo_tablet']."</option>";
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Color</label>
									<select class="form-control" id="idcolor_tablet" name="idcolor_tablet" required>
									<?php /* Llenado de lista color */
										while ($row2 = pg_fetch_array($resultado2)) {
											echo "<option value='".$row2['idcolor_tablet']."'>".$row2['color_tablet']."</option>";
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Estado tablet</label>
									<select class="form-control" id="idestado_tablet" name="idestado_tablet" required>
									<?php /* Llenado de lista estado_tablet */
										while ($row3 = pg_fetch_array($resultado3)) {
											echo "<option value='".$row3['idestado_tablet']."'>".$row3['estado_tablet']."</option>";
										} ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="select" class="control-label">Propietario tablet</label>
									<select class="form-control" id="idpropietario_tablet" name="idpropietario_tablet" required>
									<?php /* Llenado de lista propietario_tablet */
										while ($row4 = pg_fetch_array($resultado4)) {
											echo "<option value='".$row4['idpropietario_tablet']."'>".$row4['nombre_propietario_tablet']."</option>";
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Administrador de contrato</label>
									<select class="form-control" id="idadmin_contrato" name="idadmin_contrato" required>
									<?php /* Llenado de lista admin_contrato */
										while ($row5 = pg_fetch_array($resultado5)) {
											echo "<option value='".$row5['idadmin_contrato']."'>".$row5['nombre_admin']."</option>";
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Establecimiento</label>
									<select class="form-control" id="idestablecimiento" name="idestablecimiento" required>
									<?php /* Llenado de lista establecimiento */
										while ($row6 = pg_fetch_array($resultado6)) {
											echo "<option value='".$row6['idestablecimiento']."'>".$row6['nombre_establecimiento']."</option>";
										} ?>
									</select>
								</div>
								<div class="form-group">
									<label for="select" class="control-label">Fuente de financiamiento</label>
									<select class="form-control" id="idfuente_financiamiento" name="idfuente_financiamiento" required>
									<?php /* Llenado de lista fuente_financiamiento */
										while ($row7 = pg_fetch_array($resultado7)) {
											echo "<option value='".$row7['idfuente_financiamiento']."'>".$row7['nombre_financiamiento']."</option>";
										} ?>
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

	<!-- Modal eliminar color -->
	<div class="modal fade" id="modalfrmEliminar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="frmEliminartablet" role="form" data-toggle="validator" method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Eliminar Registro</h4>
						<input type="hidden" id="idtablet" name="idtablet" value="0">
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
		$("#frmtablet").on("submit", function(e){
			e.preventDefault();
			var frm = $(this).serialize();
			$.ajax({
				method: "POST",
				url: "../gestionDB/crud_tablet.php",
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
			var idtablet = $("#modalfrmEliminar #idtablet").val(),
				opcion = $("#modalfrmEliminar #opcion").val();
			$.ajax({
				method:"POST",
				url: "../gestionDB/crud_tablet.php",
				data: {"idtablet": idtablet, "opcion": opcion}
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
			var idtablet = $("#frmtablet #idtablet").val( data.idtablet ),
				numero_inventario = $("#frmtablet #numero_inventario").val( data.numero_inventario ),
				numero_serie = $("#frmtablet #numero_serie").val( data.numero_serie ),
				idmodelo_tablet = $("#frmtablet #idmodelo_tablet").val( data.idmodelo_tablet ),
				idcolor_tablet = $("#frmtablet #idcolor_tablet").val( data.idcolor_tablet ),
				idestado_tablet = $("#frmtablet #idestado_tablet").val( data.idestado_tablet ),
				idpropietario_tablet = $("#frmtablet #idpropietario_tablet").val( data.idpropietario_tablet ),
				idadmin_contrato = $("#frmtablet #idadmin_contrato").val( data.idadmin_contrato ),
				idestablecimiento = $("#frmtablet #idestablecimiento").val( data.idestablecimiento ),
				idfuente_financiamiento = $("#frmtablet #idfuente_financiamiento").val( data.idfuente_financiamiento ),
				opcion = $("#frmtablet #opcion").val("modificar");
		});
	}

	var obtener_id_eliminar = function(tbody, table){
		$(tbody).on("click", "button.eliminar", function(){
			var data = table.row( $(this).parents("tr") ).data();
			var idtablet = $("#frmEliminartablet #idtablet").val( data.idtablet ),
				numero_inventario = $("#frmEliminartablet #numero_inventario").val( data.numero_inventario ),
				numero_serie = $("#frmEliminartablet #numero_serie").val( data.numero_serie ),
				idmodelo_tablet = $("#frmEliminartablet #idmodelo_tablet").val( data.idmodelo_tablet ),
				idcolor_tablet = $("#frmEliminartablet #idcolor_tablet").val( data.idcolor_tablet ),
				idestado_tablet = $("#frmEliminartablet #idestado_tablet").val( data.idestado_tablet ),
				idpropietario_tablet = $("#frmEliminartablet #idpropietario_tablet").val( data.idpropietario_tablet ),
				idadmin_contrato = $("#frmEliminartablet #idadmin_contrato").val( data.idadmin_contrato ),
				idestablecimiento = $("#frmEliminartablet #idestablecimiento").val( data.idestablecimiento ),
				idfuente_financiamiento = $("#frmEliminartablet #idfuente_financiamiento").val( data.idfuente_financiamiento ),
				opcion = $("#frmEliminartablet #opcion").val("eliminar");
		});
	}

	var limpiar = function(){
		$("#frmtablet #numero_inventario").val("");
		$("#frmtablet #numero_serie").val("");
		$("#frmtablet #idmodelo_tablet").val("");
		$("#frmtablet #idcolor_tablet").val("");
		$("#frmtablet #idestado_tablet").val("");
		$("#frmtablet #idpropietario_tablet").val("");
		$("#frmtablet #idadmin_contrato").val("");
		$("#frmtablet #idestablecimiento").val("");
		$("#frmtablet #idfuente_financiamiento").val("");
		$("#frmtablet #opcion").val("agregar");
	}

	var cerrar_modal = function(){
		$('#modalfrmtablet').modal('toggle');
	}
	
	var mostrar_mensaje = function( informacion ){
		if ( informacion.respuesta == "CORRECTO" ){
			var texto = "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Éxito!</strong> Se han guardado los cambios correctamente.</p></div>";
		} else if ( informacion.respuesta == "ERROR" ){
			var texto = "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se a podido procesar la petición.</p></div>";
		} else if ( informacion.respuesta == "EXISTE" ){
			var texto = "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Advertencia!</strong> Esta tablet ya está registrada.</p></div>";
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
					text: '<i class="fa fa-user-plus" data-toggle="modal" data-target="#modalfrmtablet"></i>',
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
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
					}
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					className: 'btn btn-danger',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
					}
				},
				{
					extend: 'print',
					text: '<i class="fa fa-print"></i>',
					titleAttr: 'Imprimir',
					className: 'btn btn-secondary',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
					}
				}
			],
			"destroy": true,
			"processing": true,
			"ajax": {
				"method":"POST",
				"url":"datos_tablet.php"
			},
			"columns": [
				{"data":"idtablet"},
				{"data":"numero_inventario"},
				{"data":"numero_serie"},
				{"data":"color_tablet"},
				{"data":"modelo_tablet"},
				{"data":"estado_tablet"},
				{"data":"nombre_propietario_tablet"},
				{"data":"nombre_establecimiento"},
				{"data":"nombre_admin"},
				{"data":"nombre_financiamiento"},
				{"defaultContent": "<div class='btn-group'><button type='button' class='editar btn btn-info' data-toggle='modal' data-target='#modalfrmtablet'><i class='fa fa-pencil-square-o' title='Editar'></i></button> <button type='button' class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalfrmEliminar'><i class='fa fa-trash' title='Eliminar'></i></button></div>"}
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