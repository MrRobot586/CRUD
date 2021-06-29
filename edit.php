<?php
include 'main.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (isset($_POST['submit_update'])) {
   $conexion = connection("try");

      if($conexion['status']){
         $conexion = connection("con");

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

         if(!$update_empleado['empresa']){
            $update_empleado['empresa'] = 'N/A';
         }

         if(!$update_empleado['cargo']){
            $update_empleado['cargo'] = 'N/A';
         }

         $consultaSQL = "UPDATE empleados SET nombre = '". $update_empleado['nombre'] ."', apellido = '". $update_empleado['apellido'] ."', edad = '". $update_empleado['edad'] ."', cedula = '". $update_empleado['ci'] ."', email = '". $update_empleado['email'] ."', empresa = '". $update_empleado['empresa'] ."', cargo = '". $update_empleado['cargo'] ."', updated_at = NOW() WHERE id = ". $update_empleado['id'] ." ;";
  
         $update = $conexion->prepare($consultaSQL);

         try{
            if($update->execute()){
               $resultado = [
                  'error' => false,
                  'mensaje' => 'El registro ha sido actualizado satisfactoriamente.'
               ];
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
   <?php
   if (isset($resultado)) {

      if (!$resultado['error']){
         echo '<title>Registro actualizado</title>'; 
      }else{
         echo '<title>Error al actualizar</title>';
      }

   }
   ?>


</head>
<body>
     
<?php

if (isset($resultado)) {

   if (!$resultado['error']){
        displaymessage('success',$resultado['mensaje']); 
   }else{
      displaymessage('error',$resultado['mensaje']);
   }

}
?>
 <!---     | Timeuout para el pop up [JS] |     -->
   <script type="text/javascript"> setTimeout(popup, 2000); </script>

</body>
</html>

