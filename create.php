<?php

$resultado = [
    'error' => false,
    'mensaje' => '¡Registro exitoso!'
];

$config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

   // Insercion de datos

   $new_empleado = [
      "nombre"   => $_POST['nombre'],
      "apellido" => $_POST['apellido'],
      "edad"     => $_POST['edad'],
      "ci"       => $_POST['CI'],
      "email"    => $_POST['email'],
      "empresa"  => $_POST['empresa'],
      "cargo"    => $_POST['cargo'],
      
   ];

   $consultaSQL = "INSERT INTO empleados(`nombre`, `apellido`, `edad`, `cedula`, `email`, `empresa`, `cargo`) ";

   $consultaSQL .= "values (:" . implode(", :", array_keys($new_empleado)) . ")";
  
   //$consultaSQL .= "VALUES ('".$new_empleado['nombre']."','".$new_empleado['apellido']."',".$new_empleado['edad'].",".$new_empleado['ci'].",'".$new_empleado['email']."','".$new_empleado['empresa']."','".$new_empleado['cargo']."')";
   
   //echo $consultaSQL;

   $insert = $conexion->prepare($consultaSQL);
   $insert->execute($new_empleado);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }

?>

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
   <title>Registro exitoso</title>


</head>
<body>
     
<?php
if (isset($resultado)) {

   // Proceso exitoso, popup.
   $success = '
      <div id="popup" class="w3-modal">
      <div class="w3-modal-content w3-animate-zoom">

         <header class="w3-container w3-green w3-center">
            <h2> Proceso terminado con exito!</h2>
         </header>

         <div class="w3-container w3-center">

             <img src="img/success.png" style="width:30%" class="w3-circle w3-margin-top">

            <p>'.$resultado['mensaje'].'</p>
            <p>Por favor preciona "volver" para volver a la pagina principal.</p>

            <a href="index.php" class="w3-button w3-green w3-margin-bottom">(incono) Volver</a>
         </div>

      </div>
   </div>

   ';

   // Error en el proceso, popup.
   $error = '
      <div id="popup" class="w3-modal">
      <div class="w3-modal-content w3-animate-zoom">

         <header class="w3-container w3-red w3-center">
            <h2> Hubo un error!</h2>
         </header>

         <div class="w3-container w3-center">

            <img src="img/error.png" style="width:30%" class="w3-circle w3-margin-top">

            <p>'.$resultado['mensaje'].'</p>
            <p>Por favor preciona "volver" para intentarlo nuevamente.</p>
            <p>Si el error perciste consulte con el administrador de la pagina.</p>

            <a href="index.php" class="w3-button w3-red w3-margin-bottom">(incono) volver</a>
         </div>

      </div>
   </div>

   ';

   if ($resultado['mensaje'] =='¡Registro exitoso!'){
        echo $success; 
   }else{
      echo $error;
   }

}
?>

 <!---     | Timeuout para el pop up [JS] |     -->
   <script type="text/javascript"> setTimeout(popup, 2000); </script>

</body>
</html>