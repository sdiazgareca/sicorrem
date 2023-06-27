
<?php
/////////////////////////////////////////////////-------------------------------------------------------------------------------------
if ( ($num < 1000) and ($matriz_resultados['hora_llamado'] > 0) and ($matriz_resultados['hora_despacho'] > 0) and ($matriz_resultados['hora_salida_base'] > 0) and ($matriz_resultados['hora_llegada_domicilio'] > 0) ){
?>
Acci&oacute;n&nbsp;&nbsp;
<select id="destino2_<?php echo $matriz_resultados['correlativo']; ?>" style="width:80px">
<option value="0">&nbsp;</option>
<?php
$query = "select * from destino where accion = 2";
$respuesta = mysql_query($query);
while ($mat2 = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $mat2['cod']; ?>"><?php echo $mat2['destino']; ?></option>
<?
}
?>
</select>


<input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta de realizar los cambios?')){
var destino = document.getElementById('destino2_<?php echo $matriz_resultados['correlativo']; ?>').value;

$ajaxload('bus','Form/Actualizar_ficha20.php?destino='+destino+'&correlativo=<?php echo $matriz_resultados['correlativo']; ?>',false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados2['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
" />
<br /><br />
Diagn&oacute;stico&nbsp;
<select id="diagnosticos_<?php echo $matriz_resultados['correlativo']; ?>" style="width:80px">
<option value="0">&nbsp;</option>
<?php
$query = "select cod, diagnostico from diagnostico order by cod";
$respuesta = mysql_query($query);

while ($diagnostico = mysql_fetch_array($respuesta)){
?>
<option value="<?php echo $diagnostico['cod']; ?>"><?php echo $diagnostico['cod']; ?></option>
<?
}
?>
</select>
<input type="button" value="Aceptar" class="boton" onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var diagnostico = document.getElementById('diagnosticos_<?php echo $matriz_resultados['correlativo']; ?>').value;

$ajaxload('bus','Form/Actualizar_ficha4.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&diagnostico='+diagnostico,false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
" />


<?php 
if ($matriz_resultados['obser_man'] == '45')
{ 
?>
&nbsp;
Hosp&nbsp;
<select style="width:80px;" id="centro_hospi_<?php echo $matriz_resultados2['correlativo'] ;?>">
<option value="0">&nbsp;</option>
<?php
$hospital ="SELECT cod, Lugar FROM centrohospita";
$hospital_q = mysql_query($hospital);
while ($mat_hospi = mysql_fetch_array($hospital_q)){
?>
<option value="<?php echo $mat_hospi['cod']; ?>"><?php echo $mat_hospi['Lugar']; ?></option>
<?php
}
?>
</select>

&nbsp;<input type="button" value="Aceptar" class="boton" 

onclick="
if(confirm('Esta seguro de guardar los cambios?')){

var hospital = document.getElementById('centro_hospi_<?php echo $matriz_resultados2['correlativo'] ;?>').value;

$ajaxload('bus','Form/Actualizar_ficha40.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&hospital='+hospital,false,false,false);

if ($ajaxload){
$ajaxload('bus','Form/formtiempos.php?correlativo=<?php echo $matriz_resultados['correlativo']; ?>&num=<?php echo $num;?>',false,false,false);
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
}
}
"

 />
<?php
}
?>
<br /><br />
<?php
if ( ($matriz_resultados['obser_man'] == 45) || ($matriz_resultados['obser_man'] == 42)){
?>



<table style="width:480px;">
<tr>
<td>Boleta
</td>
<td>
<input style=" width:150px;" type="text" id="boleta_<?php echo $matriz_resultados['correlativo']; ?>" maxlength="9" />
</td>
</tr>
<?php


//ATENCIONES MENSUALES
if($matriz_resultados['cm_gratis'] > 0 && $matriz_resultados['tiempo'] == 'MENSUAL'){

    if($matriz_resultados['cm_gratis'] <= $atencion_mat_m['cantidad']){

        $copago1=0;
        $copago2="S/Copago";

    }
    else{
        $copago1 = $matriz_resultados['copago'];
        $copago2 = '$ '.number_format($matriz_resultados['copago'],0,',','.');
    }

}
//ATENCIONES ANUALES
if($matriz_resultados['cm_gratis'] > 0 && $matriz_resultados['tiempo'] == 'ANUAL'){
    
    if($matriz_resultados['cm_gratis'] <= $atencion_mat['cantidad']){
    
        $copago1=0;
        $copago2="S/Copago";
    
    }
    else{
        $copago1 = $matriz_resultados['copago'];
        $copago2 = '$ '.number_format($matriz_resultados['copago'],0,',','.');
    }
    
}
//OTROS
if($matriz_resultados['cm_gratis'] < 1 && $matriz_resultados['tiempo'] == 'NO'){
    
        $copago1 = $matriz_resultados['copago'];
        $copago2 = '$ '.number_format($matriz_resultados['copago'],0,',','.');
}



//MEDIMEL
if($matriz_resultados['cod_plan']=='W71' && $matriz_resultados['tipo_plan']=='2'){

    $f_pago1 ='4';
    $f_pago2 ='MEDIMEL';

}
else{
//COMPROBAR EMPRESA
$emp_sql = "SELECT empresa.copago
            FROM contratos
            INNER JOIN empresa ON empresa.nro_doc = contratos.empresa
            WHERE contratos.num_solici='".$matriz_resultados['num_solici']."'";

//echo $emp_sql;

$emp_que = mysql_query($emp_sql);
$emp = mysql_fetch_array($emp_que);

if ($emp['copago'] == 1){

    $f_pago1 ='5';
    $f_pago2 ='DESC. X PLANILLA';

}
}


 ?>

<tr>
<td>Importe</td>
<td>
<select id="importe_<?php echo $matriz_resultados['correlativo']; ?>" style="width:150px; color:#069; font-size:14px;">
<option value="<?php echo $copago1; ?>"><?php echo $copago2; ?></option>
<?php
$sql = "SELECT codigo FROM v_copagos ORDER BY codigo";
$query = mysql_query($sql);
while ($v_cop = mysql_fetch_array($query)){

    
    echo '<option value="'.$v_cop['codigo'].'">$	'.$v_cop['codigo'].'</option>';
}
?>
<option value="14000">$	14.000</option>
<option value="0">S/Copago</option>
</select>
</td>
</tr>

<tr>
<td>Tipo de Pago</td>
<td>
<select name="tipopago" id="tipo_pago<?php echo $matriz_resultados['correlativo']; ?>">


  <option value="<?php echo $f_pago1;?>"><?php echo $f_pago2;?></option>
  <option value="1">EFECTIVO</option>
  <option value="2">CHEQUE</option>
  <option value="3">PENDIENTE</option>
  <option value="4">CASOS ESPECIALES</option>
  <option value="5">DESC. X PLANILLA</option>
  <option value="4">MEDIMEL</option>
  <option value="4">VIP PLATINIUM</option>
  <option value="4">VIP DORADO</option>
  <option value="4">ASISTENCIA INTEGRAL</option>  
  <option value="11">S/COPAGO</option>      
</select>
</td>
</tr>

<tr>
<td>Folio MED N&ordm;</td>
<td><input style=" width:150px;" type="text" id="med_<?php echo $matriz_resultados['correlativo']; ?>" maxlength="9" /></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>

<?php
if (($matriz_resultados['obser_man'] == 42) and ($matriz_resultados['hora_sale_domicilio'] > 0) and ($matriz_resultados['diagnostico']) ){
?>
<div align="right"><input type="button" value="GUARDAR" class="boton" id="guardar_<?php echo $matriz_resultados['correlativo']; ?>" / onclick="
var boleta= document.getElementById('boleta_<?php echo $matriz_resultados['correlativo']; ?>').value;
var importe= document.getElementById('importe_<?php echo $matriz_resultados['correlativo']; ?>').value;
var tipo_pago =document.getElementById('tipo_pago<?php echo $matriz_resultados['correlativo']; ?>').value;
var folio_med = document.getElementById('med_<?php echo $matriz_resultados['correlativo']; ?>').value;


if( (!boleta) || (!importe) || (!tipo_pago) ){
alert('Debe llenar los campos numero de boleta e importe');
}
else{
if(confirm('Esta seguro de finalizar el llamado')) {
$ajaxload('bus','Form/guardar_form.php?boleta='+boleta+'&importe='+importe+'&tipo_pago='+tipo_pago+'&movil=<?php echo $matriz_resultados['movil']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nsocio=<?php echo $matriz_resultados['num_solici']; ?>&folio_med='+folio_med,'Cargando',false,false);
}
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
" ></div>
<?php
}
?>

<?php
if (($matriz_resultados['obser_man'] == 45) and ($matriz_resultados['hora_sale_destino'] > 0) and ($matriz_resultados['diagnostico'])and ($matriz_resultados['CentroHospitalario']) ){
?>
<div align="right"><input type="button" value="GUARDAR" class="boton" id="guardar_<?php echo $matriz_resultados['correlativo']; ?>" / onclick="
var boleta= document.getElementById('boleta_<?php echo $matriz_resultados['correlativo']; ?>').value;
var importe= document.getElementById('importe_<?php echo $matriz_resultados['correlativo']; ?>').value;
var tipo_pago =document.getElementById('tipo_pago<?php echo $matriz_resultados['correlativo']; ?>').value;
var folio_med = document.getElementById('med_<?php echo $matriz_resultados['correlativo']; ?>').value;


if( (!boleta) || (!importe) || (!tipo_pago) ){
alert('Debe llenar los campos numero de boleta e importe');
}
else{
if(confirm('Esta seguro de finalizar el llamado')) {
$ajaxload('bus','Form/guardar_form.php?boleta='+boleta+'&importe='+importe+'&tipo_pago='+tipo_pago+'&movil=<?php echo $matriz_resultados['movil']; ?>&correlativo=<?php echo $matriz_resultados['correlativo']; ?>&nsocio=<?php echo $matriz_resultados['num_solici']; ?>&folio_med='+folio_med,'Cargando',false,false);
}
}
$ajaxload('der', 'PHP/main.php?actualizar=1','<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);
" ></div>
<?php
}

}
?>
</td>
</tr>
</table>



<?php
}//FIN IF COM PURBEA
?>