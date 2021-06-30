 CRUD (Create Read Update Delete)
### Diego Oropeza

Este es un pequeño proyecto creado con el fin de demostrar mis habilidades como estudiante en el área de programación, durante el periodo de pasantías en la E.T.C.N "Pero Curiel Ramirez", se trata de una aplicación web mediante la cual el usuario puede crear, editar, ver y eliminar registros en una lista de empleados, además cada usuario tiene un código único con el cual identifica cada uno de los registros que realicé en el sistema, de esta forma los usuarios solo podrá editar y eliminar los registros que ellos mismos hagan. Esta característica fue implementada para poder mostrar así una demo del programa mediante una página web hosteada.

# instalacion

A continuacion se describe el paso a paso para realizar la instalacion de la aplicacion y las aplicaciones o programas necesarios para poder utilizar la aplicacion.

## Dependencias

- Servidor: Esta es la única dependencia como tal, este servirá para hostear la página en el ordenador en el cual se usara la aplicación, para que no sea necesario acceder a internet para utilizarlo, ni pagar por un servicio de host online. Existen muchas aplicaciones cuya funcionalidad consiste en abrir un servidor en un ordenador con todo lo necesario para hostear una página web. El servidor debe tener los siguientes plug-ins para poder funcionar correctamente:

  - Apache (host)
  - Mysqsl (Bases de datos)
  -  PHP   (Backend)
  
  Las aplicaciones recomendadas para esta tarea son:
    - [XAMPP](https://www.apachefriends.org/es/index.html)
    - [WAMP server](https://www.wampserver.com/en/)
    - [MAMP](https://www.mamp.info/en/windows/)
 
  Una vez instalado alguno de estos software podrás proceder con los pasos para instalar la aplicación...

## Pasos para instalar la aplicación

Una vez con todo los programas necesarios estén instalados, se puede proceder a instalar la aplicación como tal para su uso. Cabe destacar que esta se debe correr desde un navegador web.
1. Lo primero es descargar el archivo comprimido (.zip): Esto es posible desde el repositorio oficial o desde algún link proporcionado por el autor.
2. A continuación descomprimiremos el archivo
3. Luego de esto se debe copiar la carpeta (completa) de la aplicación para pegarla en el directorio donde se albergan las páginas webs en el servidor que descargamos, en este caso en XAMPP el directorio es en "C:/xampp/htdocs"
4. Con esto ya estaría instalada la aplicación, para acceder a esta y utilizarla, basta con dirigirse al localhost mediante un navegador web, con el servidor corriendo en segundo plano.
5. Una vez entre a la interfaz, lo mas seguro es que te de un error, ya que la base de datos no esta instalada aun. Para instalarla, simplemente has click sobre la cabecera de la pagina (la que dice "CRUD") y aparecera un panel con informacion acerca de la aplicacion, en la seccion de "instalacion", habra un boton que dice "instalar" al final (es de color amarillo), con solo darle click a este podras instalar la base de datos facilmente.
6. (opcional) si esto no funciona, simpre puedes copiar el contenido del archivo "DB.sql" que se encuentra en la carpeta DB y pegarlo (para ejecutarlo) en la consola del servidor.
