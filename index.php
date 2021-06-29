<?php 

if(!isset($_SESSION)){
	$sessionlife = 1296000;
	session_set_cookie_params($sessionlife,"/");
	
	session_start();

	$_SESSION['user_id'] = session_id();	
}

?>
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
		<!---     | Header de la magina |     -->
		<nav class="w3-blue w3-center w3-padding">
			<a onclick="toggle_display('README',1)" href="#" class="w3-button w3-animate-top w3-hover-none w3-text-light-gray w3-hover-text-white w3-mobile" title="Clic para abrir el archivo README"><i class="fa fa-cube"></i> <b>C.R.U.D</b> / Create Remove Update and Delete</a>
		</nav>

		<!---     | Main section |     -->
		<div class="w3-container w3-margin" id="mainpage">

			<!---     | SQL: Coneccion a la base de datos y obtencion de la data |     -->
			<?php

				include 'main.php';

				$conexion = connection("try");

				if($conexion['status']){//Conexion a la base de datos exitosa:
					$conexion = connection("con");

					if(table_exists($conexion, "empleados", 'exists')){//verificar si la tabla empleados existe

						if(count_row($conexion, "empleados") > 0){//verificar si hay registros en la tabla

							// Consulta SQL para obtener la data (SEARCH)
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

								} else {// Consulta SQL para obtener la data (NORMAL)
			 						$consultaSQL = "SELECT * FROM empleados";
			 						$header = '
			 <form class="w3-container w3-round w3-blue w3-margin-bottom" method="post">
							
				<h2 class="w3-center"><i class="fa fa-clipboard-list"></i> Lista de empleados</h2>

				<div class="w3-bar  w3-padding">

					<input class="w3-bar-item w3-input w3-border" type="text" name="search" placeholder="Buscar...">

					<button class="w3-bar-item w3-button w3-white w3-text-blue w3-margin-left w3-border w3-border-blue w3-round" title="Buscar!" type="submit" name="btn_search"><i class="fa fa-search"></i></button>

					<!---     | Boton: añadir nuevo empleado |     -->
					<a class="w3-bar-item w3-button w3-white w3-text-blue w3-right w3-round" title="Añadir nuevo empleado." onclick="toggle_display('."'add'".',1)"><i class="fa fa-plus"></i></a>
							
				</div>
			</form>
			 						';
								}

								$get_data = $conexion->prepare($consultaSQL);
								$get_data->execute();

								$data_empleados = $get_data->fetchAll();
							
						}else{//en caso de que no halla registros en la tabla (pero exista)
							$header = '

			 <form class="w3-container w3-round w3-blue w3-margin-bottom" method="post">
						
				<h2 class="w3-center"><i class="fa fa-clipboard-list"></i> Lista de empleados</h2>
				<h3 class="w3-center">(Actualmente vacia...)</h3>
				<h3 class="w3-center"><i class="fa fa-arrow-down"></i> Preciona el boton de abajo para añadir un nuevo registro a la lista. <i class="fa fa-arrow-down"></i></h3>

				<h4 class="w3-center"><a class="w3-white w3-text-blue w3-round w3-button" title="Añadir nuevo empleado." onclick="toggle_display('."'add'".',1)"><i class="fa fa-plus"></i></a></h4>

			</form>

			 						';
						}

					}else{//En caso de que la tabla no exista (error)
						echo '
						<div class="w3-panel w3-red">
  							<h3><i class="fa fa-exclamation-triangle"></i> Hubo un error en la base de datos!</h3>
  							<p><strong> Mensaje:</strong> '. table_exists($conexion, "empleados", 'error').'.</p>
						</div>';
					}

				}else{//Error de conexion:

					echo '
						<div class="w3-panel w3-red">
  							<h3><i class="fa fa-exclamation-triangle"></i> Hubo un error de conexion!</h3>
  							<p><strong> Mensaje:</strong> '.$conexion['error'].'.</p>
						</div>';

					if($conexion['error'] == "SQLSTATE[HY000] [1049] Unknown database 'empleados_db'"){
						echo '
							<div class="w3-panel w3-blue">
  								<h3>La base de datos no esta instlada...</h3>
  								<p>Dale clic a la cabecera y sigue los pasos que se espesifican en la seccion de "instalacion" para instalar la base de datos.</p>
							</div>';
					}
				}	

			?>

			<!---     | Header + Lista de epleados + Buscar |     -->
			<?php

			if(isset($header)){
				echo $header;
			}

			if (isset($data_empleados)){
				$table = '

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
				';

				if ($data_empleados && $get_data->rowCount() > 0) {
			            foreach ($data_empleados as $fila) {
			            	$table .= '
				<tr>
					<td class="w3-center">' .$fila["id"]. '</td>
					<td class="w3-center">' .$fila["nombre"]. '</td>
					<td class="w3-center">' .$fila["apellido"]. '</td>
					<td class="w3-center">' .$fila["edad"]. '</td>
					<td class="w3-center">V-' .$fila["cedula"]. '</td>
				    <td class="w3-center">' .$fila["email"]. '</td>
					<td class="w3-center">' .$fila["empresa"]. '</td>
					<td class="w3-center">' .$fila["cargo"]. '</td>
					<td class="w3-center">' .$fila["created_at"]. '</td>
					<td>';

					if($_SESSION['user_id'] == $fila['user_id']){
						$table .= '
						<a class="w3-button w3-hover-blue w3-green w3-round w3-tiny w3-margin-left" href="index.php?edit_id=' . $fila["id"] . ' "><i class="fa fa-edit"></i></a>

			  			<a class="w3-button w3-hover-blue w3-red w3-round w3-tiny w3-margin-left" href="index.php?del_id=' . $fila["id"] . '&del_name=' . $fila["nombre"] . ' "><i class="fa fa-trash"></i></a>
						';
					} else{
						$table .= '
						<a class="w3-button w3-disabled w3-hover-blue w3-green w3-round w3-tiny w3-margin-left"><i class="fa fa-edit"></i></a>

			  			<a class="w3-button w3-disabled w3-hover-blue w3-red w3-round w3-tiny w3-margin-left"><i class="fa fa-trash"></i></a>
						';
					}

					$table .= ' 
			 							
					</td>
				</tr>
			        ';
			            }

			            $table .= '
			          	<tbody>
					  
					</table>
			    ';

			    echo $table;
			    }

			} else{
				echo '

					<!---     | Anuncio de tabla vacia |     -->
					<div class="w3-panel w3-border-top w3-border-bottom w3-text-blue w3-center">
						<img style="max-width:250px" class="w3-opacity-min" src="IMG/No_data_found.png" alt="No data...">
  						<h2><strong>Aqui no hay nada que ver...</strong></h2>
  						<p class="w3-text-gray">No se encontraron registros.</p>
					</div> 

				';

			}

			?>

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

          						<label><b>Cedula de identidad</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="text" maxlength="8" placeholder="Ingresa tu cedula de identidad" name="CI" required>

          						<label><b>E-mail</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Ingresa un correo electronico" name="email" required>
          						
          						<label><b>Empresa</b></label>
          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nombre de la empresa" name="empresa">

          						<label><b>Cargo en la empresa</b></label>
          							<input class="w3-input w3-border" type="text" placeholder="Cargo que desempeña" name="cargo">

          							<input style="display: none;" type="text" name="user_id" value=<?php echo '"'. $_SESSION['user_id'] . '"'; ?>>
          							

          						<button class="w3-button w3-red w3-section w3-padding w3-round" onclick="toggle_display('add',0)" type="button"><i class="fa fa-arrow-left"></i> Atras</button>

          						<button class="w3-button w3-green w3-section w3-padding w3-round" type="submit" name="submit_create"><i class="fa fa-plus"></i> Registrar</button>
          						
        					</div>
      					</form>

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

						if(isset($_GET['edit_id']) && $_GET['edit_id'] != ''){
							echo '<script type="text/javascript">'
   								, 'toggle_display('."'edit'".',1);'
   								, '</script>';

   							//include 'main.php';

   							$conexion = connection("try");

							if($conexion['status']){//Conexion a la base de datos exitosa:
								$conexion = connection("con");

								$resultado = [
							  		'error' => false,
							  		'mensaje' => ''
								];

								$edit_id = $_GET['edit_id'];
  								$consultaSQL = "SELECT * FROM empleados WHERE id =" . $edit_id;

  								$edit = $conexion->prepare($consultaSQL);

  								try{
  									if($edit->execute()){
  										$edit_empleado = $edit->fetch(PDO::FETCH_ASSOC);

  										$edit_form = '

  									<form class="w3-container" method="post" action="edit.php">
        								<div class="w3-section">

			  								<h2  class="w3-blue w3-margin-top w3-padding w3-round w3-center"><i class="fa fa-user-edit w3-margin-right"></i>Editar registro ('.$edit_empleado['nombre'].')</h2>

			          						<label><b>Nombre(s)</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Ingresa tu nombre" name="nombre" value="'.$edit_empleado['nombre'].'" required>

			          						<label><b>Apellido(s)</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Ingresa tu apellido" name="apellido" value="'.$edit_empleado['apellido'].'" required>

			          						<label><b>Edad</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Ingresa tu edad" name="edad" value="'.$edit_empleado['edad'].'" required>

			          						<label><b>Cedula de identidad</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="number" placeholder="Ingresa tu cedula de identidad" name="CI" value="'.$edit_empleado['cedula'].'" required>

			          						<label><b>E-mail</b></label>
			          							<input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Ingresa un correo electronico" name="email" value="'.$edit_empleado['email'].'" required>
			          						
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
  									}
  								} catch(Exception $error){
  									$resultado = [
               							'error' => true,
               							'mensaje' => $error->getMessage()
            							];
  								}


							}else{
								$resultado = [
            						'error' => true,
            						'mensaje' => $conexion['error']
         						];
							}
						}

						if(isset($resultado)){
							if(!$resultado['error']){
								echo $edit_form;
							}else{
								displaymessage('error',$resultado['mensaje']);
							}
						}

     					?>

				    </div>
				</div>
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

   							echo '

   							<form class="w3-container" method="post" action="delete.php">

			  					<h2  class="w3-red w3-margin-top w3-padding w3-round w3-center"><i class="fa fa-user-minus w3-margin-right"></i>Eliminar el registro del empleado "'.$nombre.'"</h2>

			  					<div class="w3-section w3-center">

			  						<input style="display: none;" type="number" name="id" value="'.$id.'">

			        				<a class="w3-button w3-blue w3-section w3-padding w3-round" href="index.php" type="button"><i class="fa fa-arrow-left"></i> Cancelar</a>

			          				<button class="w3-button w3-red w3-section w3-padding w3-round" type="submit" name="submit_delete"><i class="fa fa-minus"></i> Borrar</button>
          						
        						</div>
      						</form>

   							';
     					}

     					?>

				    </div>
				</div>
			</div>
			<!---     | Modal: README |     -->
			<div id="README" class="w3-modal">
				<div class="w3-modal-content w3-animate-top w3-margin-bottom">
					<header class="w3-container w3-blue w3-center">
				      <h2><i class="fa fa-book-reader"></i> README</h2>
    				</header>
					<div class="w3-container w3-center">

					    <p class="w3-padding w3-round w3-blue w3-xlarge"><i class="fa fa-bookmark"></i> Introduccion</p>

					    <p style="text-align: justify;">

					    	Esta es una pequeña aplicación web diseñada y programada por Diego Oropeza, estudiante de 6to año sección B de la mención informática en la Escuela Técnica Comercial "Pedro Curiel Ramirez", fue creada durante el periodo de pasantías de la mención (2021) como parte de las actividades que se desarrollan para demostrar las capacidades y habilidades de los estudiantes. Se trata de una pequeña aplicación web basada en el concepto de un C.R.U.D (Create Read Update and Delete) que son las siglas de las palabras en inglés: "Crear Leer Actualizar y Eliminar", es en este concepto en el que se basa el proyecto, el cual radica en una lista de empleados en la cual se pueden añadir, quitar, ver y editar los registros una vez hechos, esto fue posible utilizando lenguajes de programación Backend como PHP y Frontend como Javascript, además de HTML y CSS para la estructura y estilos de la pagina respectivamente, también  fueron utilizadas librerías y fonts para dar dinámica a los estilos de los distintos componentes que conforman la aplicación web, tales como w3.css, para los colores y el font awesome, para los iconos. También fue utilizado el lenguaje SQL para generar y enviar las consultas a la base de datos utilizando PHP, así como también, para administrar los datos que se almacenan en la lista.<br>

					    </p>

					    <p class="w3-padding w3-round w3-yellow w3-text-white w3-xlarge"><i class="fa fa-cogs"></i> Instalacion</p>

					    <p style="text-align: justify;">

					    	Para utilizar este sistema, es necesario contar con 2 cosas fundamentales: Un navegador web y un servidor Apache. Los navegadores web pueden variar según sistema operativo y el gusto del usuario, sin embargo, el mas usado y recomendado es <a title="Click para descargar" href="https://www.google.com/intl/es/chrome/?brand=CHBD&brand=UUXU&gclid=CjwKCAjwoNuGBhA8EiwAFxomAwFVQXS1C2bTVEY0fm3TMqAYPoM5fyG7l8F9-fYo2OOls3OsL5ZnAxoCxcwQAvD_BwE&gclsrc=aw.ds" class="w3-text-blue">Chrome</a> y para servidor apache es posible utilizar la aplicacion <a title="Click para descargar" href="https://www.apachefriends.org/es/index.html" class="w3-text-blue">xampp</a>. Con ambas aplicaciones correctamente instaladas, tan solo debemos mover la carpeta de la aplicación a el directorio donde se almacenen los sitios web en xampp, por lo general es en "C:/xampp/htdocs/", una vez hecho esto podremos acceder a la aplicación a través del localhost del computador, sin embargo, esta no funcionara porque hará falta instalar la base de datos que la hace funcionar. En caso de que ya haya movido los archivos al directorio de xampp y está leyendo esto desde la propia página, tan solo presione el botón de abajo para instalar la base de datos. En caso contrario, simplemente copie el contenido del archivo que se encuentra en la carpeta llamada DB y ejecútelo desde el servidor xampp en la consola de SQL.<br><br>

					    </p>

					    <a class="w3-margin-bottom w3-round w3-button w3-yellow w3-text-white w3-hover-text-yellow" href="install.php" title="Click para instalar la base de datos"><i class="fa fa-database"></i> Instalar</a>

					    <p class="w3-padding w3-round w3-teal w3-text-white w3-xlarge"><i class="fa fa-question-circle"></i> ¿Como se usa?</p>

					    <p style="text-align: justify;">

					    	El uso es muy simple, con el botón que tiene el signo de más que esta en la parte superior se pueden añadir nuevos registros a la lista, en cada registro habrá 2 botones distintos que será para editar y eliminar dicho registro, dando click sobre estos podremos acceder a estas funciones, tras cada opción se abre una formulario de confirmación y con solo darle click a aceptar o volver, se habrá completado el proceso. Ejemplo: Si das click a editar algún registro añadido en la lista, te mostrara el formulario para editar cada ítem del registro (nombre, apellido, etc...) y luego de que termines de editar la información deberás hacer click en guardar para que se realicen los cambios. Es tan simple y fácil como eso.<br>

					    </p>

					    <p class="w3-padding w3-round w3-indigo w3-text-white w3-xlarge"><i class="fa fa-code"></i> Funcionamiento</p>

					    <p style="text-align: justify;">

					    	El programa se divide en distintos módulos que ejecutan cada una de las acciones (crear, eliminar, editar y ver los registros), cada módulo se encuentra dentro de la carpeta de la web y están programados en PHP en su mayoría para ejecutar las funciones que tengan que ver con la administración de la base de datos en la cual se sustenta el programa, además, también hay algunos módulos que usan JavaScript para darle dinamismo a la página web como tal. En total son 4 módulos uno por cada función, sin contar los módulos adicionales que dan soporte con algunas funciones extra, ni tampoco el central (index.php) el cual se encarga de centralizar todo el funcionamiento de los demás módulos, cada uno ejerce su rol tan pronto como el usuario realiza una acción. Ejemplo, si el usuario quiere editar un registro, le da click al botón de editar registro el cual a su vez ejecuta una función de JavaScript que cambia una propiedad del formulario en el cual se editara el registro para que este sea visible para el usuario, en el formulario se recogen los datos que luego son enviados al módulo de edición (edit.php) mediante el método POST y se procesan para la edición del registro seleccionado, de esta forma (en general) funcionan todas las características de la aplicación.

					    	<br><br>

							La dinámica consiste en enviar la acción que se realizara, se definen los parámetros bajo los cuales se ejecutara la acción para después enviar los datos al módulo correspondiente el cual ejecutara los procedimientos adecuados para procesar los datos recibidos. Por supuesto, hay muchísimos más detalles que no se explican acá, pero que en realidad esta explicación trata de describir de forma muy sencilla el funcionamiento de la aplicación. Otra cosa interesante es como otros usuarios (en otras computadoras) no pueden editar ni borrar los registros que algún otro usuario halla hecho, esto es porque al ingresar a la aplicación, esta inicia una sesión y asigna una dirección única al usuario que ingreso, para que así al este realizar algún registro estos se guarden con la dirección que se le asignó a dicho usuario, haciendo imposible que otro pueda editar o borrar el registro.
							
							<br><br>

					    </p>

					    <button class="w3-margin-bottom w3-round w3-button w3-blue" onclick="toggle_display('README',0)"><i class="fa fa-arrow-left"></i> Volver</button>
				    </div>
				</div>
			</div>

			<!---     | Modal: About me |     -->
			<div id="me" class="w3-modal">
				<div class="w3-modal-content w3-animate-bottom w3-round  w3-margin-bottom">
					<div class="w3-container w3-center">
					    <p class="w3-padding w3-round w3-blue w3-xlarge"><i class="fa fa-copyright"></i> Diego Oropeza - Acerca del autor</p>
					    <p>Soy estudiante de la ETC "Pedro Curiel Ramirez", tengo 18 años, estudio programación por mi cuenta desde los 13 y hace unos meses comencé en la programación web. Desarrollé este proyecto enfocándome primeramente en el estilo, para que fuese colorido y al mismo tiempo profesional, también puse bastante empeño en el backend y frontend del mismo, optimizando buena parte del código para que fuese entendible para otros estudiantes, tengo que decir que fue mi primera vez creando algo tan completo y pude haber puesto más esfuerzo en hacerlo mejor pero, también admito que me siento contento con el resultado.<br><br>

					    	<b class="w3-text-blue">Notas del autor:</b>

					    	<br><br> 

					    	Cabe destacar que no tuve ninguna ayuda al realizar este trabajo, el profesor Joel (mi tutor) no se comunicó conmigo por ningún medio tras el inicio de las pasantías, solo me oriento al iniciar para después no volver a comunicarse ni conmigo ni con ninguno de mis compañeros en el grupo de telegram. No obstante, también aclaro que tampoco use ninguna "plantilla" para elaborar este trabajo, la verdad es que ya tengo experiencia haciendo este tipo de cosas así que lo hice netamente con mis conocimientos y habilidades, me tarde alrededor de 2 días en la construcción del proyecto y todo el progreso está documentado en el repositorio del propio sitio web.

					    	<br><br>

					    	<b class="w3-text-blue">Aclaratoria importante:</b>
					    	
					    	<br><br>

					    	Las habilidades que yo como estudiante y como programador autodidacta demuestro mediante este proyecto no son resultado del proceso educativo que se realizó durante mi estancia en la institución, todas estas habilidades y conocimientos las he adquirido de forma autodidacta y sin ayuda de ningún profesor o tutor, esto lo digo para dejar en claro que no me siento conforme con la educación que recibí por parte de la institución y que pienso que pudo haber sido mejor, en fin, a lo que quiero llegar es que el nivel de educación y enseñanza de la Escuela Tecnica Comercial "Pedro Curiel Ramirez" no supero mis expectativas como estudiante y esto lo digo a modo de crítica, ya que, actualmente cuando estoy a punto de graduarme no me siento preparado para un entorno laboral y siento que la educación que recibí fue de alguna manera u otra "básica", por lo que me siento algo desconcertado con lo que me han "enseñado" dentro del plantel, en fin es netamente una opinión personal de un estudiante. Sin embargo, esta es solo una opinión personal...

					    	<br><br>

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