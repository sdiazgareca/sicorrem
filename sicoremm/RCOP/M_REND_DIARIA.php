<?php
date_default_timezone_set('UTC');

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Cobrador.php');
include_once('../CLA/Calendario.php');


$fecha = new Datos();
$fecha_rendicion = $fecha->cambiaf_a_mysql($_POST['periodo9']);

//ZONA DE COBRO

    $sql ="SELECT cobrador.codigo, cobrador.nombre1, cobrador.nombre2, cobrador.apellidos
           FROM cobrador
           INNER JOIN ZOSEMA ON ZOSEMA.cobrador = cobrador.nro_doc
           WHERE cobrador.codigo='".$_POST['cobrador']."'";

   $query = mysql_query($sql);

   $rendicion = mysql_fetch_array($query);
   $fecha_rendicion_normal = $rendicion['fecha'];
   $cod_cobrador = $rendicion['codigo'];
   $nombreApellido = $rendicion['apellidos'].' '.$rendicion['nombre1'].' '.$rendicion['nombre2'];
?>

<h1>RENDICION DE COBRADORES</h1>

<table class="table2">
    <tr>
        <td><strong>FECHA</strong></td>
        <td><?php echo $fecha_rendicion_normal; ?></td>
    </tr>
</table>

<table class="table2">
    <tr>
        <td><strong>COBRADOR N</strong></td>
        <td><?php echo $cod_cobrador; ?></td>
        <td><strong>NOOMBRE Y APELLIDO</strong></td>
        <td><?php echo $nombreApellido; ?></td>
        <td><strong>N REND DIARIA</strong></td>
        <td><?php echo $n_rendicion; ?></td>
    </tr>
</table>


<h1>ZONA</h1>

<?php
/*
foreach ($_POST AS $campo=>$valor){

    echo $campo.' '.$valor.'<br />';

}
*/

$zona_sql ="SELECT afectacion,cta.comprovante, cta.importe, cta.fecha_mov, cobrador.codigo AS cobrador_asignado,cta.cobrador AS cobrador_rend, cta.num_solici,contratos.tipo_plan, contratos.empresa
FROM cta
INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov AND t_mov.operador='H'
INNER JOIN contratos ON contratos.num_solici= cta.num_solici AND contratos.titular= cta.nro_doc
INNER JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
LEFT JOIN cobrador ON ZOSEMA.cobrador = cobrador.nro_doc
WHERE t_mov.codigo !=98 AND t_mov.codigo !=99 AND t_mov.codigo !=100 AND (cobrador.codigo='".$_POST['cobrador']."' || cta.cobrador='".$_POST['cobrador']."') AND fecha='".$fecha_rendicion."'
ORDER BY comprovante";



$zona_query = mysql_query($zona_sql);

while($zona = mysql_fetch_array($zona_query)){

   //echo $zona['cobrador_asignado'].' '.$zona['cobrador_rend'].' '.$zona['comprovante'].'<br />';



/* ZONA DE COBRO COBRADOR */

    //PERIODO ACTUAL COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] != "3" && $zona['fecha_mov'] == $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Actual_comprovante = $periodo_Actual_comprovante.' <div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_actual_total = $periodo_actual_total + $zona['importe'];
        $periodo_Actual_cuenta ++;
    }
    //PERIODO ANTERIOR COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && ($zona['tipo_plan'] != "3") && ($zona['fecha_mov'] < $fecha_rendicion) && ($zona['cobrador_asignado'] == $zona['cobrador_rend']) && ($zona['afectacion'] > 0) ){
        $periodo_Anterior_comprovante = $periodo_Anterior_comprovante.' <div style="font-size: 12px; font-weight: bold; ">'.' '.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anterior_total = $periodo_Anterior_total + $zona['importe'];
        $periodo_Anterior_cuenta ++;
    }

    //PERIODO ANTICIPADO COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] != "3" && $zona['fecha_mov']  > $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Anticipado_comprovante = $periodo_Anticipado_comprovante.' <div style="font-size: 12px; font-weight: bold; ">'.' '.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anticipado_total = $periodo_Anticipado_total + $zona['importe'];
        $periodo_Anticipado_cuenta ++;
    }

/* ZONA DE COBRO COBRADOR */




