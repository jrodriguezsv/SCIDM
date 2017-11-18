<!DOCTYPE html>
<html lang="es">
<head>
	<title>:: Sistema de Control de Inventario de Dispositivos Móviles - SCIDM ::</title>

	<?php include "plantilla/meta.php"; ?>

	<?php include "plantilla/estilos.php"; ?>

</head>
<body>

<!-- Contenido principal -->
<div class="container-fluid">

	<!-- Contenido general -->
	<div class="col-md-12 login-box">
	<div class="col-md-4"></div>
	<div class="col-md-4 well bs-component login">
		<form id="frmLogin" class="form-horizontal" role="form" data-toggle="validator" method="POST">
			<fieldset>
				<legend><img src="img/head_login.png" /></legend>
				<div id="mensaje"></div>
				<div class="form-group">
					<label for="codigo_usuario" class="col-lg-3">
						Usuario
					</label>
					<div class="col-lg-9">
						<input type="text" class="form-control" maxlength="45" id="codigo_usuario" name="codigo_usuario" required />
					</div>
				</div>
				<div class="form-group">
					<label for="password_usuario" class="col-lg-3">
						Contraseña
					</label>
					<div class="col-lg-9">
						<input type="password" class="form-control" maxlength="20" id="password_usuario" name="password_usuario" required />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<button type="submit" class="btn btn-info" id="btnSesion">Iniciar Sesión</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="col-md-4"></div>

	</div>

	<div id="particles-js"></div>

	<?php include "plantilla/pie.php"; ?>

</div>

	<?php include "plantilla/scripts.php"; ?>

	<!-- Configurarión para mostrar particulas -->
	<style>
	body {
		background:#033c73;
	}
	.login{
		z-index: 9999;
	}
	.login-box {
		margin: 4rem auto;
	}
	#particles-js{
		width: 100%;
		height: 100%;
		background-size: cover;
		background-position: 50% 50%;
		position: fixed;
		top: 0px;
		z-index:1;
	}
	</style>

	<!-- Inicializar funciones -->
	<script>
	$(document).ready(function(){
		sesion();
		particulas();
	});

	var sesion = function(){
		$("#frmLogin").on("submit", function(e){
			e.preventDefault();
			var frm = $(this).serialize();
			$.ajax({
				method: "POST",
				url: "login/iniciar_sesion.php",
				data: frm,
			}).done( function( info ){
				var json_info = JSON.parse( info );
				mostrar_mensaje( json_info );
			});
		});
	}

	var mostrar_mensaje = function(informacion){
		if( informacion.respuesta == "CORRECTO" ){
			$("#mensaje").html("<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button>Bienvenido al sistema <strong>SCIDM</strong></div>");
			setTimeout("location.href = 'plantilla/plantilla.php'", 2000);
		} else if ( informacion.respuesta == "ERROR" ){
			$("#mensaje").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Credenciales no válidas.</div>");
		}

		$("#mensaje").fadeOut(5000, function(){
			$(this).html("");
			$(this).fadeIn(3000);
		});
	}

	var particulas = function(){
		particlesJS('particles-js',{
			"particles": {
				"number": {
					"value": 80,
					"density": {
						"enable": true,
						"value_area": 800
					}
				},
				"color": {
					"value": "#ffffff"
				},
				"shape": {
					"type": "circle",
					"stroke": {
						"width": 0,
						"color": "#000000"
					},
					"polygon": {
						"nb_sides": 5
					},
					"image": {
						"width": 100,
						"height": 100
					}
				},
				"opacity": {
					"value": 0.5,
					"random": false,
					"anim": {
						"enable": false,
						"speed": 1,
						"opacity_min": 0.1,
						"sync": false
					}
				},
				"size": {
					"value": 5,
					"random": true,
					"anim": {
						"enable": false,
						"speed": 40,
						"size_min": 0.1,
						"sync": false
					}
				},
				"line_linked": {
					"enable": true,
					"distance": 150,
					"color": "#ffffff",
					"opacity": 0.4,
					"width": 1
				},
				"move": {
					"enable": true,
					"speed": 6,
					"direction": "none",
					"random": false,
					"straight": false,
					"out_mode": "out",
					"attract": {
						"enable": false,
						"rotateX": 600,
						"rotateY": 1200
					}
				}
			},
			"interactivity": {
				"detect_on": "canvas",
				"events": {
					"onhover": {
						"enable": true,
						"mode": "repulse"
					},
					"onclick": {
						"enable": true,
						"mode": "push"
					},
					"resize": true
				},
				"modes": {
					"grab": {
						"distance": 400,
						"line_linked": {
							"opacity": 1
						}
					},
					"bubble": {
						"distance": 400,
						"size": 40,
						"duration": 2,
						"opacity": 8,
						"speed": 3
					},
					"repulse": {
						"distance": 200
					},
					"push": {
						"particles_nb": 4
					},
					"remove": {
						"particles_nb": 2
					}
				}
			},
			"retina_detect": true,
		}
		);
	};
	</script>

</body>
</html>