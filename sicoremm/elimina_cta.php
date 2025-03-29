<?php
include('DAT/conf.php');
include('DAT/bd.php');


$sql ="
SELECT contratos.titular, emi_par_b_imp.e_comp, emi_par_b_imp.e_total,contratos.num_solici, cta.comprovante, cta.fecha_mov,cta.num_solici,cta.nro_doc
FROM
contratos
INNER JOIN emi_par_b_imp ON emi_par_b_imp.e_nro = contratos.titular
LEFT JOIN cta ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici AND cta.fecha_mov = '2011-03-01' AND contratos.f_pago='100'";

$query = mysql_query($sql);

while($fecha = mysql_fetch_array($query)){

    $corr = "DELETE FROM cta WHERE cta.num_solici='".$fecha['num_solici']."' AND cta.nro_doc='".$fecha['nro_doc']."' AND fecha_mov='2011-03-01' AND comprovante='".$fecha['e_comp']."'";


        echo $corr.';<br />';


}

?>
