<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SICOREMM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../CSS/estructura.css" rel="stylesheet" type="text/css" />
<link href="../CSS/fuentes.css" rel="stylesheet" type="text/css" />
<link href="../CSS/menu.css" rel="stylesheet" type="text/css" />
<link href="../CSS/main.css" rel="stylesheet" type="text/css" />
</head>

<body>




<div id="contenedor">
<div id="cabezera">

  <table width="100%">
  <tr>
  <td align="left"><img src="../IMG/L1.jpg" /></td>
  <td align="right">&nbsp;</td>
  </tr>
</table>

</div><!-- cabezera -->

<div class="usuario">&zwj;</div><!-- usuario -->
<div id="contenido">

<?php
/*
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
*/
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');

function fecha_normal_a_mysql($fecha){

    $cambio = explode('-',$fecha);
    $fecha_final = $cambio[2].'-'.$cambio[1].'-'.$cambio[0];
    return $fecha_final;

}

function pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cob,$num_solici,$fecha,$debe,$haber,$rendicion){

    $fecha_mov1 = fecha_normal_a_mysql($fecha_mov);
    $fecha_vto2 = fecha_normal_a_mysql($fecha_vto);
    $fecha3 = fecha_normal_a_mysql($fecha);

    if($rendicion=="" || $fecha_mov1==""||  $cob=="" || $fecha3==""){

        echo $rendicion.'<br />';
        echo $fecha_mov1.'<br />';
        echo $cob.'<br />';
        echo $fecha3.'<br />';

        echo 'Debe llenar los campos Rendicion, Periodo y Fecha';
        exit;
    }


    $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'".$nro_doc."','".$tipo_comp."','50','".$comprovante."','".$cod_mov."','".$afectacion."','".$fecha_mov1."','".$fecha_vto2."','".$importe."','".$cob."','".$num_solici."','".$fecha3."','".$debe."','".$haber."','".$rendicion."')";
    $update ="UPDATE cta SET afectacion='".$afectacion."' WHERE nro_doc='".$nro_doc."' AND cod_mov='1' AND fecha_mov='".$fecha_mov1."'";

    //echo '<br />'.$insert_sql.'<br />';

    $tran = new Datos;
    $query['pago']= $insert_sql;
    $query['afecta']= $update;
    $res = $tran->Trans3($query);
    return $res;

}


if ($_POST['carga'] == 2){

?>
<table class="table" border="1">

    <caption><strong>RESUMEN CARGA MASIVA <?php echo date('d-m-Y'); ?></strong></caption>

    <tr>
        <th>CONTRATO</th>
        <th>FAC</th>
        <th>TITULAR</th>
        <th>APELLIDOS</th>
        <th>NOMBRES</th>
        <th>F_MOV</th>
        <th>COMP</th>
        <th>VALOR</th>
        <th>ESTADO</th>
        <th>ZO</th>
        <th>SE</th>
        <th>MA</th>
        <th>ACCION</th>

    </tr>
<?php

    foreach ($_POST AS $campos => $valor){
    
        
    if( is_numeric($campos) == false && $campos != 'carga'){

         $f_pago = $valor;

     }


     if( is_numeric($campos) == true && $campos != 'carga'){

         $ctacte = explode('/',$valor);

         //pago_cta($nro_doc 1,$tipo_comp 2,$comprovante3,$cod_mov4,$afectacion5,$fecha_mov6,$fecha_vto7,$importe8,$cobrador9,$num_solici10,$fecha11,$debe12,$haber13,$rendicion14)
         $cta = pago_cta($ctacte[0],$ctacte[1],$ctacte[2],$f_pago,$ctacte[2],$ctacte[4],$ctacte[8],$ctacte[5],$ctacte[9],$ctacte[6],$ctacte[8],0,$ctacte[5],$ctacte[7]);


         if($cta == 1){

         $sql ="

         SELECT e_contrato.descripcion AS est,contratos.factu,DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') AS fecha_mov,titulares.nombre1,
         titulares.nombre2, titulares.apellido, t_mov.corta, contratos.titular,contratos.num_solici,
         contratos.f_ingreso,comprovante,valor_plan.valor, ZOSEMA.cobrador, cobrador.codigo AS cod_cob, contratos.ZO, contratos.SE, contratos.MA

         FROM contratos

         INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
         INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
         INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia = contratos.secuencia
         INNER JOIN t_mov ON cta.cod_mov = t_mov.codigo
         INNER JOIN titulares ON titulares.nro_doc = contratos.titular
         INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
         INNER JOIN ZOSEMA ON contratos.ZO = ZOSEMA.ZO AND contratos.SE = ZOSEMA.SE AND contratos.MA = ZOSEMA.MA
         INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador

        WHERE contratos.num_solici='".$ctacte[6]."' AND contratos.titular='".$ctacte[0]."' ORDER BY comprovante";

        $con_query = mysql_query($sql);
        $dat = mysql_fetch_array($con_query);


        ?>

        <tr>
        <td><?php echo $ctacte[6]; ?></td>
        <td><?php echo $ctacte[1]; ?></td>
        <td><?php echo $ctacte[0]; ?></td>
        <td><?php echo $dat['apellido']; ?></td>
        <td><?php echo $dat['nombre1'].' '.$dat['nombre2']; ?></td>
        <td><?php echo $ctacte[4]; ?></td>
        <td><?php echo $ctacte[2]; ?></td>
        <td><?php echo $ctacte[5]; ?></td>
        <td><?php echo strtoupper($dat['est']); ?></td>
        <td><?php echo $dat['ZO']; ?></td>
        <td><?php echo $dat['SE']; ?></td>
        <td><?php echo $dat['MA']; ?></td>
        <td><strong>PROCESADO</strong></td>
        </tr>
            <?php
         }

         if($cta == 0){



                 $sql ="

         SELECT e_contrato.descripcion AS est,contratos.factu,DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') AS fecha_mov,titulares.nombre1,
titulares.nombre2, titulares.apellido, t_mov.corta, contratos.titular,contratos.num_solici,
contratos.f_ingreso,comprovante,valor_plan.valor, ZOSEMA.cobrador, cobrador.codigo AS cod_cob, contratos.ZO, contratos.SE, contratos.MA
FROM contratos
INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia = contratos.secuencia
INNER JOIN t_mov ON cta.cod_mov = t_mov.codigo
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
INNER JOIN ZOSEMA ON contratos.ZO = ZOSEMA.ZO AND contratos.SE = ZOSEMA.SE AND contratos.MA = ZOSEMA.MA
INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador

        WHERE contratos.num_solici='".$ctacte[6]."' AND contratos.titular='".$ctacte[0]."' ORDER BY comprovante";

        $con_query = mysql_query($sql);
        $dat = mysql_fetch_array($con_query);
?>
        <tr>
        <td><?php echo $ctacte[6]; ?></td>
        <td><?php echo $ctacte[1]; ?></td>
        <td><?php echo $ctacte[0]; ?></td>
        <td><?php echo $dat['apellido']; ?></td>
        <td><?php echo $dat['nombre1'].' '.$dat['nombre2']; ?></td>
        <td><?php echo $ctacte[4]; ?></td>
        <td><?php echo $ctacte[2]; ?></td>
        <td><?php echo $ctacte[5]; ?></td>
        <td><?php echo strtoupper($dat['est']); ?></td>
        <td><?php echo $dat['ZO']; ?></td>
        <td><?php echo $dat['SE']; ?></td>
        <td><?php echo $dat['MA']; ?></td>
        <td><strong>Error</strong></td>
        </tr>
 <?php
         }

}
}
?>
     </table>
<?php

}



