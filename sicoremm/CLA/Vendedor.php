<?php

class Vendedor {

    Function DatosVendedor($vendedor){
        echo '<h1>DATOS DEL VENDEDOR</h1><br />';
	$vende = new Datos;

	$campos = array('nro_doc AS RUT'=>'','nombre1 AS P_NOMBRE'=>'','nombre2 AS S_NOMBRE'=>'','apellidos AS APELLIDOS'=>'','categoria AS CATEGORIA'=>'');
	$where = array('nro_doc'=>' = "'.$vendedor.'"');
	$rut = array('RUT'=>"");
	$vende->Imprimir($campos,"vend",$where,'2',$rut);

    }
}
?>
