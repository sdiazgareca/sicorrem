<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; EMISION.xls");
header("Pragma: no-cache");
header("Expires: 0");
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SICOREMM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<body>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Fecha_1.php');


$fecha = new Fecha_1($_POST['periodo']);


//echo $fecha->mes_palabras;

//LISTADO NOMINAS EMPRESAS
if ($_POST['empresa']){

   $NOMI_SQL = "SELECT empresa.copago,empresa.empresa as nom_empresa,planes.desc_plan,contratos.cod_plan, contratos.tipo_plan,contratos.ajuste,DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,
       e_contrato.descripcion AS des_estado,valor_plan.valor,contratos.num_solici,contratos.f_ingreso,contratos.secuencia,titulares.nro_doc, titulares.nombre1, titulares.nombre2, titulares.apellido
                FROM contratos

                LEFT JOIN titulares ON contratos.titular = titulares.nro_doc
                LEFT JOIN planes ON planes.cod_plan = contratos.cod_plan AND planes.tipo_plan = contratos.tipo_plan
                LEFT JOIN e_contrato ON contratos.estado = e_contrato.cod
                LEFT JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia=contratos.secuencia
                INNER JOIN empresa ON empresa.nro_doc = contratos.empresa
                WHERE contratos.empresa='".$_POST['empresa']."' AND 
                contratos.f_ingreso < '".$fecha->mysql."' AND
                (contratos.estado = '400'  || contratos.estado = '500' || contratos.estado = '3500' || contratos.estado = '1000') ORDER BY contratos.num_solici";


   //echo $NOMI_SQL;
   //echo '<br />NOMINA<br />';
   //echo '<br />'.$NOMI_SQL.'<br />';

   $NOMI_q = mysql_query($NOMI_SQL);

   $rut = new Datos;
   ?>
    <div><img src="http://192.168.116.130/sicoremm/IMG/L1.jpg" /><br /><br /><strong>Rescate Médico Movil</strong></div>

<?php
$nom2 = mysql_fetch_array($NOMI_q);



?>


<div>

<table class="table">
    
<caption><h3>NOMINA AFILIADOS <?php echo $nom2['nom_empresa']; ?> <br /><?php echo strtoupper ($fecha->mes_palabras).', '.$fecha->anio;?></h3></caption>    
 
       <tr>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>Nº CONT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>FECHA</strong><br /><strong>INGRESO</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>RUT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>NOMBRE</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>CANT</strong><br /><strong>INTEG.</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>$ PLAN</strong></th>


       </tr>
   <?php

   while ($NOMI = mysql_fetch_array($NOMI_q)){

       $rut->validar_rut($NOMI['nro_doc']);
       $fecha = new Datos;


       ?>
        <tr>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['num_solici']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['f_ingreso']; ?></td>
            <td style="border:1px solid #000000;"><?php echo $rut->nro_doc; ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['apellido']).' '.htmlentities($NOMI['nombre1']).' '.htmlentities($NOMI['nombre2']); ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['secuencia']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['valor'] + $NOMI['ajuste']; ?></td>
        </tr>


<?php
$total = $total + $NOMI['valor'] + $NOMI['ajuste'];

?>
        
       <?php

   }
   ?>
   <tr>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th style="border:1px solid #000000;"><strong>TOTAL</strong></th>
       <th style="border:1px solid #000000;"><?php echo $total;?></th>
   </tr>

   </table>
</div>



<?php

$fecha2 = new Fecha_1($_POST['periodo']);

   $NOMI_SQL2 = "SELECT empresa.empresa as nom_empresa,planes.desc_plan,contratos.cod_plan, contratos.tipo_plan,contratos.ajuste,DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,
       e_contrato.descripcion AS des_estado,valor_plan.valor,contratos.num_solici,contratos.f_ingreso,contratos.secuencia,titulares.nro_doc, titulares.nombre1, titulares.nombre2, titulares.apellido
                FROM contratos

                LEFT JOIN titulares ON contratos.titular = titulares.nro_doc
                LEFT JOIN planes ON planes.cod_plan = contratos.cod_plan AND planes.tipo_plan = contratos.tipo_plan
                LEFT JOIN e_contrato ON contratos.estado = e_contrato.cod
                LEFT JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia=contratos.secuencia
                INNER JOIN empresa ON empresa.nro_doc = contratos.empresa
                WHERE contratos.empresa='".$_POST['empresa']."' AND MONTH(contratos.f_baja) = '".$fecha2->mes."' AND YEAR(contratos.f_baja)='".$fecha2->anio."' AND
                (contratos.estado != '400'  || contratos.estado != '500' || contratos.estado != '3500' || contratos.estado != '1000') ORDER BY contratos.num_solici";

   //echo '<br />NOMINA BAJAS<br />';
   //echo '<br />'.$NOMI_SQL2.'<br />';

   $q2 = mysql_query($NOMI_SQL2);
   ?>

