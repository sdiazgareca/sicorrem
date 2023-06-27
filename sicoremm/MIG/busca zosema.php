<?php

define ('HOST','192.168.168.30');
define ('USUARIO','root');
define ('CLAVE','cuchitalinda');
define ('BD','sicoremm2');

$conexion = mysql_connect (HOST,USUARIO,CLAVE) or die ("No se puede conectar con el servidor, compruebe que el nombre de usuario y contraseña sean correctos");
mysql_select_db (BD) or die ("No se puede seleccionar la base de datos.  Es probable que la BD no exista");

$SQL ="SELECT zona, seccion, manzana, nro_doc, num_solici FROM domicilios WHERE zona IS NOT NULL AND manzana IS NOT NULL AND num_solici > 0";

$QUERY = mysql_query($SQL);

while ($mat = mysql_fetch_array($QUERY)){

$domy_query = "UPDATE contratos SET zo = '".$mat['zona']."', se='".$mat['seccion']."', ma = '".$mat['manzana']."'

WHERE titular='".$mat['nro_doc']."' AND num_solici ='".$mat['num_solici']."'";

    if ($query_dom = mysql_query($domy_query)){
        echo $domy_query.';</br >';
    }
    else{
        echo $domy_query.';</br >';
    }

}

