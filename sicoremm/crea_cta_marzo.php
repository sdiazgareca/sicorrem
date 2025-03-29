<?php
include('DAT/conf.php');
include('DAT/bd.php');


$sql ="SELECT contratos.titular, emi_par_b_imp.e_comp, emi_par_b_imp.e_total,contratos.num_solici
FROM
contratos
INNER JOIN emi_par_b_imp ON emi_par_b_imp.e_nro = contratos.titular
LEFT JOIN cta ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici AND cta.fecha_mov > '2011-02-01'
WHERE fecha_mov IS NULL AND (contratos.estado ='400' || contratos.estado ='500' || contratos.estado ='3500' )
GROUP BY contratos.num_solici";

$query = mysql_query($sql);

while($fecha = mysql_fetch_array($query)){

    $corr = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante, cod_mov,afectacion,fecha_mov,fecha_vto, importe, cobrador, num_solici,fecha,debe,haber,rendicion)
                      VALUES ('1','".$fecha['titular']."','B','50','".$fecha['e_comp']."','1',0,'2011-03-01','2011-03-01', '".$fecha['e_total']."', '10','".$fecha['num_solici']."','2011-03-01','".$fecha['e_total']."','0',NULL)";


        echo $corr.';<br />';


}

?>