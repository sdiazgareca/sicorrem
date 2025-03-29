<?php
include('DAT/conf.php');
include('DAT/bd.php');


$sql ="SELECT afectacion, fecha_mov, fecha_vto, importe, num_solici, nro_doc, comprovante FROM cta WHERE afectacion > 0 AND cod_mov = 1";
$query = mysql_query($sql);

while($fecha = mysql_fetch_array($query)){

    $corr = "update cta SET cta.fecha_mov='".$fecha['fecha_mov']."', cta.fecha_vto='".$fecha['fecha_vto']."'
            WHERE num_solici='".$fecha['num_solici']."' AND nro_doc='".$fecha['nro_doc']."'
            AND comprovante='".$fecha['comprovante']."' AND cod_mov=51";

    
        echo $corr.';<br />';
    

}

?>
