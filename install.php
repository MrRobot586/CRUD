<?php

$config = include 'config.php';

try {
  $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  $sql = file_get_contents("DB/DB.sql");
  
  $conexion->exec($sql);

  echo "La base de datos fue instalada con éxito. La plataforma web ya esta lista para trabajar.";
} catch(PDOException $error) {
  echo $error->getMessage();
}