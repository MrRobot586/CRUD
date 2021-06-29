<?php
	
	//funcion para conectar a la base de datos
	function connection($opt){

		$config = include 'config.php';

		if($opt == "try"){//Opt == "try"
			$error = false;

			$stateconn = [
				'status' => false,
				'error'  => ''
			];

			try{

				$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
				$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

				$stateconn['status'] = true;

			} catch (PDOException $error){
				$error = $error->getMessage();//F

				$stateconn['status'] = false;
				$stateconn['error'] = $error;
			}

			return $stateconn;

		} else {// Opt = "con" or other

				$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
				$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

				return $conexion;
		}

	}

	//funcion para verificar si hay filas en una tabla
	function count_row($conn, $table){

		$config = include 'config.php';
 
		$row_count = 0;

		$sql = "SELECT COUNT(*) FROM " . $table;

		$result = $conn->prepare($sql);

		if($result->execute()){
			$row_count = $result->fetchColumn();
		}

		return $row_count;
	}

	//funcion para verificar si una tabla existe
	function table_exists($conn, $table, $opt){

		$config = include 'config.php';

		switch ($opt) {

			case 'exists':

			    try{

			        $conn->query("SELECT 1 FROM " . $table);
			    
			    }catch(PDOException $error){
			    
			        return false;
			    
			    }

			    return true;

				break;
			
			case 'error':

				try{

			        $conn->query("SELECT 1 FROM " . $table);
			    
			    }catch(PDOException $error){
			    
			        return $error->getMessage();
			    
			    }

				break;
		}
		
		}

		function displaymessage($type, $message){

			// Proceso exitoso, popup.
		   $success = '
		      <div id="popup" class="w3-modal">
		      <div class="w3-modal-content w3-animate-zoom">

		         <header class="w3-container w3-blue w3-center">
		            <h2><i class="fa fa-check-circle"></i> Proceso terminado con exito!</h2>
		         </header>

		         <div class="w3-container w3-center">

		             <img src="IMG/Success.png" style="width:20%" class="w3-circle w3-margin-top">

		            <p>'.$message.'</p>
		            <p>Por favor, preciona "volver" para volver a la pagina principal.</p>

		            <a href="index.php" class="w3-button w3-round w3-blue w3-margin-bottom"><i class="fa fa-arrow-left"></i> Volver</a>
		         </div>

		      </div>
		   </div>

		   ';

		   // Error en el proceso, popup.
		   $error = '
		      <div id="popup" class="w3-modal">
		      <div class="w3-modal-content w3-animate-zoom">

		         <header class="w3-container w3-red w3-center">
		            <h2><i class="fa fa-exclamation-triangle"></i> Hubo un error!</h2>
		         </header>

		         <div class="w3-container w3-center">

		            <img src="IMG/Error.png" style="width:20%" class="w3-circle w3-margin-top">

		            <p class="w3-text-red"><strong>El error devolvio el siguiente mensaje:</strong></p>

		            <p class="w3-panel w3-red">'.$message.'</p>

		            <p>Por favor preciona "volver" para intentarlo nuevamente.</p>
		            <p>Si el error perciste consulte con el administrador de la pagina.</p>

		            <a href="index.php" class="w3-button w3-round w3-red w3-margin-bottom"><i class="fa fa-arrow-left"></i> Volver</a>
		         </div>

		      </div>
		   </div>

		   ';

			switch ($type){
				case 'success':
					echo $success;
					break;
				case 'error':
					echo $error;
					break;

				default:
					echo $unknow;
					break;
			}
		}

?>
