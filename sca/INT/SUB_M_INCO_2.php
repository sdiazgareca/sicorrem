<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

if ($_POST['n_inco_grat'] =="" || $_POST['sec_anterior'] =="" || $_POST['sec'] ==""){
    echo '<div class="mensaje2">Error</div>';
    exit;
}



if ($_POST['n_inco_grat'] == ($_POST['sec_anterior'] + $_POST['sec'])){
    
 $secuencia = $_POST['sec'] + $_POST['sec_anterior'];
 $monto = $_POST['v_incor'] * $secuencia;
 $query1 =1;

}

 if ($_POST['n_inco_grat'] > ($_POST['sec_anterior'] + $_POST['sec']) ){
    $monto = 0;
    $secuencia = $_POST['sec'];
    $query1=0;
 }

  if ($_POST['n_inco_grat'] < ($_POST['sec_anterior'] + $_POST['sec']) ){
      $secuencia = $_POST['sec'];
      $monto = $_POST['v_incor'] * $secuencia;
      $query1=0;
 }


//echo '<br /><strong>secuencia '.$secuencia.'</strong><br />';

//comprobar secuencia
if($secuencia > 0){
$sql = "SELECT cod_plan, tipo_plan, valor FROM valor_plan WHERE cod_plan ='".$_POST['cod_plan']."' AND tipo_plan='".$_POST['tipo_plan']."' AND valor_plan.secuencia ='".$secuencia."'";
$query = mysql_query($sql);
$numm = mysql_num_rows($query);
$mensu = mysql_fetch_array($query);

}
else{
    $numm =1;
}

$cont = "SELECT cod_pago_venta,des_pago_venta FROM REG_VENTAS WHERE num_solici ='".$_POST['num_solici']."' AND REG_VENTAS.cod_estado_venta = 200 AND REG_VENTAS.cod_cat_venta=200";
$cont_query = mysql_query($cont);
$num_cont = mysql_num_rows($cont_query);

if ($numm < 1 ){
    echo '<div class="mensaje2"><img src="IMG/M1.png" />La secuencia '.$secuencia.' no existe</div>';
    exit;
}

if ($num_cont > 0){
    echo '<div class="mensaje2"><img src="IMG/M1.png" />Existe una incorporacion en curso</div>';
    exit;
}

$fecha = new Datos;
$mes_pago_inicial = $fecha->cambiaf_a_mysql($_POST['ff_f_rendicion']);
$fecha_documento = $fecha->cambiaf_a_mysql($_POST['fecha_documento']);

if($query1 > 0){

$Q = 'INSERT INTO ventas_reg(mes_pago_inicial,num_solici,titular,vendedor,monto,fecha,cat_venta,
    estado_venta,pago_venta,fecha_documento,t_documento,bancos,t_credito,f_ingreso,n_che_tar,rendicion,sec)

        VALUES("'.$mes_pago_inicial.'","'.$_POST['num_solici'].'","'.$_POST['titular'].'",
            "'.$_POST['vendedor'].'","'.$monto.'","'.date('Y-m-d').'","200","200","'.$_POST['ff_fpago'].'",
            "'.$fecha_documento.'","'.$_POST['ff_t_doc'].'","'.$_POST['ff_banco'].'",
            "'.$_POST['ff_t_credito'].'","","'.$_POST['n_che_tar'].'","'.$_POST['rendicion'].'",
            "'.$_POST['sec'].'")';

//echo '<br />1'.$Q.'<br />';
}
else{
$Q = 'INSERT INTO ventas_reg(mes_pago_inicial,num_solici,titular,vendedor,monto,fecha,cat_venta,
    estado_venta,pago_venta,fecha_documento,t_documento,bancos,t_credito,f_ingreso,n_che_tar,rendicion,sec)

        VALUES("'.$mes_pago_inicial.'","'.$_POST['num_solici'].'","'.$_POST['titular'].'",
            "'.$_POST['vendedor'].'","'.$monto.'","'.date('Y-m-d').'","200","200","60",
            "'.$fecha_documento.'","'.$_POST['ff_t_doc'].'","'.$_POST['ff_banco'].'",
            "'.$_POST['ff_t_credito'].'","","'.$_POST['n_che_tar'].'","'.$_POST['rendicion'].'",
            "'.$_POST['sec'].'")';
//echo '<br />2'.$Q.'<br />';
}

if (mysql_query($Q)){
    echo '<div class="mensaje1"><img src="IMG/M2.png" /><strong>Valor Almacenado</strong></div>';
    $rut = new Datos;
    $rut->validar_rut($_POST['titular']);
?>

<h1>Detalle</h1>
<div class="mensaje1">
<table class="table">

    <tr>
        <td><strong>N_CONTR</strong></td><td><?php echo $_POST['num_solici']; ?></td>
        <td><strong>RUT TITULAR</strong></td><td><?php echo $rut->nro_doc; ?></td>
        <td><strong>RUT VENDEDOR</strong></td><td><?php echo $_POST['vendedor']; ?></td>
        <td><strong>VALOR</strong></td><td><?php echo $monto; ?></td>
        <td><strong>MENSUALIDAD</strong></td><td><?php echo $mensu['valor']; ?></td>


    </tr>

</table>
</div>
<?php
}
else{
    echo '<div class="mensaje">Error.. compruebe la secuencia</div>';
}

?>