/* TC O MANDATO */

    //PERIODO ACTUAL COBRADO ZONA PAGADO
    if ( ($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] != "3" && $zona['fecha_mov'] == $fecha_rendicion && $zona['cobrador_asignado'] != $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Actual_comprovante_OT = $periodo_Actual_comprovante_OT.'<div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_actual_total_OT = $periodo_actual_total_OT + $zona['importe'];
        $periodo_Actual_cuenta_OT ++;
    }
    //PERIODO ANTERIOR COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] != "3" && $zona['fecha_mov']  < $fecha_rendicion && $zona['cobrador_asignado'] != $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Anterior_comprovante_OT = $periodo_Anterior_comprovante_OT.'<div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anterior_total_OT = $periodo_Anterior_total_OT + $zona['importe'];
        $periodo_Anterior_cuenta_OT ++;
    }

    /* AREA PROTEGIDA ZONA DE COBRO */

    //PERIODO ACTUAL COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] == "3" && $zona['fecha_mov'] == $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Actual_comprovante_AP = $periodo_Actual_comprovante_AP.'<div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_actual_total_AP = $periodo_actual_total_AP + $zona['importe'];
        $periodo_Actual_cuenta_AP ++;
    }
    //PERIODO ANTERIOR COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] == "3" && $zona['fecha_mov']  < $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Anterior_comprovante_AP = $periodo_Anterior_comprovante_AP.'<div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anterior_total_AP = $periodo_Anterior_total_AP + $zona['importe'];
        $periodo_Anterior_cuenta_AP ++;
    }

    //PERIODO ANTICIPADO COBRADO ZONA PAGADO
    if (($zona['empresa'] == "" || $zona['empresa'] < 1) && $zona['tipo_plan'] == "3" && $zona['fecha_mov']  > $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Anticipado_comprovante_AP = $periodo_Anticipado_comprovante_AP.'<div style="font-size: 12px; font-weight: bold; ">'.' '.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anticipado_total_AP = $periodo_Anticipado_total_AP + $zona['importe'];
        $periodo_Anticipado_cuenta_AP ++;
    }

    /* AREA PROTEGIDA ZONA DE COBRO */


    /* CONVENIOS */

    //PERIODO ACTUAL COBRADO ZONA PAGADO

    if (($zona['empresa'] != "" || $zona['empresa'] > 0) && $zona['tipo_plan'] != "3" && $zona['fecha_mov'] == $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Actual_comprovante_CONV = $periodo_Actual_comprovante_CONV.'<div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_actual_total_CONV = $periodo_actual_total_CONV + $zona['importe'];
        $periodo_Actual_cuenta_CONV ++;
    }
    //PERIODO ANTERIOR COBRADO ZONA PAGADO
    if (($zona['empresa'] != "" || $zona['empresa'] > 0) && $zona['tipo_plan'] != "3" && $zona['fecha_mov']  < $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Anterior_comprovante_CONV = $periodo_Anterior_comprovante_CONV.'<div style="font-size: 12px; font-weight: bold; ">'.' '.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anterior_total_CONV = $periodo_Anterior_total_CONV + $zona['importe'];
        $periodo_Anterior_cuenta_CONV ++;
    }

    //PERIODO ANTICIPADO COBRADO ZONA PAGADO
    if (($zona['empresa'] != "" || $zona['empresa'] > 0) && $zona['tipo_plan'] != "3" && $zona['fecha_mov']  > $fecha_rendicion && $zona['cobrador_asignado'] == $zona['cobrador_rend'] && $zona['afectacion'] > 0){
        $periodo_Anticipado_comprovante_CONV = $periodo_Anticipado_comprovante_CONV.'<div style="font-size: 12px; font-weight: bold; ">'.$zona['comprovante'].' -  $ '.$zona['importe'].' CONTRATO '.$zona['num_solici'].'</div>';
        $periodo_Anticipado_total_CONV = $periodo_Anticipado_total_CONV + $zona['importe'];
        $periodo_Anticipado_cuenta_CONV ++;
    }

    /* AREA PROTEGIDA ZONA DE COBRO */



}

?>

