<?php
include 'main.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];


if (isset($_POST['submit_create'])) {

      $conexion = connection("try");

      if($conexion['status']){
         $conexion = connection("con");

         $new_empleado = [
            "user_id"  => $_POST['user_id'],
            "nombre"   => $_POST['nombre'],
            "apellido" => $_POST['apellido'],
            "edad"     => $_POST['edad'],
            "ci"       => $_POST['CI'],
            "email"    => $_POST['email'],
            "empresa"  => $_POST['empresa'],
            "cargo"    => $_POST['cargo'],
         
         ];

         if(!$new_empleado['empresa']){
            $new_empleado['empresa'] = 'N/A';
         }

         if(!$new_empleado['cargo']){
            $new_empleado['cargo'] = 'N/A';
         }

         $consultaSQL = "INSERT INTO empleados(`user_id`, `nombre`, `apellido`, `edad`, `cedula`, `email`, `empresa`, `cargo`) ";

         $consultaSQL .= "VALUES (:" . implode(", :", array_keys($new_empleado)) . ")";
     
         $insert = $conexion->prepare($consultaSQL);
         
         try{
            if($insert->execute($new_empleado)){
               $resultado = [
                  'error' => false,
                  'mensaje' => 'El  registro fue añadido correctamente.'
               ];
            }
         } catch(Exception $error){
            $resultado = [
               'error' => true,
               'mensaje' => $error->getMessage()
            ];
         }

         /*
         if($insert->execute($new_empleado)){
            $resultado = [
               'error' => false,
               'mensaje' => 'El  registro fue añadido correctamente.'
            ];
         }
         */

      } else{
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
         echo '<title>Registro exitoso</title>'; 
      }else{
         echo '<title>Error en el registro</title>';
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