if ($_POST['carga'] == 1){

?>
<table class="table2" border="1">

    <caption><strong>NOMINA <?php echo date('d-m-Y'); ?></strong></caption>

    <tr>
        <th>CONTRATO</th>
        <th>FAC</th>
        <th>TITULAR</th>
        <th>APELLIDOS</th>
        <th>NOMBRES</th>
        <th>F_MOV</th>
        <th>COMP</th>
        <th>VALOR</th>
        <th>ESTADO</th>
        <th>ZO</th>
        <th>SE</th>
        <th>MA</th>

    </tr>
<?php

    foreach ($_POST AS $campos => $valor){

     if( is_numeric($campos) == false && $campos != 'carga'){

         $f_pago = $valor;

     }

     if($campos != 'carga' && is_numeric($campos)){

         $ctacte = explode('/',$valor);

         //pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion)
         //$cta = pago_cta($ctacte[0],$ctacte[1],$ctacte[2],$f_pago,$ctacte[2],$ctacte[4],$ctacte[4],$ctacte[5],10,$ctacte[6],date('d-m-Y'),0,$ctacte[5],$ctacte[7]);


         $sql ="

         SELECT e_contrato.descripcion AS est,contratos.factu,DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') AS fecha_mov,titulares.nombre1,
         titulares.nombre2, titulares.apellido, t_mov.corta, contratos.titular,contratos.num_solici,
         contratos.f_ingreso,comprovante,valor_plan.valor, ZOSEMA.cobrador, cobrador.codigo AS cod_cob, contratos.ZO, contratos.SE, contratos.MA

         FROM contratos

         INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
         INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
         INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia = contratos.secuencia
         INNER JOIN t_mov ON cta.cod_mov = t_mov.codigo
         INNER JOIN titulares ON titulares.nro_doc = contratos.titular
         INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
         INNER JOIN ZOSEMA ON contratos.ZO = ZOSEMA.ZO AND contratos.SE = ZOSEMA.SE AND contratos.MA = ZOSEMA.MA
         INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador

        WHERE contratos.num_solici='".$ctacte[6]."' AND contratos.titular='".$ctacte[0]."' ORDER BY comprovante";

        $con_query = mysql_query($sql);
        $dat = mysql_fetch_array($con_query);


        ?>

        <tr>
        <td><?php echo $ctacte[6]; ?></td>
        <td><?php echo $ctacte[1]; ?></td>
        <td><?php echo $ctacte[0]; ?></td>
        <td><?php echo $dat['apellido']; ?></td>
        <td><?php echo $dat['nombre1'].' '.$dat['nombre2']; ?></td>
        <td><?php echo $ctacte[4]; ?></td>
        <td><?php echo $ctacte[2]; ?></td>
        <td><?php echo $ctacte[5]; ?></td>
        <td><?php echo strtoupper($dat['est']); ?></td>
        <td><?php echo $dat['ZO']; ?></td>
        <td><?php echo $dat['SE']; ?></td>
        <td><?php echo $dat['MA']; ?></td>
        </tr>
            <?php




}
}
?>
     </table>
<?php

}
?>
</div><!-- contenido -->
</div><!-- contenedor -->
</body>
</html>
