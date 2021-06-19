<!DOCTYPE html>
<html>
<head>

	<!---     | Metadata |     -->
	<meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!---     | CSS |     -->
    <link rel="stylesheet" href="CSS/w3.css"/>

    <!---     | JS |     -->
    <script  type="text/javascript" src="js/main.js"></script>

    <!---     | Titulo |     -->
	<title> CRUD - By: Diego Oropeza</title>
</head>

	<!---     | Body |     -->

<body>
		<!---     | Header |     -->
		<div class="w3-bar w3-black w3-center">
	  		<a href="#" class="w3-button w3-mobile">C.R.U.D / Create Remove Update Delete</a>
		</div>

		<!---     | Main section |     -->
		<div class="w3-container">

			<a href="#" class="w3-button w3-blue" onclick=toggle_display('add',1)>Añadir nuevo empleado</a>

			<!---     | Popup: Añadir registro |     -->
			<div id="add" class="w3-modal">
				<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
					<div class="w3-container">
					    <div class="w3-center"><br>
        					<span onclick=toggle_display('add',0) class="w3-button w3-hover-red w3-display-topright" title="Cerrar">&times;</span>
        					<br>
     					</div>
					    


					    <form class="w3-container" method="post" action="create.php">
        					<div class="w3-section">

  								<h2  class="w3-blue w3-margin-top w3-padding">Formulario de nuevo empeado</h2>

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

          						<button class="w3-button w3-red w3-section w3-padding" onclick=toggle_display('add',0) type="button">Atras</button>
          						<button class="w3-button w3-green w3-section w3-padding" type="submit">Registrar</button>
          						
        					</div>
      					</form>

				    </div>
				</div>
			</div>

			<!---     | Lista de registros |     -->
			<?php

				$error = false;
				$config = include 'config.php';

				try {
				 	$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
				  	$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

				  	// Consulta SQL para obtener la data

				  	$consultaSQL = "SELECT * FROM empleados";

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

			<div class="w3-container">
			  <h2>Hoverable Table</h2>

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
		              </tr>
		              <?php
		            }
		          }
		          ?>
        		<tbody>
			    
			  </table>
			</div>

		</div>

		<!---     | Footer |     -->
		 <footer class="w3-black w3-center w3-padding-24">
		 	By: 
		 	<a href="#" title="Autor: Diego Oropeza ;)" onclick=toggle_display('me',1)>Diego Oropeza</a>
		 </footer>

		 <!---     | Modal: About me |     -->
		<div id="me" class="w3-modal">
			<div class="w3-modal-content w3-animate-bottom">
				<div class="w3-container">
				    <span onclick=toggle_display('me',0) class="w3-button w3-display-topright">&times;</span>
				    <p>Some text in the Modal..</p>
				    <p>Some text in the Modal..</p>
			    </div>
			</div>
		</div>

</body>
</html>