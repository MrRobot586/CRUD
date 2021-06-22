<!DOCTYPE html>
<html>
<head>

	<!---     | Metadata |     -->
	<meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!---     | Favicon |     -->
    <link rel="apple-touch-icon" sizes="57x57" href="IMG/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="IMG/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="IMG/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="IMG/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="IMG/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="IMG/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="IMG/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="IMG/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="IMG/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="IMG/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="IMG/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="IMG/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="IMG/favicon/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

    <!---     | CSS |     -->
    <link rel="stylesheet" href="CSS/w3.css"/>
    <link rel="stylesheet" href="CSS/font_awesome.css">

    <!---     | JS |     -->
    <script  type="text/javascript" src="JS/main.js"></script>

    <!---     | Titulo |     -->
	<title> CRUD - By: Diego Oropeza</title>
</head>

	<!---     | Body |     -->

<body>
		<!---     | Header |     -->
		<nav class="w3-blue w3-center w3-padding">
			<a href="#" class="w3-button w3-animate-top w3-hover-none w3-text-light-gray w3-hover-text-white w3-mobile"><i class="fa fa-cube"></i> <b>C.R.U.D</b> / Create Remove Update and Delete</a>
		</nav>

		<!---     | Main section |     -->
		<div class="w3-container w3-margin" id="mainpage">

			<!---     | SQL: Coneccion a la base de datos y obtencion de la data |     -->
			<?php

				$error = false;
				$config = include 'config.php';

				try {
				 	$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
				  	$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

				  	// Consulta SQL para obtener la data

				  	if (isset($_POST['search']) && $_POST['search'] != '') {
  						$consultaSQL = "SELECT * FROM empleados WHERE nombre LIKE '%" . $_POST['search'] . "%'";
  						$header = '

  							<form class="w3-container w3-round w3-blue w3-margin-bottom" method="post">
				
								<h2 class="w3-center"><i class="fa fa-clipboard-list"></i> Lista de empleados</h2>

								<div class="w3-bar  w3-padding">
									
									<a class="w3-bar-item w3-button w3-margin-right w3-white w3-border w3-border-blue w3-round" title="Esta viendo los resultados de su busqueda."><i class="fa fa-search w3-text-blue"></i> Resultados de la busqueda para "'. $_POST['search'] .'"</a>

									<button class="w3-bar-item w3-button w3-hover-red w3-white w3-border w3-border-blue  w3-round" title="Volver"><i class="fa fa-arrow-left"></i></button>

								</div>
							</form>

  						';

					} else {
 						$consultaSQL = "SELECT * FROM empleados";
 						$header = '

 							<form class="w3-container w3-round w3-blue w3-margin-bottom" method="post">
				
								<h2 class="w3-center"><i class="fa fa-clipboard-list"></i> Lista de empleados</h2>

								<div class="w3-bar  w3-padding">

									<input class="w3-bar-item w3-input w3-border" type="text" name="search" placeholder="Buscar...">

									<button class="w3-bar-item w3-button w3-white w3-text-blue w3-margin-left w3-border w3-border-blue w3-round" title="Buscar!" type="submit" name="btn_search"><i class="fa fa-search"></i></button>

									<!---     | Boton: añadir nuevo empleado |     -->
									<a class="w3-bar-item w3-left w3-button w3-white w3-text-blue w3-right w3-round" title="Añadir nuevo empleado." onclick="toggle_display('."'add'".',1)"><i class="fa fa-plus"></i></a>
				
								</div>
							</form>

 						';
					}

					$get_data = $conexion->prepare($consultaSQL);
					$get_data->execute();

					$data_empleados = $get_data->fetchAll();

				}catch(PDOException $error) {
				  $error = $error->getMessage();
				}
			?>

			<?php
				if ($error) {
			?>

			<div class="w3-panel w3-red">
  				<h3>Hubo un error!</h3>
  				<p> Mensaje: <?= $error ?></p>
			</div>
				  
			<?php
				}
			?>

			<!---     | Headro Lista de epleados + Buscar |     -->

			<?php echo $header?>

				<!---     | Lista de registros |     -->
				<table class="w3-table-all w3-hoverable">

				    <thead>
				      <tr class="w3-blue">
				      	<th>#</th>
				        <th>Nombre(s)</th>
				        <th>Apellido(s)</th>
				        <th>Edad</th>
				        <th>Cedula</th>
				        <th>E-mail</th>
				        <th>Empresa</th>
				        <th>Cargo</th>
				        <th>Fecha de registro</th>
				        <th class="w3-center">Acciones</th>
				      </tr>
				    </thead>



				    <tbody>
			          <?php
			          if ($data_empleados && $get_data->rowCount() > 0) {
			            foreach ($data_empleados as $fila) {
			              ?>
			              <tr>
			                <td><?php echo $fila["id"]; ?></td>
			                <td><?php echo $fila["nombre"]; ?></td>
			                <td><?php echo $fila["apellido"]; ?></td>
			                <td><?php echo $fila["edad"]; ?></td>
			                <td><?php echo $fila["cedula"]; ?></td>
			                <td><?php echo $fila["email"]; ?></td>
			                <td><?php echo $fila["empresa"]; ?></td>
			                <td><?php echo $fila["cargo"]; ?></td>
			                <td><?php echo $fila["created_at"]; ?></td>
			                <td>
			                	<a class="w3-button w3-hover-blue w3-green w3-round w3-tiny w3-margin-left" href="<?= 'index.php?edit_id=' . $fila["id"] ?>"><i class="fa fa-edit"></i></a>
  								<a class="w3-button w3-hover-blue w3-red w3-round w3-tiny w3-margin-left" href="<?= 'index.php?del_id=' . $fila["id"] . '&del_name=' . $fila["nombre"] ?>"><i class="fa fa-trash"></i></a>
							</td>
			              </tr>
			              <?php
			            }
			          }
			          ?>
	        		<tbody>
			    
			  	</table>

		</div>

		<!---     | Popup: Eliminar registro |     -->
			<div id="delete" class="w3-modal">
				<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
					<div class="w3-container">
					    
     					<!---     | Confirmacion de eliminacion |     -->

     					<?php

     					if (isset($_GET['del_id'])){
     						echo '<script type="text/javascript">'
   								, 'toggle_display('."'delete'".',1);'
   								, '</script>';

   							$id = $_GET['del_id'];
   							$nombre = $_GET['del_name'];

   							$confirm_del = '

   								<form class="w3-container" method="post" action="delete.php">

			  							<h2  class="w3-red w3-margin-top w3-padding w3-round w3-center"><i class="fa fa-user-minus w3-margin-right"></i>Eliminar el registro del empleado "'.$nombre.'"</h2>

			  						<div class="w3-section w3-center">

			  							<input style="display: none;" type="number" name="id" value="'.$id.'">

			        					<a class="w3-button w3-blue w3-section w3-padding w3-round" href="index.php" type="button"><i class="fa fa-arrow-left"></i> Cancelar</a>

			          					<button class="w3-button w3-red w3-section w3-padding w3-round" type="submit" name="submit_delete"><i class="fa fa-minus"></i> Borrar</button>
          						
        							</div>
      							</form>

   							';

   							echo $confirm_del;
     					}

     					?>

				    </div>
				</div>
			</div>

		<!---     | Popup: Editar registro |     -->
			<div id="edit" class="w3-modal">
				<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
					<div class="w3-container">
					    <div class="w3-center"><br>
        					<a href="index.php" class="w3-button w3-hover-red w3-display-topright" title="Cerrar">&times;</a>
        					<br>
     					</div>
					    
     					<!---     | Formulario para editar registro |     -->

     					<?php

     					$resultado = [
							  'error' => false,
							  'mensaje' => ''
						];

     					if (isset($_GET['edit_id'])){
     						echo '<script type="text/javascript">'
   								, 'toggle_display('."'edit'".',1);'
   								, '</script>';

   							$config = include 'config.php';

   							try {
  								$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  								$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
								$edit_id = $_GET['edit_id'];
  								$consultaSQL = "SELECT * FROM empleados WHERE id =" . $edit_id;

  								$edit = $conexion->prepare($consultaSQL);
  								$edit->execute();

  								$edit_empleado = $edit->fetch(PDO::FETCH_ASSOC);

  								$edit_form = '

  									<form class="w3-container" method="post" action="edit.php">
        								<div class="w3-section">

			  								<h2  class="w3-blue w3-margin-top w3-padding w3-round w3-center"><i class="fa fa-user-edit w3-margin-right"></i>Editar registro ('.$edit_empleado['nombre'].')</h2>

			          						<label><b>Nombre(s)</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Ingresa tu nombre" name="nombre" value="'.$edit_empleado['nombre'].'">

			          						<label><b>Apellido(s)</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Ingresa tu apellido" name="apellido" value="'.$edit_empleado['apellido'].'">

			          						<label><b>Edad</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Ingresa tu edad" name="edad" value="'.$edit_empleado['edad'].'">

			          						<label><b>C.I</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Ingresa tu cedula de identidad" name="CI" value="'.$edit_empleado['cedula'].'">

			          						<label><b>E-mail</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Ingresa un correo electronico" name="email" value="'.$edit_empleado['email'].'">
			          						
			          						<label><b>Empresa</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nombre de la empresa" name="empresa" value="'.$edit_empleado['empresa'].'">

			          						<label><b>Cargo en la empresa</b></label>
			          							<input class="w3-input w3-border" type="text" placeholder="Cargo que desempeña" name="cargo" value="'.$edit_empleado['cargo'].'">

			          							<input style="display: none;" type="number" name="id" value="'.$edit_empleado['id'].'">

			          						<a class="w3-button w3-red w3-section w3-padding w3-round" href="index.php" type="button"><i class="fa fa-arrow-left"></i> Cancelar</a>

			          						<button class="w3-button w3-green w3-section w3-padding w3-round" type="submit" name="submit_update"><i class="fa fa-save"></i> Guardar</button>
          						
        								</div>
      								</form>

  								';

							    if (!$edit_empleado) {
							    	$resultado['error'] = true;
							    	$resultado['mensaje'] = 'No se encontro registro del empleado.';
							    }

							}catch (PDOException $error){
							  	$resultado['error'] = true;
							  	$resultado['mensaje'] = $error->getMessage();
							}

     					} else{
  							$resultado['error'] = true;
  							$resultado['mensaje'] = 'El empleado no existe en los registros.';
     					}
     					?>

     					<?php
							if ($resultado['error']) {
						?>

						<div class="w3-panel w3-red">
  							<h3>Hubo un error!</h3>
  							<p> Mensaje: <?= $resultado['mensaje'] ?></p>
						</div>
				  
						<?php
							} else{
								echo $edit_form;
							}
						?>

				    </div>
				</div>
			</div>


		<!---     | Popup: Añadir registro |     -->
			<div id="add" class="w3-modal">
				<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
					<div class="w3-container">
					    <div class="w3-center"><br>
        					<span onclick="toggle_display('add',0)" class="w3-button w3-hover-red w3-display-topright" title="Cerrar">&times;</span>
        					<br>
     					</div>
					    
     					<!---     | Formulario de nuevo empleado |     -->
					    <form class="w3-container" method="post" action="create.php">
        					<div class="w3-section">

  								<h2  class="w3-blue w3-margin-top w3-padding w3-round w3-center"><i class="fa fa-user-plus w3-margin-right"></i>Formulario de nuevo empleado</h2>

          						<label><b>Nombre(s)</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Ingresa tu nombre" name="nombre" required>

          						<label><b>Apellido(s)</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Ingresa tu apellido" name="apellido" required>

          						<label><b>Edad</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Ingresa tu edad" name="edad" required>

          						<label><b>C.I</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Ingresa tu cedula de identidad" name="CI" required>

          						<label><b>E-mail</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Ingresa un correo electronico" name="email" required>
          						
          						<label><b>Empresa</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nombre de la empresa" name="empresa" required>

          						<label><b>Cargo en la empresa</b></label>
          							<input class="w3-input w3-border" type="text" placeholder="Cargo que desempeña" name="cargo" required>

          						<button class="w3-button w3-red w3-section w3-padding w3-round" onclick="toggle_display('add',0)" type="button"><i class="fa fa-arrow-left"></i> Atras</button>

          						<button class="w3-button w3-green w3-section w3-padding w3-round" type="submit" name="submit_create"><i class="fa fa-plus"></i> Registrar</button>
          						
        					</div>
      					</form>

				    </div>
				</div>
			</div>

			<!---     | Modal: About me |     -->
			<div id="me" class="w3-modal">
				<div class="w3-modal-content w3-animate-bottom w3-round">
					<div class="w3-container w3-center">
					    <span onclick="toggle_display('me',0)" class="w3-button w3-hover-red w3-display-topright w3-round">&times;</span><br>
					    <p class="w3-padding w3-round w3-blue w3-xlarge"><i class="fa fa-copyright"></i> Toda la pagina fue hecha por Diego Oropeza.</p>
					    <p>Fue hecha con HTML5, CSS,PHP y Javascript.<br>Ademas, fueron utilizadas librerias de CSS como "w3.css" para los estilos.<br><br>

					    	<b>Notas del autor:</b><br> Cabe destacar que no tuve ninguna ayuda al realizar este trabajo, el profesor Joel (mi tutor) no se comunico conmigo por ningun medio tras el incio de las pasantias, solo me oriento al inciar para depues no volver a comunicarse ni conmigo ni con ninguno de mis compañeros en el grupo de telegram. No obstante, tambien aclaro que tampoco use ninguna "plantilla" para elaborar este trabajo, la verdad es que ya tengo experiencia haciendo este tipo de cosas asi que lo hize netamente con mis conocimientos y habilidades, me tarde al rededor de 2 dias en la construccion del proyecto y todo el progreso esta documentado en el repositorio del propio sitio web.<br><br>

					    	En los archivos del proyecto se encuentra un script de instalacion que al ejecutarlo se crea la base de datos y tabla correspondiente en el servidor apache, por lo que para usarse solo debe de mover la carpeta del proyecto al directorio del servidor e ingresar a la direccion donde se encuentra el archivo "install.php".<br>

					    </p>

					    <button class="w3-margin-bottom w3-round w3-button w3-blue" onclick="toggle_display('me',0)"><i class="fa fa-arrow-left"></i> Volver</button>
				    </div>
				</div>
			</div>

		<!---     | Footer |     -->
		 <footer class="w3-blue-gray w3-center w3-padding-24">
		 	By: 
		 	<a href="#" title="Autor: Diego Oropeza ;)" onclick="toggle_display('me',1)"><i class="fa fa-copyright"></i> Diego Oropeza</a>
		 </footer>

</body>
</html>