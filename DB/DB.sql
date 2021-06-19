CREATE DATABASE Empleados_DB;

use Empleados_DB;

CREATE TABLE empleados (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  edad INT(3),
  cedula INT(8),
  email VARCHAR(50) NOT NULL,
  empresa VARCHAR (40) NOT NULL,
  cargo VARCHAR (30) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);