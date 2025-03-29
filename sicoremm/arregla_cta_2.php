<?php
include('DAT/conf.php');
include('DAT/bd.php');


$sql ="SELECT contratos.titular, emi_par_b_imp.e_comp, emi_par_b_imp.e_total,contratos.num_solici
FROM
contratos
INNER JOIN emi_par_b_imp ON emi_par_b_imp.e_nro = contratos.titular
LEFT JOIN cta ON contratos.titular = cta.nro_doc AND contratos.num_solici = cta.num_solici AND cta.fecha_mov > '2011-02-01'
WHERE cta.comprovante = contratos.titular
GROUP BY contratos.num_solici;
";

$query = mysql_query($sql);

while($fecha = mysql_fetch_array($query)){

    $corr = "UPDATE cta SET cta.comprovante='".$fecha['e_comp']."' 
        WHERE cta.num_solici='".$fecha['num_solici']."' AND cta.nro_doc='".$fecha['titular']."' AND comprovante='".$fecha['titular']."'";


        echo $corr.';<br />';


}

?>