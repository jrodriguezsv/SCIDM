	<!-- Menus -->
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Menú de navegación</span><span class="icon-bar"></span><span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i>&nbsp;&nbsp;Mantenimiento&nbsp;<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<?php if ($_SESSION['idrol_usuario'] == 1){ ?>
								<li>
									<a href="../vistas/vista_mto_usuario.php"><i class="fa fa-user"></i>&nbsp;&nbsp;Usuario</a>
								</li>
								<li class="divider">
								</li>
								<?php } ?>
								<li>
									<a href="../vistas/vista_color.php"><i class="fa fa-paint-brush"></i>&nbsp;&nbsp;Color tablet</a>
								</li>
								<li>
									<a href="../vistas/vista_marca.php"><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Marca tablet</a>
								</li>
								<li>
									<a href="../vistas/vista_modelo.php"><i class="fa fa-star-o"></i>&nbsp;&nbsp;Modelo tablet</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="../vistas/vista_financiamiento.php"><i class="fa fa-money"></i>&nbsp;&nbsp;Fuente de financiamiento</a>
								</li>
								<?php if ($_SESSION['idrol_usuario'] == 1){ ?>
								<li>
									<a href="../vistas/vista_establecimiento.php"><i class="fa fa-university"></i>&nbsp;&nbsp;Establecimiento</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<li>
							<a href="../vistas/vista_admin_contrato.php"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;Administrador de contrato&nbsp;</a>
						</li>
						<li>
							<a href="../vistas/vista_tablet.php"><i class="fa fa-tablet"></i>&nbsp;&nbsp;Tablets&nbsp;</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $_SESSION['nombres_usuario'].' '.$_SESSION['apellidos_usuario']; ?>&nbsp;<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="../vistas/vista_gestion_usuario.php"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Gestión de usuario</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="../login/cerrar_sesion.php"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Cerrar sesión</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				
			</nav>
		</div>
	</div>