<br /><br />

<div>
<table class="table">
    
<caption style="text-align:left"><strong>DESVINCULACION</strong></caption>    
    
       
       <tr>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>Nº CONT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>FECHA</strong><br /><strong>INGRESO</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>RUT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>NOMBRE</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>CANT</strong><br /><strong>INTEG.</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>$ PLAN</strong></th>
       </tr>
   <?php

   while ($NOMI = mysql_fetch_array($q2)){

       $rut->validar_rut($NOMI['nro_doc']);


       ?>
        <tr>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['num_solici']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['f_ingreso']; ?></td>
            <td style="border:1px solid #000000;"><?php echo $rut->nro_doc; ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['apellido']).' '.htmlentities($NOMI['nombre1']).' '.htmlentities($NOMI['nombre2']); ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['secuencia']); ?></td>

            <td><?php echo $NOMI['valor'] + $NOMI['ajuste']; ?></td>


<?php
 $total2= $total2 + $NOMI['valor'] + $NOMI['ajuste'];


?>
        </tr>
       <?php

   }
   ?>
   <tr>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th style="border:1px solid #000000;"><strong>TOTAL</strong></th>
       <th style="border:1px solid #000000;"><strong><?php echo $total2;?></strong></th>
   </tr>

</table>

</div>





<?php

$fecha3 = new Fecha_1($_POST['periodo']);


$NOMI_SQL = "SELECT empresa.copago,empresa.empresa as nom_empresa,planes.desc_plan,contratos.cod_plan, contratos.tipo_plan,contratos.ajuste,DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,
       e_contrato.descripcion AS des_estado,valor_plan.valor,contratos.num_solici,contratos.f_ingreso,contratos.secuencia,titulares.nro_doc, titulares.nombre1, titulares.nombre2, titulares.apellido
                FROM contratos

                LEFT JOIN titulares ON contratos.titular = titulares.nro_doc
                LEFT JOIN planes ON planes.cod_plan = contratos.cod_plan AND planes.tipo_plan = contratos.tipo_plan
                LEFT JOIN e_contrato ON contratos.estado = e_contrato.cod
                LEFT JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia=contratos.secuencia
                INNER JOIN empresa ON empresa.nro_doc = contratos.empresa
                WHERE contratos.empresa='".$_POST['empresa']."' AND 
                month(contratos.f_ingreso) = '".$fecha3->mes."' AND year(contratos.f_ingreso) = '".$fecha3->anio."' AND
                (contratos.estado = '400'  || contratos.estado = '500' || contratos.estado = '3500' || contratos.estado = '1000') ORDER BY contratos.num_solici";


   //echo $NOMI_SQL;
   //echo '<br />NOMINA<br />';
   //echo '<br />'.$NOMI_SQL.'<br />';

   $NOMI_q = mysql_query($NOMI_SQL);

   $rut = new Datos;
   ?>

<?php
$nom2 = mysql_fetch_array($NOMI_q);



?>
<br /><br />


<div>

<table class="table">
    

<caption style="text-align:left"><strong>INCORPORACION</strong></caption>       
    
       <tr>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>Nº CONT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>FECHA</strong><br /><strong>INGRESO</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>RUT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>NOMBRE</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>CANT</strong><br /><strong>INTEG.</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>$ PLAN</strong></th>
       </tr>
    
   <?php

   while ($NOMI = mysql_fetch_array($NOMI_q)){

       $rut->validar_rut($NOMI['nro_doc']);
       $fecha = new Datos;


       ?>
        <tr>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['num_solici']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['f_ingreso']; ?></td>
            <td style="border:1px solid #000000;"><?php echo $rut->nro_doc; ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['apellido']).' '.htmlentities($NOMI['nombre1']).' '.htmlentities($NOMI['nombre2']); ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['secuencia']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['valor'] + $NOMI['ajuste']; ?></td>


