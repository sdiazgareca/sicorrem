<?php
/*
 * CUENTA CORRIENTE
 */
date_default_timezone_set('UTC'); 

class Cta {

    public $tip_doc;
    public $nro_doc;
    public $tipo_comp;
    public $serie;
    public $comprovante;
    public $cod_mov;
    public $corta_mov;
    public $larga_mov;
    public $afectacion;
    public $fecha_mov;
    public $fecha_vto;
    public $importe;
    public $cobrador;
    public $num_solici;
    public $fecha;
    public $debe;
    public $haber;
    public $rendicion;

    function constructor($nro_doc,$tipo_comp,$comprovante,$cod_mov,$corta_mov,$larga_mov,$fecha_vto,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion){

        $this->tip_doc = 1;
        $this->nro_doc = $nro_doc;
        $this->tipo_comp = $tipo_comp;
        $this->serie = 50;
        $this->comprovante = $comprovante;
        $this->cod_mov = $cod_mov;
        $this->corta_mov = $corta_mov;
        $this->larga_mov = $larga_mov;
        $this->fecha_vto = $fecha_vto;
        $this->importe = $importe;
        $this->cobrador = $cobrador;
        $this->num_solici = $num_solici;
        $this->fecha = $fecha;
        $this->debe = $debe;
        $this->haber = $haber;
        $this->rendicion = $rendicion;
    }

    function MuestraCta($num_solici,$nro_doc){
?>



<?php



            $sql ="SELECT DATE_FORMAT(cta.fecha,'%d-%m-%Y') AS fecha,cobrador,cta.tipo_comp, serie, comprovante, DATE_FORMAT(fecha_mov,'%d-%m-%Y') AS fecha_mov,  debe, haber, t_mov.corta, afectacion,cta.rendicion
                    FROM cta
                    LEFT JOIN  t_mov ON t_mov.codigo = cta.cod_mov
                    WHERE num_solici = '".$num_solici."' AND nro_doc='".$nro_doc."'
                    ORDER BY YEAR(fecha_mov),MONTH(fecha_mov),DAY(fecha_mov),comprovante,serie,cta.cod_mov";

            //echo $sql.'<br />';

            $query = mysql_query($sql);

            $cuenta = '<div style="width:900px;height:300px;overflow:auto;">
               <table class="table">
                <tr>
                <th><strong>CUOTA</strong></th>
                <th><strong>COMPROBANTE</strong></th>
                <th><strong>FECHA_MOV</strong></th>
                <th><strong>FECHA</strong></th>
                <th><strong>COB</strong></th>
                <th><strong>DEBE</strong></th>
                <th><strong>HABER</strong></th>
                <th><strong>SALDO</strong></th>
                <th><strong>RENDICION</strong></th>
                </tr>';

            while($cta = mysql_fetch_array($query)){

               if ($cta['afectacion'] < 1  ){
                   $clase = 'class="rojo"';
               }

               if ($cta['afectacion'] > 0  ){
                $clase =' class="azul"';
               }

               $cuenta = $cuenta.'<tr><td '.$clase.'>'.$cta['corta'].'</td><td '.$clase.'>'.$cta['serie'].'  -  '.$cta['tipo_comp'].'  -  '.$cta['comprovante'].'</td><td '.$clase.'>'.$cta['fecha_mov'].'</td><td '.$clase.'>'.$cta['fecha'].'</td>';

                if($cta['corta'] == 'PEND'){

                $haber = $haber + $cta['haber'];
                $debe = $debe;
                }
                else{

                $haber = $haber + $cta['haber'];
                $debe = $debe + $cta['debe'];
                }

                $cuenta = $cuenta.'<td '.$clase.'>'.$cta['cobrador'].'</td><td '.$clase.'>'.number_format($cta['debe'],"0",",",".").'</td><td '.$clase.'>'.number_format($cta['haber'],"0",",",".").'</td>';



                $saldo = ($debe - $haber);

                if($saldo < 0){
                    $saldo = $saldo * -1;
                }

                $cuenta = $cuenta.'<td '.$clase.'>'.number_format($saldo,"0",",",".").'</td>';
                $cuenta = $cuenta.'<td '.$clase.'>'.$cta['rendicion'].'</td>';
                $cuenta = $cuenta.'</tr>';
                }

                $cuenta = $cuenta.'</table></div>';

                echo '<h1>SALDO $ '.number_format($saldo,"0",",",".").'</h1>';

                echo $cuenta;

    }


