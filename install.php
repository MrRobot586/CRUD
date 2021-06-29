<?php
//Script de instalacion con anuncio en caso de error
include 'main.php';

$config = include 'config.php';

try{
  $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $sql = file_get_contents("DB/DB.sql");

  try{
    if($conexion->exec($sql)){
      $resultado = [
        'error' => false,
        'mensaje' => "La base de datos fue creada exitosamente. El programa esta listo para usarse."
      ];
    }
  } catch(Exception $error){
    $resultado = [
      'error' => true,
      'mensaje' => $error->getMessage()
    ];
  }

}catch(PDOException $error){
  $resultado = [
      'error' => true,
      'mensaje' => $error->getMessage()
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
          echo '<title>Instalacion completa</title>'; 
        }else{
          echo '<title>Error en la instalacion</title>';
        }

      }
    ?>
</head>

<body>

<?php
      if (isset($resultado)) {
        if (!$resultado['error']){
          displaymessage("success", $resultado['mensaje']);
        }else{
          displaymessage("error",$resultado['mensaje']);
        }

      }
  ?>

<!---     | Timeuout para el pop up [JS] |     -->
<script type="text/javascript"> setTimeout(popup, 2000); </script>
</body>
</html>