<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');



//LISTADO NOMINAS EMPRESAS

$cons = "?periodo=".$_POST['periodo'];

$periodo = explode('-',$_POST['periodo']);
$f_periodo = $periodo[2].'-'.$periodo[1].'-'.$periodo[0];

if($_POST['CATEGORIA'] == 'BCI'){
    $cond ="WHERE mandato = '016'";
    $cons = $cons."&MPA_M=1";
}

if($_POST['CATEGORIA'] == 'OB'){
    $cond ="WHERE mandato != '016' AND mandato !='012'";
    $cons = $cons."&MPA_M=2";
}

if($_POST['CATEGORIA'] == 'BE'){
    $cond ="WHERE mandato ='012'";
    $cons = $cons."&MPA_M=3";
}


if ($_POST['titular'] != ''){

    $titu ="AND titular = '".$_POST['titular']."'";
    $cons = $cons."&titular=".$_POST['titular'];
}

if ($_POST['num_solici'] != ''){

    $num_sol ="AND num_solici = '".$_POST['num_solici']."'";
    $cons = $cons."&num_solici=".$_POST['num_solici'];

}

if ($_POST['bancos'] !=''){

    $ban = "AND bancos.codigo='".$_POST['bancos']."'";

}

if ($_POST['estado'] !=''){

    $esat = "AND contratos.estado='".$_POST['estado']."'";

}

if ($_POST['rut_titular_cta'] != ''){

    $rut_t_c ="AND rut_titular_cta = '".$_POST['rut_titular_cta']."'";
    $cons = $cons."&rut_titular_cta=".$_POST['rut_titular_cta'];
}


    echo '<h1>MANDATOS</h1>';

    if ($_POST['d_pago'] != 'TODOS'){
        $condicion = "AND d_pago ='".$_POST['d_pago']."'";
        $cons = $cons."&d_pago=".$_POST['d_pago'];
    }
    else {
        $condicion ="";
        $cons = $cons."&d_pago=TODOS";
    }

    $cons = $cons."&f_periodo=".$f_periodo;

$NOMI_SQL = "SELECT DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, contratos.titular, titulares.nombre1, titulares.apellido, contratos.num_solici, contratos.d_pago, bancos.descripcion, bancos.mandato, doc_f_pago.rut_titular_cta, doc_f_pago.titular_cta, doc_f_pago.apellidos, e_contrato.descripcion AS est, cta.importe, cta.afectacion
FROM contratos
INNER JOIN doc_f_pago ON doc_f_pago.numero = contratos.doc_pago
INNER JOIN bancos ON bancos.codigo = doc_f_pago.banco
INNER JOIN titulares ON titulares.nro_doc = contratos.titular
INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
LEFT JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc AND cta.fecha_mov='".$f_periodo."' AND cta.cod_mov='1'
            ".$cond." ".$condicion." ".$esat." ".$titu."  ".$num_sol." ".$ban." ".$rut_t_c."  ORDER BY num_solici";


//echo $NOMI_SQL;
?>



<?
   $NOMI_q = mysql_query($NOMI_SQL);

   $numm = mysql_num_rows($NOMI_q);

   if ($numm > 0){
       ?>
       <p><a href="BUSQ/G_MAND_1.php<?php echo $cons; ?>" class="boton2">Genenerar Archivo</a></p>
       <?php
       }

   $rut = new Datos;
   ?>
   <table class="table">
       <tr>
       <th><strong>RUT_CONT</strong></th>
       <th><strong>DV</strong></th>
       <th><strong>N_CONT</strong></th>
       <th><strong>D_PA</strong></th>
       <th><strong>RUT_TC</strong></th>
       <th><strong> NOMBRE</strong></th>
       <th><strong>APELLIDOS</strong></th>
       <th><strong>BANCO</strong></th>
       <th><strong>ESTADO</strong></th>
       <th><strong>F_INGRESO</strong></th>
       <th><strong>IMPORTE</strong></th>
       <th><strong>DETALLE</strong></th>
       </tr>
   <?php

   while ($NOMI = mysql_fetch_array($NOMI_q)){
      
       $rut_tc = new Datos;
       $rut_tc->validar_rut($NOMI['titular']);
       $fecha = new Datos;


       ?>
        <tr>

            <td><?php echo $NOMI['titular'];?></td>
            <td><?php echo $rut_tc->dv; ?></td>
            <td><?php echo strtoupper($NOMI['num_solici']); ?></td>
            <td><?php echo strtoupper($NOMI['d_pago']); ?></td>
            <td><?php echo $NOMI['rut_titular_cta']; ?></td>
            <td><?php echo strtoupper($NOMI['titular_cta']); ?></td>
            <td><?php echo strtoupper(htmlentities($NOMI['apellidos'])); ?></td>
            <td><?php echo strtoupper(htmlentities($NOMI['descripcion'])); ?></td>
            <td><?php echo strtoupper(htmlentities($NOMI['est'])); ?></td>
            <td><?php echo strtoupper(htmlentities($NOMI['f_ingreso'])); ?></td>
            <td><?php echo $NOMI['importe']?></td>

            <?php
            if (is_numeric($NOMI['afectacion']) == 1 && $NOMI['afectacion'] > 0){
                echo '<td>PAGADA</td>';
            }

            if (is_numeric($NOMI['afectacion']) == 1 && $NOMI['afectacion'] < 1){
                echo '<td>PENDIENTE</td>';
            }

            if (is_numeric($NOMI['afectacion']) == 0 && $NOMI['afectacion'] == ""){
                echo '<td>NO FACTURADA</td>';
            }
?>
        </tr>
       <?php

   }
   ?>
   </table>

