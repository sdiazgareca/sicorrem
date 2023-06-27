<?php

define ('HOST','192.168.168.30');
define ('USUARIO','root');
define ('CLAVE','cuchitalinda');
define ('BD','sicoremm2');

$conexion = mysql_connect (HOST,USUARIO,CLAVE) or die ("No se puede conectar con el servidor, compruebe que el nombre de usuario y contraseña sean correctos");
mysql_select_db (BD) or die ("No se puede seleccionar la base de datos.  Es probable que la BD no exista");

$SQL ="SELECT contratos.num_solici, titular, contratos.ZO, contratos.SE, contratos.MA, contratos.cod_plan, contratos.tipo_plan FROM contratos
    LEFT JOIN domicilios ON nro_doc = titular WHERE domicilios.num_solici=0";

$QUERY = mysql_query($SQL);

while ($mat = mysql_fetch_array($QUERY)){

$domy_query = "UPDATE domicilios SET num_solici = '".$mat['num_solici']."', cod_plan='".$mat['cod_plan']."', tipo_plan = '".$mat['tipo_plan']."'

WHERE nro_doc='".$mat['titular']."' AND num_solici=0";

echo $domy_query.';<br />';

}

?>
