<?php
include('DAT/conf.php');
include('DAT/bd.php');


$sql ="SELECT MIN(afiliados.fecha_ing) AS fecha, titular, num_solici FROM afiliados GROUP BY num_solici, titular";
$query = mysql_query($sql);

while($fecha = mysql_fetch_array($query)){

    $corr = "UPDATE contratos SET contratos.f_ingreso='".$fecha['fecha']."'
            WHERE contratos.titular= '".$fecha['titular']."'
                AND num_solici='".$fecha['num_solici']."'";


        echo $corr.';<br />';


}
?>