<?php
$conexion = mysql_connect (HOST,USUARIO,CLAVE) or die ("No se puede conectar con el servidor, compruebe que el nombre de usuario y contraseña sean correctos");
mysql_select_db (BD) or die ("No se puede seleccionar la base de datos.  Es probable que la BD no exista");
mysql_query("SET NAMES 'utf8'");
?>