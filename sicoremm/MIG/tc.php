<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


$mandatos_sql = "SELECT RUT,NUM_SOLICI, D_PAGO, COD_TAR, N_TARJETA FROM IMG_TC";
$mandatos_query = mysql_query($mandatos_sql);

while ($mandatos = mysql_fetch_array($mandatos_query) ){

        $query2 = 'INSERT INTO doc_f_pago (numero,apellidos,titular_cta, rut_titular_cta, cta, t_credito )
                VALUES("'.$mandatos['NUM_SOLICI'].'","'.$mandatos['APELLIDOS'].'","'.$mandatos['NOMBRE'].'","'.$mandatos['RUT'].'","'.$mandatos['NUM_SOLICI'].'","'.$mandatos['COD_TAR'].'")';

    $query1 = 'UPDATE contratos SET doc_pago ="'.$mandatos['NUM_SOLICI'].'", f_pago =200, d_pago="'.$mandatos['PAGO'].'" WHERE contratos.num_solici="'.$mandatos['NUM_SOLICI'].'"';

   // $query12 = mysql_query($query2);

    //$query11 = mysql_query($query1);


    echo $query1.';<br />';
    echo $query2.';<br />';

}


?>