<?php
$total3 = $total3 + $NOMI['valor'] + $NOMI['ajuste'];


?>
        </tr>
       <?php

   }
   ?>
   <tr>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th style="border:1px solid #000000;"><strong>TOTAL</strong></th>
       <th style="border:1px solid #000000;"><strong><?php echo $total3;?></strong></th>
   </tr>

   </table>
</div>










<br />



<?php

$del = new Fecha_1($_POST['del']);
$al =  new Fecha_1($_POST['al']);

$listPlan_sql ="
SELECT fichas.correlativo, copago.boleta,tipo_pago.tipo_pago,DATE_FORMAT(copago.fecha,'%d-%m-%Y') AS fecha,
copago.importe, fichas.paciente,copago.folio_med, fichas.paciente,fichas.nro_doc,fichas.num_solici,
titulares.nombre1 AS nom_t, titulares.apellido AS ape_t, contratos.titular,
empresa.empresa
FROM copago
INNER JOIN fichas ON fichas.correlativo = copago.protocolo
INNER JOIN tipo_pago ON copago.tipo_pago = tipo_pago.cod
INNER JOIN contratos ON contratos.num_solici = fichas.num_solici AND copago.numero_socio = contratos.num_solici
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
INNER JOIN empresa ON empresa.nro_doc = contratos.empresa
WHERE contratos.empresa='".$_POST['empresa']."' AND copago.fecha BETWEEN '".$del->mysql."' AND '".$al->mysql."' 
AND copago.importe>0   
ORDER BY copago.folio_med,copago.boleta";


//echo $listPlan_sql;

$query9 = mysql_query($listPlan_sql);
?>

<?php
if ($_POST['del'] != '' && $_POST['al'] != ''){
    
?>
<div>

    
<table class="table">
    
    
<caption style="text-align:left"><strong>COPAGOS</strong></caption>     
       <tr>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>Nº COPAGO</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>FECHA ATENCION</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>NOMBRE</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>RUT</strong></th>
       <th style="border:1px solid #000000; background-color: #C0C0C0"><strong>VALOR</strong></th>


       </tr>
   <?php

   while ($NOMI = mysql_fetch_array($query9)){

       $rut->validar_rut($NOMI['nro_doc']);
       $fecha = new Datos;


       ?>
        <tr>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['boleta']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['fecha']; ?></td>
            <td style="border:1px solid #000000;"><?php echo htmlentities($NOMI['paciente']); ?></td>
            <td style="border:1px solid #000000;"><?php echo $rut->nro_doc; ?></td>
            <td style="border:1px solid #000000;"><?php echo $NOMI['importe']; ?></td>


<?php
$total4 = $total4 + $NOMI['importe'];


?>
        </tr>
       <?php

   }
   ?>
   <tr>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th style="border:1px solid #000000;"><strong>TOTAL</strong></th>
       <th style="border:1px solid #000000;"><strong><?php echo $total4;?></strong></th>
   </tr>

   </table>
    
</div>

<?php
}
?>


    <?php
  
$genera = $total + $total2 +$total3 + $total4;
    ?>
<br /><br />
<table class="table">
    <tr><th></th><th></th><th></th><th style="border:1px solid #000000; background-color: #C0C0C0"><strong>TOTAL A PAGAR</strong></th><th style="border:1px solid #000000; background-color: #C0C0C0"><strong><?php echo $genera; ?></strong></th></tr>

</table>
    

<br /><br />
<br /><br />
<div>
<table>
    <tr><th></th><th></th><th></th><th style="border-top:1px solid #000000;"><strong>DEPARTAMENTO DE COBRANZA</strong></th><th></th></tr>
    <tr><th></th><th></th><th></th><th><strong>ReMM - Rescate Médico Móvil</strong></th><th></th></tr>    

</table>
</div>




<?php
}
?>












































</body>
</html>
