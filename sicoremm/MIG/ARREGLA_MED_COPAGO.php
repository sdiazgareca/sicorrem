<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


$query = "SELECT afiliados.nro_doc,afiliados.obra_numero,fichas.correlativo, afiliados.num_solici, afiliados.nro_doc, fichas.correlativo, fichas.cod_plan, fichas.tipo_plan
    FROM afiliados INNER JOIN fichas ON fichas.nro_doc = afiliados.nro_doc
         WHERE afiliados.cod_plan ='W71'AND afiliados.tipo_plan ='2' AND afiliados.num_solici > 0 AND afiliados.nro_doc > 0 AND fichas.cod_plan='W71' AND fichas.tipo_plan ='2' AND afiliados.categoria=1";


$query_med = mysql_query($query);

while ($afi = mysql_fetch_array($query_med)){

$copago = "UPDATE copago SET numero_socio='".$afi['num_solici']."'
              WHERE protocolo='".$afi['correlativo']."';";

    $fichas = "UPDATE fichas SET num_solici='".$afi['num_solici']."', isapre='".$afi['obra_numero']."' WHERE num_solici='".$afi['num_solici']."' AND nro_doc='".$afi['nro_doc']."';";

    $copago = "UPDATE copago SET numero_socio='".$afi['num_solici']."' WHERE protocolo='".$afi['correlativo']."';";

    echo $copago.'<br />';
    echo $fichas.'<br />';
    echo $copago.'<br />';


}


/*
$afiliados_q ="SELECT copago.protocolo, numero_socio,fichas.nro_doc
               FROM copago
               INNER JOIN fichas ON fichas.correlativo = copago.numero_socio
               WHERE cod_plan ='W71' AND tipo_plan ='2'";


$afiliados_query = mysql_query($afiliados_q);

while ($afi = mysql_fetch_array($afiliados_query)){

    $query = "SELECT num_solici, afiliados.cod_parentesco, afiliados.obra_numero FROM afiliados
        WHERE nro_doc='".$afi['nro_doc']."'";
    $query_s = mysql_query($query);

    $num_solici = mysql_fetch_array($query_s);

    $copago = "UPDATE copago SET numero_socio='".$num_solici['num_solici']."'
              WHERE protocolo='".$afi['protocolo']."';";

    $fichas = "UPDATE fichas SET num_solici='".$num_solici['num_solici']."', isapre='".$num_solici['obra_numero']."' WHERE correlativo='".$afi['protocolo']."' AND nro_doc='".$afi['nro_doc']."';";

    echo $copago.'<br />';

    echo $fichas.'<br />';

}
 *
 *
 */