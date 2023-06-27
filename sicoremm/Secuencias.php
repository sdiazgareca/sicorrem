<?php
/* 
 * CORRIGE LAS SECUENCIAS DE LOS CONTRATOS
 *
 */

include_once('DAT/conf.php');
include_once('DAT/bd.php');

/* CALCULO DE SECUENCIAS */

$sql ="SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
FROM afiliados
WHERE (afiliados.cod_baja='00'  ||  afiliados.cod_baja='AJ' || afiliados.cod_baja='AZ'  ||  afiliados.cod_baja='04')
GROUP BY num_solici";

$query = mysql_query($sql);

    while ($secuencia = mysql_fetch_array($query)){


    $con = 'UPDATE contratos SET secuencia="'.$secuencia['secuencia'].'"
        WHERE num_solici="'.$secuencia['num_solici'].'"';

      $q = mysql_query($con);

      echo $con.';<br />';

    }
