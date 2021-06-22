<?php

$resultado = [
    'error' => false,
    'mensaje' => ''
];

$config = include 'config.php';

if (isset($_POST['submit_update'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
    $update_empleado = [
      "nombre"   => $_POST['nombre'],
      "apellido" => $_POST['apellido'],
      "edad"     => $_POST['edad'],
      "ci"   => $_POST['CI'],
      "email"    => $_POST['email'],
      "empresa"  => $_POST['empresa'],
      "cargo"    => $_POST['cargo'],
      "id"       => $_POST['id']   
   ];

  $consultaSQL = "UPDATE empleados SET nombre = '". $update_empleado['nombre'] ."', apellido = '". $update_empleado['apellido'] ."', edad = '". $update_empleado['edad'] ."', cedula = '". $update_empleado['ci'] ."', email = '". $update_empleado['email'] ."', empresa = '". $update_empleado['empresa'] ."', cargo = '". $update_empleado['cargo'] ."', updated_at = NOW() WHERE id = ". $update_empleado['id'] ." ;";
  
  $update = $conexion->prepare($consultaSQL);

  $update->execute();

  $resultado = [
         'error' => false,
         'mensaje' => 'El registro ha sido editado.'
  ];

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }

} else{
   $resultado = [
    'error' => true,
    'mensaje' => '¡Hubo un error! El formulario no se envio correctamente.'
   ];
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
    <link rel="stylesheet" href="CSS/font_awesome.css">

    <!---     | JS |     -->
    <script  type="text/javascript" src="JS/main.js"></script>

   <!---     | Titulo |     -->
   <title>Registro editado correctamente</title>


</head>
<body>
     
<?php

// Proceso exitoso, popup.
   $success = '
      <div id="popup" class="w3-modal">
      <div class="w3-modal-content w3-animate-zoom">

         <header class="w3-container w3-green w3-center">
            <h2> Proceso terminado con exito!</h2>
         </header>

         <div class="w3-container w3-center">

             <img src="IMG/Success.png" style="width:20%" class="w3-circle w3-margin-top">

            <p>'.$resultado['mensaje'].'</p>
            <p>Por favor, preciona "volver" para volver a la pagina principal.</p>

            <a href="index.php" class="w3-button w3-round w3-green w3-margin-bottom"><i class="fa fa-arrow-left"></i> Volver</a>
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

            <img src="IMG/Error.png" style="width:20%" class="w3-circle w3-margin-top">

            <p>'.$resultado['mensaje'].'</p>
            <p>Por favor preciona "volver" para intentarlo nuevamente.</p>
            <p>Si el error perciste consulte con el administrador de la pagina.</p>

            <a href="index.php" class="w3-button w3-round w3-red w3-margin-bottom"><i class="fa fa-arrow-left"></i> volver</a>
         </div>

      </div>
   </div>

   ';

if (isset($resultado)) {

   if (!$resultado['error']){
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