    function EditaCta($comprovante){

            $sql ="SELECT cta.DEV,cod_mov,operador,importe,nro_doc,cta.num_solici,DATE_FORMAT(cta.fecha,'%d-%m-%Y') AS fecha,cobrador,cta.tipo_comp, serie, comprovante, DATE_FORMAT(fecha_mov,'%d-%m-%Y') AS fecha_mov,  debe, haber, t_mov.corta, afectacion,cta.rendicion
                    FROM cta
                    LEFT JOIN  t_mov ON t_mov.codigo = cta.cod_mov
                    WHERE comprovante = '".$comprovante."' ORDER BY num_solici";


            //echo $sql;

            $query = mysql_query($sql);

echo '<div style="width:930px;height:500px;overflow:auto;">';

$id = 1;

            while($cta = mysql_fetch_array($query)){
                
               if ($cta['afectacion'] < 1  ){
                   $clase = 'class="rojo"';
               }

               if ($cta['afectacion'] > 0  ){
                $clase =' class="azul"';
               }

$cuenta = $cuenta.'<form action="RCOP/E_BOL.php" method="post" id="#form_'.$id.'" class="poto">';
               $cuenta =$cuenta.'

               <table class="table" style="width:800px;">
                <tr>
                <th><strong>TITULAR</strong>
                <th><strong>CONT</strong></th>
                <th><strong>CUOTA</strong></th>
                <th><strong>COD</strong></th>
                <th><strong>COMP</strong></th>
                <th><strong>TIPO</strong></th>
                <th><strong>FECHA_MOV</strong></th>
                <th><strong>FECHA</strong></th>
                <th><strong>COB</strong></th>
                <th><strong>IMPORTE</strong></th>
                <th><strong>REND</strong></th>
                <th>DEV</th>
                <th></th>
                </tr>';


               $cuenta = $cuenta.'<tr>
                                    <td style="display:none;"><input type="text" name="cod_mov" value="'.$cta['cod_mov'].'" /></td>
                                    <td style="display:none;"><input type="text" name="operador" value="'.$cta['operador'].'" /></td>
                                    <td '.$clase.'><input size="7" type="text" value="'.$cta['nro_doc'].'" readonly="readonly" name="nro_doc" /></td>
                                   
                                    <td '.$clase.'><input size="5" type="text" value="'.$cta['num_solici'].'" readonly="readonly" name="num_solici" /></td>
                                    <td '.$clase.'>'.$cta['corta'].'</td>';

if($cta['cod_mov'] != 1){

$cuenta = $cuenta.'<td>';
$cuenta = $cuenta.'<select name="cod_mov2">';


$tipo_sql ="SELECT codigo, corta, larga, operador FROM t_mov WHERE operador ='H' AND codigo != '53' AND codigo != '60' AND codigo != '88' AND codigo != '91' AND codigo != '97' ";
$tipo_query = mysql_query($tipo_sql);

$cuenta = $cuenta.'<option value="'.$cta['cod_mov'].'">'.$cta['cod_mov'].'</option>';

 while($tip = mysql_fetch_array($tipo_query)){
 
    $cuenta = $cuenta.'<option value="'.$tip['codigo'].'">'.$tip['corta'].'</option>';
    
    
}

$cuenta = $cuenta.'</select></td>';
}

else{
    $cuenta = $cuenta.'<td></td>';
}
$cuenta = $cuenta.'

                                    <td '.$clase.'><input type="text" value="'.$cta['comprovante'].'" readonly="readonly" size="3" name="comprovante" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['tipo_comp'].'" size="3" name="tipo_comp" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['fecha_mov'].'" readonly="readonly" size="5" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['fecha'].'" size="10" name="fecha" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['cobrador'].'" size="2" name="cobrador" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['importe'].'" size="5" name="importe" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['rendicion'].'" size="5" name="rendicion" /></td>
                                    <td '.$clase.'><input type="text" value="'.$cta['DEV'].'" size="2" name="DEV" /></td>';

                                    if ($cta['operador'] == 'D'){

                                        $cuenta = $cuenta.'<td><table><tr><td><strong>Editar</strong></td><td><input type="radio" name="opcion" value="editar" /></td></tr><tr><td><strong>Eliminar</strong></td><td><input type="radio" name="opcion" value="eliminar"></td></tr><tr><td><a href="RCOP/E_BOL.php?imprimir=1&num_solici='.$cta['num_solici'].'&titular='.$cta['nro_doc'].'&comprovante='.$cta['comprovante'].'">Enviar a Mascom</a></td></tr></table></td>';

                                     }
                                     else {
                                         $cuenta = $cuenta.'<td><table><tr><td><strong>Editar</strong></td><td><input type="radio" name="opcion" value="editar" /></td></tr><tr><td><strong>Eliminar</strong></td><td><input type="radio" name="opcion" value="eliminar"></td></tr></table></td>';

                                     }

                                     $cuenta = $cuenta.'<td><input type="submit" value="Aceptar" /></td>';

                $cuenta = $cuenta.'</tr></table></form>';
                $id ++;

                }

              
                $cuenta = $cuenta.'</div>';

                //echo '<h1>SALDO $ '.number_format($saldo,"0",",",".").'</h1>';

                echo $cuenta;

    }

