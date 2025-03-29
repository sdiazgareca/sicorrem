<?php


include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


$sql ="SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc, titular
FROM afiliados
WHERE afiliados.cod_baja='00'  ||  afiliados.cod_baja='04' || afiliados.cod_baja='AJ' || afiliados.cod_baja='AZ' || afiliados.cod_baja='DI'
GROUP BY num_solici";

$query = mysql_query($sql);

while ($secuencia = mysql_fetch_array($query) ){

    $con = 'UPDATE contratos SET secuencia="'.$secuencia['secuencia'].'"
        WHERE num_solici="'.$secuencia['num_solici'].'" AND titular="'.$secuencia['titular'].'";';


    if (mysql_query($con)){

        echo $con.'<br />';

    }
    else{
        echo '<br />error<br />';
    }

}

?>