<table class="table2">
    <tr>
        <td><strong>PERIODO ACTUAL</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Actual_cuenta; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_actual_total; ?></td>
    </tr>

    <tr>
        <td><strong>PERIODO ANTERIOR</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Anterior_cuenta; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_Anterior_total; ?></td>
    </tr>

    <tr>
        <td><strong>PAGO ANTICIPADO</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Anticipado_cuenta; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_Anticipado_total; ?></td>
    </tr>

    <tr>
        <th></th>
        <th></th>
        <td><strong>TOTAL</strong></td>
        <td><?php echo ($periodo_Anterior_cuenta + $periodo_Actual_cuenta +$periodo_Anticipado_cuenta); ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo ($periodo_actual_total + $periodo_Anterior_total +$periodo_Anticipado_total); ?></td>
    </tr>
</table>


<h1>Comprobantes Periodo Actual</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Actual_comprovante; ?></td>
    </tr>
</table>

<h1>Comprobantes Periodo Anterior</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Anterior_comprovante; ?></td>
    </tr>
</table>

<h1>Comprobantes Pago Anticipado</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Anticipado_comprovante; ?></td>
    </tr>
</table>

<!-- ******************************************************************************************************************************-->

<br /><br />

<h1>MANDATOS O T/C</h1>
<table class="table2">
    <tr>
        <td><strong>PERIODO ACTUAL</strong></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Actual_cuenta_OT; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_actual_total_OT; ?></td>
    </tr>

    <tr>
        <td><strong>PERIODO ANTERIOR</strong></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Anterior_cuenta_OT; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_Anterior_total_OT;?></td>
    </tr>

    <tr>
        <th></th>
        <td><strong>TOTAL</strong></td>
        <td><?php echo ($periodo_Anterior_cuenta_OT + $periodo_Actual_cuenta_OT); ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo ($periodo_actual_total_OT + $periodo_Anterior_total_OT); ?></td>
    </tr>

</table>

<h1>Comprobantes Periodo Actual</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Actual_comprovante_OT; ?></td>
    </tr>
</table>

<h1>Comprobantes Periodo Anterior</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Anterior_comprovante_OT; ?></td>
    </tr>
</table>


<!-- ***************************************************************************** -->


<h1>AREA PROTEC</h1>
<table class="table2">
    <tr>
        <td><strong>PERIODO ACTUAL</strong></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Actual_cuenta_AP; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_actual_total_AP; ?></td>
    </tr>

    <tr>
        <td><strong>PERIODO ANTERIOR</strong></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Anterior_cuenta_AP; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_Anterior_total_AP; ?></td>
    </tr>

    <tr>
        <td><strong>PAGO ANTICIPADO</strong></td>
        <td><strong>CANT</strong></td>
        <td><?php echo $periodo_Anticipado_cuenta_AP; ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo $periodo_Anticipado_total_AP; ?></td>
    </tr>

    <tr>
        <th></th>
        <td><strong>TOTAL</strong></td>
        <td><?php echo ($periodo_Anterior_cuenta_AP + $periodo_Actual_cuenta_AP +$periodo_Anticipado_cuenta_AP); ?></td>
        <td><strong>IMPORTE</strong></td>
        <td><?php echo ($periodo_actual_total_AP + $periodo_Anterior_total_AP +$periodo_Anticipado_total_AP); ?></td>
    </tr>
</table>


<h1>Comprobantes Periodo Actual</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Actual_comprovante_AP; ?></td>
    </tr>
</table>

<h1>Comprobantes Periodo Anterior</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Anterior_comprovante_AP; ?></td>
    </tr>
</table>

<h1>Comprobantes Pago Anticipado</h1>
<table class="table">
    <tr>
        <td><?php echo $periodo_Anticipado_comprovante_AP; ?></td>
    </tr>
</table>


<!-- ************************************************************************************************************************** -->


<h1>CONVENIOS</h1>
<table class="table2">
    <tr>
        <td><strong>PERIODO ACTUAL</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>CANT</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>IMPORTE</strong></td>
    </tr>

    <tr>
        <td><strong>PERIODO ANTERIOR</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>CANT</strong></td>
        <td><?php echo ""; ?></td>
        <td><strong>IMPORTE</strong></td>
    </tr>
</table>

<h1>Comprobantes Periodo Actual</h1>
<table class="table">
    <tr>
        <td></td>
    </tr>
</table>

<h1>Comprobantes Periodo Anterior</h1>
<table class="table">
    <tr>
        <td></td>
    </tr>
</table>