    function BuscaBoletasCobrador($anio,$mes,$cobrador,$dia){

        ?>
<script type="text/javascript">
$(document).ready(function() {

$(' td:contains("ZONA")').parent().addClass('verde');
$('td:contains("OFICINA")').parent().addClass('azul');
$('td:contains("PENDIENTE")').parent().addClass('rojo');

});

</script>

<?php
$s1 = explode("-",$_POST['cierre1']);
$s2 = explode("-",$_POST['cierre2']);
$s3 = explode("-",$_POST['cierre3']);

$termino = $s3[2].'-'.$s3[1];

$sierre1 = $s1[2].'-'.$s1[1].'-'.$s1[0];
$sierre2 = $s2[2].'-'.$s2[1].'-'.$s2[0];
$sierre3 = $s3[2].'-'.$s3[1].'-'.$s3[0];

/*
                $fbaja_sql = "UPDATE contratos SET contratos.f_ingreso='0000-00-00' 
                              WHERE contratos.estado='400' || estado ='500' || estado='3500'";
*/
        $fbaja_query = mysql_query($fbaja_sql);

        $boletas_sql = "SELECT  t_mov.operador,cod_mov, PERIOD_DIFF(".$anio.$mes.",DATE_FORMAT(fecha,'%Y%m')) AS diferencia,cta.DEV,contratos.estado,contratos.f_baja,DATE_FORMAT(cta.fecha,'%d-%m-%Y') AS fecha,cta.fecha AS comp,DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') AS periodo,cta.comprovante,cta.cobrador AS cob_rend,cobrador.codigo AS cob_asig, DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, contratos.titular, titulares.nombre1, titulares.apellido, contratos.num_solici, contratos.d_pago, e_contrato.descripcion AS est, cta.importe, cta.afectacion
                        FROM contratos
                        INNER JOIN titulares ON titulares.nro_doc = contratos.titular
                        INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
                        INNER JOIN ZOSEMA ON ZOSEMA.ZO= contratos.ZO AND ZOSEMA.SE=contratos.SE AND ZOSEMA.MA=contratos.MA
                        INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador
                        LEFT JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                        INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
                        WHERE cta.DEV = 0 AND (cta.cobrador ='".$cobrador."' || ZOSEMA.cobrador='".$cobrador."') AND contratos.estado !='700' AND contratos.estado !='800'
                        ORDER BY fecha DESC";

  
        // echo $boletas_sql.'<br />';

   $NOMI_q = mysql_query($boletas_sql);
   $numm = mysql_num_rows($NOMI_q);
   $rut = new Datos;
//echo $boletas_sql;

   ?>
   <div style="overflow: auto; width: 910px; height: 250px; ">  <table class="table">

       <tr>
       <th><strong>RUT_CONT</strong></th>
       <th><strong>DV</strong></th>
       <th><strong>N_CONT</strong></th>
       <th><strong>F_INGRESO</strong></th>
       <th><strong>COB ASIG</strong></th>
       <th><strong> N </strong></th>
       <th><strong>COB REND</strong></th>
       <th><strong>PERIODO</strong></th>
       <th><strong>FECHA PAGO</strong></th>
       <th><strong>ESTADO</strong></th>
       <th><strong>IMPORTE</strong></th>
       <th><strong>DETALLE</strong></th>
       <th><strong>F BAJA</strong></th>
       </tr>

<?php
$criterio = $anio.'-'.$mes.'-01';
$cri=strtotime($criterio);

   while ($NOMI = mysql_fetch_array($NOMI_q)){

       $rut_tc = new Datos;
       $rut_tc->validar_rut($NOMI['titular']);
       $fecha = new Datos;

       

        $f_pago =  strtotime($NOMI['comp']);
        $f_corteAn = strtotime($anio.'-'.$mes.'-'.$dia);
        $f_sierre = strtotime($sierre3);

//if( ($NOMI['comp'] <= $sierre3) && ($NOMI['comp'] > $anio.'-'.$mes.'-01') && ($NOMI['afectacion'] > 0) && ($NOMI['cod_mov'] =='1' || $NOMI['cod_mov'] =='53') )  {

       if( (is_numeric($NOMI['afectacion']) == 1) && ($NOMI['afectacion'] > 0) && ($NOMI['operador'] == 'H') && ($f_pago > $f_corteAn ) && ($f_pago <= $f_sierre)  ){


?>
<tr>
<td><?php echo $NOMI['titular'];?></td>
<td><?php echo $rut_tc->dv; ?></td>
<td><?php echo strtoupper($NOMI['num_solici']); ?></td>
<td><?php echo strtoupper(htmlentities($NOMI['f_ingreso'])); ?></td>
<td><?php echo $NOMI['cob_asig']; ?></td>
<td><?php echo $NOMI['comprovante']; ?></td>
<td><?php echo $NOMI['cob_rend']; ?></td>
<td><?php echo $NOMI['periodo']; ?></td>
<td><?php echo $NOMI['fecha']; ?></td>
<td><?php echo $NOMI['est']; ?></td>
<td><?php echo $NOMI['importe']?></td>

<?php
            if (is_numeric($NOMI['afectacion']) == 1 && $NOMI['afectacion'] > 0){
                echo '<td>RENDIDA</td>';


                if ($NOMI['cob_asig'] == $NOMI['cob_rend']){
                    $total_cobrado = $total_cobrado + $NOMI['importe'];
                    $total_entregado = $total_entregado + $NOMI['importe'];

                    if($NOMI['comp'] <= $sierre1){$cobrado1 = $cobrado1 + $NOMI['importe'];}
                    if($NOMI['comp'] <= $sierre2){$cobrado2 = $cobrado2 + $NOMI['importe'];}
                    if($NOMI['comp'] <= $sierre3){$cobrado3 = $cobrado3 + $NOMI['importe'];}
                }

                if ($NOMI['cob_asig'] != $NOMI['cob_rend']){
                    $total_oficina = $total_oficina + $NOMI['importe'];
                }




            }

/*
            if (is_numeric($NOMI['afectacion']) == 1 && $NOMI['afectacion'] < 1){
                echo '<td>PENDIENTE</td>';

                $total = $total + $NOMI['importe'];
                
            }
*/
            if (is_numeric($NOMI['afectacion']) == 0 && $NOMI['afectacion'] == ""){
                echo '<td>NO FACTURADA</td>';
            }

           ?>
            <td><?php echo $NOMI['f_baja']; ?></td>
        </tr>

       <?php

}


       if( (is_numeric($NOMI['afectacion']) == 0 || $NOMI['afectacion'] < 1) && ($NOMI['operador'] == 'D') && ($NOMI['diferencia'] < 3)&& ($NOMI['diferencia'] > -1)){


?>
<tr>
<td><?php echo $NOMI['titular'];?></td>
<td><?php echo $rut_tc->dv; ?></td>
<td><?php echo strtoupper($NOMI['num_solici']); ?></td>
<td><?php echo strtoupper(htmlentities($NOMI['f_ingreso'])); ?></td>
<td><?php echo $NOMI['cob_asig']; ?></td>
<td><?php echo $NOMI['comprovante']; ?></td>
<td><?php echo $NOMI['cob_rend']; ?></td>
<td><?php echo $NOMI['periodo']; ?></td>
<td></td>
<td><?php echo $NOMI['est']; ?></td>
<td><?php echo $NOMI['importe']?></td>

<?php
            if (is_numeric($NOMI['afectacion']) == 0 && $NOMI['afectacion'] < 0){
                echo '<td>PENDIENTE</td>';
            }

             if ($NOMI['cob_asig'] == $NOMI['cob_rend']){
                 echo '<td>PENDIENTE</td>';
                $total_entregado = $total_entregado + $NOMI['importe'];
                $pendiente = $pendiente + $NOMI['importe'];
             }

             if ($NOMI['cob_asig'] != $NOMI['cob_rend']){
                 echo '<td>PENDIENTE</td>';
                $total_oficina = $total_oficina + $NOMI['importe'];
             }


             if (is_numeric($NOMI['afectacion']) == 0 && $NOMI['afectacion'] == ""){
                echo '<td>NO FACTURADA</td>';
             }

           ?>
            <td><?php echo $NOMI['f_baja']; ?></td>
        </tr>

       <?php

}




   }

?>

</table></div>
<br />
<h1>Copagos</h1>
   <div style="overflow: auto; width: 910px; height: 60px; ">
<?php
$nro_cob = "SELECT nro_doc from cobrador where codigo='".$cobrador."'";
$query2 = mysql_query($nro_cob);

$cco = mysql_fetch_array($query2);


$sql ="SELECT copago.boleta, copago.fecha, copago.importe, copago.protocolo, tipo_pago.tipo_pago
FROM copago
INNER JOIN tipo_pago ON tipo_pago.cod = copago.tipo_pago
WHERE copago.cobrador='".$cco['nro_doc']."'";



$query = mysql_query($sql);
?>
       <table class="table2">

               <tr>
               <th>Proto</th>
               <th>Boleta</th>
               <th>Fecha</th>
               <th>Monto</th>
               <th>Desc</th>
               </tr>


               <?php while($cop= mysql_fetch_array($query)){ ?>
                <tr>
                <td><?php echo $cop['protocolo']; ?></td>
               <td><?php echo $cop['boleta']; ?></td>
               <td><?php echo $cop['fecha']; ?></td>
               <td><?php echo $cop['importe']; ?></td>
               <td><?php echo $cop['tipo_pago']; ?></td>
               </tr>
               <?php
               }
               ?>
           
       </table>

   </div>
<br />

<?php

$cobrador = "SELECT apellidos,cobrador.domicilio,cobrador.nombre1, cobrador.nombre2, cobrador.nro_doc, cobrador.s_base, cobrador.email, cobrador.emer_fono
FROM cobrador 
WHERE cobrador.codigo='".$cobrador."'";

$ccobb = mysql_query($cobrador);

$coba = mysql_fetch_array($ccobb);

?>
<br />
<h1>Recaudador <?php echo $coba['apellidos'];?> <?php echo $coba['nombre1'].' '.$coba['nombre2'];?></h1>
<table class="table2">
    <tr>
        <th>Domicilio</th>
        <th><?php echo $coba['domicilio']; ?></th>
        <th>Fono</th>
        <th><?php echo $coba['emer_fono']; ?></th>
        <th>Email</th>
        <th><?php echo $coba['email']; ?></th>
    </tr>
</table>


<br />
<h1>COMISIONES</h1>
<table class="table2">
    <tr>
        <th>TOTAL ENTREGADO</th>
        <td><?php echo $total_entregado; ?></td>

        <th>TOTAL COBRANZA ZONAS</th>
        <td><?php echo $total_cobrado; ?></td>

        <th>TOTAL PENDIENTE</th>
        <td><?php echo $pendiente; ?></td>

        <th>TOTAL COBRANZA OFICINAS OFICINA</th>
        <td><?php echo $total_oficina; ?></td>

        <th>TOTAL COBRADO</th>
        <td><?php echo ($total_oficina + $total_cobrado); ?></td>
        <td><strong><?php echo round($total_cobrado * 10 /  100,1) ; ?> 10%</strong></td>



    </tr>
</table>

<br />
<table class="table2">
    <tr>
    
        <th>TOTAL COBRADO AL <?php echo $_POST['cierre1']; ?></th>
        <td><?php echo $cobrado1; ?></td>
        <td><?php echo round($cobrado1 *  100 / $total_entregado,1) ; ?>%</td>

        <th>TOTAL COBRADO AL <?php echo $_POST['cierre2']; ?></th>
        <td><?php echo $cobrado2; ?></td>
        <td><?php echo  round($cobrado2 *  100 / $total_entregado,1) ; ?>%</td>

        <th>TOTAL COBRADO AL <?php echo $_POST['cierre3']; ?></th>
        <td><?php echo $cobrado3; ?></td>
        <td><?php echo  round($cobrado3 *  100 / $total_entregado,1) ; ?>%</td>

    </tr>

</table>
<?php

//META 1
$meta1 = round($cobrado1 *  100 / $total_entregado,1);
$meta2 = round($cobrado2 *  100 / $total_entregado,1);
$meta3 = round($cobrado3 *  100 / $total_entregado,1);

if ($meta1 >= 60){
    $premio1 = 45000;
}
else{
    $premio1 = 0;

}

if ($meta2 >= 80){
    $premio2 = 30000;
}
else{
    $premio2 = 0;

}

if ($meta3 >= 93){
    $premio3 = 40000;
}
else{
    $premio3 = 0;

}

?>

<br />

<table class="table">

    <tr>
        <th>Premio 1</th>
        <th>Premio 2</th>
        <th>Premio 3</th>
        <th>Loc</th>
        <th>Desc</th>
    </tr>

    <tr>
        <td><?php echo $premio1; ?></td>
        <td><?php echo $premio2; ?></td>
        <td><?php echo $premio3; ?></td>
        <td><?php echo $loc; ?></td>
        <td><?php echo $des; ?></td>
    </tr>


</table>

<p style="font-size: 15px; font-weight: bold; text-align: right;">TOTAL <?php echo (($total_cobrado * 10 /100) + $premio1 + $premio2 + $premio3); ?></p>
        <?

    }


}
?>
