<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


$mandatos_sql = "SELECT RUT, NUM_SOLICI, PAGO, RUT_CUENTA, NOMBRE, APELLIDOS, BANCO FROM IMG_MANDATOS";
$mandatos_query = mysql_query($mandatos_sql);

while ($mandatos = mysql_fetch_array($mandatos_query) ){

    $query1 = 'UPDATE contratos SET doc_pago ="'.$mandatos['NUM_SOLICI'].'", f_pago =100, d_pago="'.$mandatos['PAGO'].'" WHERE contratos.num_solici="'.$mandatos['NUM_SOLICI'].'"';

    $query2 = 'INSERT INTO doc_f_pago (apellidos,numero,titular_cta, rut_titular_cta, cta, banco )
                VALUES("'.$mandatos['APELLIDOS'].'","'.$mandatos['NUM_SOLICI'].'","'.$mandatos['NOMBRE'].'","'.$mandatos['RUT_CUENTA'].'","'.$mandatos['NUM_SOLICI'].'","'.$mandatos['BANCO'].'")';

    $query11 = mysql_query($query1);
    $query12 = mysql_query($query2);

    echo $query1.';<br />';
    echo $query2.';<br />';

}


?>
